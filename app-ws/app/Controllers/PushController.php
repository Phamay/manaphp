<?php

namespace App\Controllers;

use ManaPHP\Ws\Attribute\CloseMapping;
use ManaPHP\Ws\Attribute\OpenMapping;
use ManaPHP\Ws\Router\Attribute\WebSocketMapping;

#[WebSocketMapping('/push')]
class PushController extends Controller
{
    public function startAction()
    {
        $this->wspServer->start();
    }

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
