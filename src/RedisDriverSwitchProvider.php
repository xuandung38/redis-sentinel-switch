<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RedisDriverSwitchProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/redis-switch.php', 'redis-switch');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../../config/redis-switch.php' => config_path('redis-switch.php')], 'config');
        }

        $this->overWriteConfig();
    }

    public function overWriteConfig()
    {
        $redisConfig = [
            'client' => config('database.redis.client'),
        ];

        $replication = config('redis-switch.replication');
        $sentinelHost = config('redis-switch.sentinel');

        if ($replication === 'sentinel' && !empty($sentinelHost)) {
            $redisConfig['default'] = [
                [
                    'host' => config('database.redis.default.host'),
                    'port' => config('database.redis.default.port'),
                    'role' => 'master',
                ],
                $sentinelHost,
                'options' => [
                    'replication' => $replication,
                    'service' => config('redis-switch.service'),
                    'timeout' => config('redis-switch.timeout'),
                    'sentinel_timeout' =>  config('redis-switch.sentinel_timeout'),
                    'parameters' => [
                        'password' => config('database.redis.default.password'),
                        'database' => config('database.redis.default.database'),
                    ],
                    'prefix' => config('database.redis.options.prefix'),
                ],
            ];

            $redisConfig['cache'] = [
                [
                    'host' => config('database.redis.cache.host'),
                    'port' => config('database.redis.cache.port'),
                    "role" => "master",
                ],
                $sentinelHost,
                'options' => [
                    'replication' => $replication,
                    'service' => config('redis-switch.service'),
                    'timeout' => config('redis-switch.timeout'),
                    'sentinel_timeout' =>  config('redis-switch.sentinel_timeout'),
                    'parameters' => [
                        'password' => config('database.redis.cache.password'),
                        'database' => config('database.redis.cache.database'),
                    ],
                    'prefix' => config('database.redis.options.prefix'),
                ],
            ];

            config(["database.redis" => $redisConfig]);
        }
    }
}
