<?php

declare(strict_types=1);

namespace App\Listeners;

class UserActionLogListenerContext
{
    public bool $logged = false;
    public string $handler = '';
    public bool $invoking = false;
}
