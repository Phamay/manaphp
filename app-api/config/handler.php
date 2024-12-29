<?php
declare(strict_types=1);

return [
    'ManaPHP\Http\HandlerInterface' => [
        'middlewares' => [
            \ManaPHP\Http\Middlewares\RequestIdMiddleware::class,
            \ManaPHP\Http\Middlewares\MappingValidatorMiddleware::class,
        ],
    ],
];