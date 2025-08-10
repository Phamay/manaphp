<?php

namespace App\Controllers;

use ManaPHP\Ws\Attribute\MessageMapping;
use ManaPHP\Ws\Message;
use ManaPHP\Ws\Router\Attribute\WebSocketMapping;

#[WebSocketMapping('/echo')]
class EchoController extends Controller
{
    #[MessageMapping]
    public function messageAction(Message $message)
    {
        //    $this->wsServer->push($fd, $data);
        return $this->response->setContent($message->getPayload());
    }
}
