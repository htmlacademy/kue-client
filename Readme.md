HTML Academy Services API
============

###1 KueApi
####1.1 Basic usage
```
$api = new \Service\KueApi();
$api->job('job-type', [
    'param1' => 'value1',
    'param2' => 'value2'
]);
```
####1.2 Advanced usage

#####1.2.1 Configuration
```
$config = [
  'scheme' => 'http',
  'host'   => 'localhost',
  'port'   => 3000,
  'api'    => '/api'
];
$api = new \Service\KueApi($config);
```
#####1.2.1 Job parameters
```
public int KueApi::job(string $type[, array $data [, mixed $startAt [, string $priority [, int $attempts]]]]):mixed;
```
*Parameters*
**type** - type of created job
**data** - additional data for job
**startAt** - string formatted date or DateTime object to specify a delay for executing this job. `null` if job should run immediately (default)
**priority** - priority of the job. Available values `low`, `normal`, `medium`, `high`, `critical`. Default `normal`
**attempts** - count of attempts to execute this job. Default `5`

*Return values*
Returns `id` of created job or `false` if on failure.
