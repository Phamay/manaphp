<?php

declare(strict_types=1);

namespace App\Controllers;

use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use ManaPHP\Viewing\View\Attribute\ViewMapping;

#[Authorize(Authorize::GUEST)]
#[RequestMapping('/benchmark')]
class BenchmarkController extends Controller
{
    #[ViewMapping('')]
    public function indexAction()
    {

    }
}
