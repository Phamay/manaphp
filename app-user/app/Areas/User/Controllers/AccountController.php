<?php

declare(strict_types=1);

namespace App\Areas\User\Controllers;

use App\Controllers\Controller;
use App\Entities\User;
use App\Repositories\UserRepository;
use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Http\CaptchaInterface;
use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\ResponseInterface;
use ManaPHP\Http\Router\Attribute\PostMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use ManaPHP\Viewing\View\Attribute\ViewPostMapping;

#[Authorize(Authorize::GUEST)]
#[RequestMapping('/user/account')]
class AccountController extends Controller
{
    #[Autowired] protected CaptchaInterface $captcha;
    #[Autowired] protected UserRepository $userRepository;

    #[PostMapping]
    public function captchaAction(): ResponseInterface
    {
        return $this->captcha->generate();
    }

    #[ViewPostMapping]
    public function registerAction(string $code, string $password): User
    {
        $this->captcha->verify($code);

        $user = $this->userRepository->fill($this->request->all());

        $user->status = User::STATUS_ACTIVE;
        $user->password = $password;

        return $this->userRepository->create($user);
    }
}
