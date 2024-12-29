<?php

declare(strict_types=1);

namespace App\Controllers;

use ManaPHP\Http\ResponseInterface;
use ManaPHP\Http\Router\Attribute\GetMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;

#[RequestMapping('/index')]
class IndexController extends Controller
{
    #[GetMapping(['/', 'hello'])]
    public function helloAction(): ResponseInterface
    {
        return $this->response->json(['code' => 0, 'msg' => '', 'data' => 'Hello ManaPHP']);
    }
}
