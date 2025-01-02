<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Entities\UserActionLog;
use App\Repositories\UserActionLogRepository;
use ManaPHP\Context\ContextTrait;
use ManaPHP\Db\Event\DbExecuting;
use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Eventing\Attribute\Event;
use ManaPHP\Helper\Arr;
use ManaPHP\Helper\SuppressWarnings;
use ManaPHP\Http\CookiesInterface;
use ManaPHP\Http\RequestInterface;
use ManaPHP\Http\Server\Event\RequestInvoked;
use ManaPHP\Http\Server\Event\RequestInvoking;
use ManaPHP\Identifying\IdentityInterface;
use function json_stringify;
use function str_contains;

class UserActionLogListener
{
    use ContextTrait;

    #[Autowired] protected IdentityInterface $identity;
    #[Autowired] protected RequestInterface $request;
    #[Autowired] protected CookiesInterface $cookies;
    #[Autowired] protected UserActionLogRepository $userActionLogRepository;

    protected function getTag(): int
    {
        foreach ($this->request->all() as $k => $v) {
            if (is_numeric($v)) {
                if ($k === 'id') {
                    return (int)$v;
                } elseif (str_ends_with($k, '_id')) {
                    return (int)$v;
                }
            }
        }

        return 0;
    }

    public function onRequestInvoking(#[Event] RequestInvoking $event): void
    {
        /** @var UserActionLogListenerContext $context */
        $context = $this->getContext();

        $context->invoking = true;
        $context->handler = $event->controller . '::' . $event->action;
    }

    public function onRequestInvoked(#[Event] RequestInvoked $event): void
    {
        SuppressWarnings::unused($event);

        /** @var UserActionLogListenerContext $context */
        $context = $this->getContext();

        $context->invoking = false;
    }

    public function onDbExecuting(#[Event] DbExecuting $event): void
    {
        SuppressWarnings::unused($event);

        /** @var UserActionLogListenerContext $context */
        $context = $this->getContext();
        if ($context->logged) {
            return;
        }

        if ($context->invoking && str_contains($context->handler, '\\Areas\\User\\')) {
            $this->logUserAction();
        }
    }

    public function logUserAction(): void
    {
        /** @var UserActionLogListenerContext $context */
        $context = $this->getContext();
        if ($context->logged) {
            return;
        }
        $context->logged = true;

        $data = Arr::except($this->request->all(), ['_url']);
        if (isset($data['password'])) {
            $data['password'] = '*';
        }
        unset($data['ajax']);

        $userActionLog = new UserActionLog();

        $userActionLog->user_id = $this->identity->isGuest() ? 0 : $this->identity->getId();
        $userActionLog->user_name = $this->identity->isGuest() ? '' : $this->identity->getName();
        $userActionLog->client_ip = $this->request->ip();
        $userActionLog->method = $this->request->method();
        $userActionLog->url = $this->request->path();
        $userActionLog->tag = $this->getTag() & 0xFFFFFFFF;
        $userActionLog->data = json_stringify($data);
        $userActionLog->handler = $context->handler;
        $userActionLog->client_udid = $this->cookies->get('CLIENT_UDID');

        $this->userActionLogRepository->create($userActionLog);
    }
}
