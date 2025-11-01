<?php

declare(strict_types=1);

namespace App\Interceptors;

use Attribute;
use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Di\Attribute\InterceptorInterface;
use Psr\Log\LoggerInterface;
use ReflectionMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class LogInterceptor implements InterceptorInterface
{
    #[Autowired] protected LoggerInterface $logger;

    public function preHandle(ReflectionMethod $method): bool
    {
        $this->logger->info('invoking interceptor');
        return true;
    }

    public function postHandle(ReflectionMethod $method, mixed &$return): void
    {
        $this->logger->error('invoked interceptor');
    }
}