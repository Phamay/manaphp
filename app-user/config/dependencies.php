<?php
declare(strict_types=1);

return [
    'Psr\Log\LoggerInterface'               => ['class' => 'ManaPHP\Logging\Logger',
                                                'level' => env('LOGGER_LEVEL', 'info')],
    'ManaPHP\Identifying\IdentityInterface' => 'ManaPHP\Identifying\Identity\Adapter\Jwt',
    'ManaPHP\Http\RouterInterface'          => ['prefix' => ''],
    'ManaPHP\Security\CryptInterface'       => ['master_key' => 'dev'],
    'ManaPHP\Http\RequestHandlerInterface'  => [
        'middlewares' => [
            \ManaPHP\Http\Middlewares\RequestIdMiddleware::class,
            \ManaPHP\Http\Middlewares\MappingValidatorMiddleware::class,
        ],
    ],
];