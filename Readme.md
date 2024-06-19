> Репозиторий переехал в [Гитлаб](https://gitlab.htmlacademy.dev/dev/utils/kue-client)

HTML Academy Kue Client
============

###Basic usage
```php
$api = new \KueClient();
$api->job('job-type', [
    'param1' => 'value1',
    'param2' => 'value2'
]);
```
###Advanced usage

#### Configuration
```php
$config = [
    'scheme' => 'http',
    'host'   => 'localhost',
    'port'   => 3000,
    'api'    => '/api'
];
$api = new \KueClient($config);
```
####Job parameters
```php
public int KueClient::job(string $type[, array $data [, mixed $startAt [, string $priority [, int $attempts]]]]);
```
#####Parameters
*type* - type of created job

*data* - additional data for job

*startAt* - string formatted date or DateTime object to specify a delay for executing this job. `null` if job should run immediately (default)

*priority* - priority of the job. Available values `low`, `normal`, `medium`, `high`, `critical`. Default `normal`

*attempts* - count of attempts to execute this job. Default `5`

#####Return values
Returns `id` of created job or `false` if on failure.
