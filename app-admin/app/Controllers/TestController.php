<?php

declare(strict_types=1);

namespace App\Controllers;

use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\Router\Attribute\GetMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use function sleep;

#[Authorize]
#[RequestMapping('/test')]
class TestController extends Controller
{
    #[GetMapping]
    public function indexAction(): void
    {

    }

    #[Authorize(Authorize::GUEST)]
    #[GetMapping]
    public function chunkAction(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->response->write("chunk $i\n");
            sleep(1);
        }
    }
}
