<?php

class KueClient
{
    private $scheme = 'http';
    private $host = 'localhost';
    private $port = '3000';
    private $api = '/api';

    public function __construct($options = [])
    {
        if (!empty($options['host'])) {
            $this->host = $options['host'];
        }
        if (!empty($options['port'])) {
            $this->port = $options['port'];
        }
        if (!empty($options['api'])) {
            $this->api = $options['api'];
        }
        if (!empty($options['scheme'])) {
            $this->scheme = $options['scheme'];
        }
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            'host'   => $this->host,
            'port'   => $this->port,
            'api'    => $this->api,
            'scheme' => $this->scheme
        ];
    }

    public function job($type, $data = [], $start = null, $priority = 'normal', $attempts = 5)
    {
        $job = [
            'type' => $type,
            'data' => $data,
            'options' => [
                'attempts' => $attempts,
                'priority' => $priority
            ]
        ];
        if (!empty($start)) {
            try {
                if (!($start instanceof \DateTime)) {
                    $start = new \DateTime($start);
                }
                $now = new \DateTime();

                $delay = $start->getTimestamp() - $now->getTimestamp();
                if ($delay > 0) {
                    $job['options']['delay'] = $delay * 1000;
                }
            } catch (\Exception $e) {

            }
        }
        return $this->save(json_encode($job));
    }

    private function save($job)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => sprintf(
                '%s://%s:%s/%s/job',
                $this->scheme,
                $this->host,
                $this->port,
                trim($this->api, '/')
            ),
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $job,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($job)
            ]
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        try {
            $result = json_decode($response);
            return empty($result->id) ? false : $result->id;
        } catch (\Exception $e) {
            return false;
        }
    }
}
