<?php

declare(strict_types=1);

namespace App\Controllers;

use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\ResponseInterface;
use ManaPHP\Http\Router\Attribute\GetMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use ManaPHP\Version;
use ManaPHP\Viewing\FlashInterface;
use ManaPHP\Viewing\View\Attribute\ViewMapping;
use function date;

#[Authorize(Authorize::GUEST)]
#[RequestMapping('')]
class IndexController extends Controller
{
    #[Autowired] protected FlashInterface $flash;

    #[GetMapping('/')]
    public function indexAction(): ResponseInterface
    {
        return $this->response->redirect('about');
    }

    #[ViewMapping]
    public function aboutAction(): array
    {
        $vars = [];

        $vars['version'] = Version::get();
        $vars['current_time'] = date('Y-m-d H:i:s');

        $this->flash->error(date('Y-m-d H:i:s'));

        return $vars;
    }
}
