<?php

declare(strict_types=1);

namespace App\Filters;

use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Eventing\Attribute\Event;
use ManaPHP\Exception\ForbiddenException;
use ManaPHP\Http\AuthorizationInterface;
use ManaPHP\Http\Event\RequestAuthorizing;
use ManaPHP\Http\RequestInterface;
use ManaPHP\Http\ResponseInterface;
use ManaPHP\Identifying\Identity\NoCredentialException;
use ManaPHP\Identifying\IdentityInterface;
use function str_contains;

class AuthorizationFilter
{
    #[Autowired] protected AuthorizationInterface $authorization;
    #[Autowired] protected IdentityInterface $identity;
    #[Autowired] protected RequestInterface $request;
    #[Autowired] protected ResponseInterface $response;

    public function onAuthorizing(#[Event] RequestAuthorizing $event): void
    {
        if ($this->authorization->isAllowed($event->controller . '::' . $event->action)) {
            return;
        }

        if ($this->identity->isGuest()) {
            if ($this->request->isAjax()) {
                throw new NoCredentialException('No Credential or Invalid Credential');
            } else {
                $redirect = $this->request->input('redirect', $this->request->url());
                $login_url = str_contains($event->controller, '\\Areas\\Admin\\') ? '/admin/login'
                    : '/user/login';
                $this->response->redirect(["$login_url?redirect=$redirect"]);
            }
        } else {
            throw new ForbiddenException('Access denied to resource');
        }
    }
}
