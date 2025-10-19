<?php
declare(strict_types=1);

return [
    'ManaPHP\Redis\RedisInterface' => new \ManaPHP\Di\Factory([
        'default' => ['uri' => env('REDIS_URL')],
        'redisDb' => '#default',
        'redisCache' => '#default',
        'redisBroker' => '#default',
    ]),
];