<?php

namespace App\Controllers;

use ManaPHP\Ws\Attribute\CloseMapping;
use ManaPHP\Ws\Attribute\MessageMapping;
use ManaPHP\Ws\Attribute\OpenMapping;
use ManaPHP\Ws\Message;
use ManaPHP\Ws\Router\Attribute\WebSocketMapping;

#[WebSocketMapping('/')]
class IndexController extends Controller
{
    #[OpenMapping]
    public function openAction($fd)
    {
        //        $data = [];
        //        $data['admin_id'] = $this->identity->getId();
        //        $data['admin_name'] = $this->identity->getName();
        //        $data['role'] = $this->identity->getRole();
        //
        //        $token = jwt_encode($data, $ttl, 'pusher.admin');

        $token = $this->request->getToken();
        $this->identity->set(jwt_decode($token, 'pusher.admin'));
    }

    #[CloseMapping]
    public function closeAction($fd)
    {

    }

    #[MessageMapping]
    public function messageAction(Message $message)
    {

    }
}
