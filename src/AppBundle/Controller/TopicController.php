<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Biz\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\Paginator;

class TopicController extends BaseController
{
    public function indexAction()
    {
        $userId = 1;
        $topics = $this->getTopicService()->findAllTopics();
        $topics = $this->getFollowService()->hasFollowTopics($topics,$userId);

        return $this->render('AppBundle:Topic:index.html.twig', array(
            'topics' => $topics
        ));
    }

    public function followAction($id)
    {
        $this->getFollowService()->followTopic($id);

        return new JsonResponse(true);
    }

    public function unFollowAction($id)
    {
        $this->getFollowService()->unFollowTopic($id);

        return new JsonResponse(true);
    }

    public function topicKnowledgesAction(Request $request, $id)
    {
        $conditions = array('topicId' => $id);
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $request,
            $this->getKnowledgeService()->getKnowledgesCount($conditions),
            20
        );

        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));

        return $this->render('AppBundle:Topic:knowledge.html.twig', array(
            'knowledges' => $knowledges,
            'paginator' => $paginator,
            'users' => $users
        ));
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

    protected function getFollowService()
    {
        return $this->biz['follow_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }
}