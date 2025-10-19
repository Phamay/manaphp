<?php
declare(strict_types=1);

use ManaPHP\Di\Factory;

return [
    'ManaPHP\Db\DbInterface' => new Factory([
        'default' => ['uri' => env('DB_URL')],
    ]),
];