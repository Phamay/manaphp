<?php

namespace App\Controllers;

use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Ws\Attribute\CloseMapping;
use ManaPHP\Ws\Attribute\OpenMapping;
use ManaPHP\Ws\Pushing\ServerInterface;
use ManaPHP\Ws\Router\Attribute\WebSocketMapping;

#[WebSocketMapping('/push')]
class PushController extends Controller
{
    #[Autowired] protected ServerInterface $wspServer;

    #[OpenMapping]
    public function openAction($fd)
    {
        $this->wspServer->open($fd);
    }

    #[CloseMapping]
    public function closeAction($fd)
    {
        $this->wspServer->close($fd);
    }
}
