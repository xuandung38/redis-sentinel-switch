<?php

return [
    'replication' => env('REDIS_REPLICATION', null),
    'sentinel' => env('REDIS_SENTINEL', null),
    'service' => env('REDIS_SENTINEL_SERVICE', 'redis-cluster'),
    'timeout' => env('REDIS_TIMEOUT', 5),
    'sentinel_timeout' => env('REDIS_SENTINEL_TIMEOUT', 0.1),
];
