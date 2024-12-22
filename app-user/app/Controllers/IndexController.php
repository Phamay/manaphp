<?php
declare(strict_types=1);

namespace App\Controllers;

use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\Router\Attribute\GetMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use ManaPHP\Mvc\View\Attribute\ViewMapping;
use ManaPHP\Version;
use function date;

#[Authorize(Authorize::GUEST)]
#[RequestMapping('')]
class IndexController extends Controller
{
    #[GetMapping('/')]
    public function indexAction()
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
