<?php
declare(strict_types=1);

namespace App\Areas\User\Controllers;

use App\Controllers\Controller;
use App\Repositories\UserActionLogRepository;
use ManaPHP\Di\Attribute\Autowired;
use ManaPHP\Http\AuthorizationInterface;
use ManaPHP\Http\Controller\Attribute\Authorize;
use ManaPHP\Http\Router\Attribute\GetMapping;
use ManaPHP\Http\Router\Attribute\RequestMapping;
use ManaPHP\Persistence\Page;
use ManaPHP\Persistence\Restrictions;
use ManaPHP\Viewing\View\Attribute\ViewGetMapping;

#[RequestMapping('/user/action-log')]
class ActionLogController extends Controller
{
    #[Autowired] protected UserActionLogRepository $userActionLogRepository;
    #[Autowired] protected AuthorizationInterface $authorization;

    #[Authorize(Authorize::USER)]
    #[GetMapping]
    public function detailAction(int $id)
    {
        $userActionLog = $this->userActionLogRepository->get($id);

        if ($userActionLog->user_id === $this->identity->getId() || $this->authorization->isAllowed('detail')) {
            return $userActionLog;
        } else {
            return '没有权限';
        }
    }

    #[Authorize(Authorize::USER)]
    #[ViewGetMapping]
    public function latestAction(int $page = 1, int $size = 10)
    {
        $restrictions = Restrictions::of($this->request->all(), ['handler', 'client_ip', 'created_time@=', 'tag']);
        $restrictions->eq('user_id', $this->identity->getId());

        $orders = ['id' => SORT_DESC];
        return $this->userActionLogRepository->paginate($restrictions, [], $orders, Page::of($page, $size));
    }
}