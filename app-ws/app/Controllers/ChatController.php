<?php

namespace App\Controllers;

use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Ws\Attribute\CloseMapping;
use ManaPHP\Ws\Attribute\OpenMapping;
use ManaPHP\Ws\Chatting\ServerInterface;
use ManaPHP\Ws\Router\Attribute\WebSocketMapping;

#[WebSocketMapping('/chat')]
class ChatController extends Controller
{
    #[Autowired] protected ServerInterface $chatServer;

    public function startAction()
    {
        $this->chatServer->start();
    }

    #[OpenMapping]
    public function openAction($fd)
    {
        $this->chatServer->open($fd, $this->request->input('room_id', 'meeting'));
    }

    #[CloseMapping]
    public function closeAction($fd)
    {
        $this->chatServer->open($fd, $this->request->input('room_id', 'meeting'));
    }
}
