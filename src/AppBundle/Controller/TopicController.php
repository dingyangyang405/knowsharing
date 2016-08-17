<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Biz\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\Paginator;
use AppBundle\Common\ArrayToolKit;

class TopicController extends BaseController
{
    public function indexAction()
    {
        $currentUser = $this->biz->getUser();

        $conditions = array();
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $this->getTopicService()->getTopicsCount($conditions),
            20
        );
        $topics = $this->getTopicService()->searchTopics(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $topics = $this->getFollowService()->hasFollowTopics($topics,$currentUser['id']);

        return $this->render('AppBundle:Topic:index.html.twig', array(
            'topics' => $topics,
            'paginator' => $paginator,
            'type' => 'allTopics'
        ));
    }

    public function followAction(Request $request, $id)
    {
        $user = $this->getCurrentUser();
        $this->getFollowService()->followTopic($user['id'], $id);

        return new JsonResponse(true);
    }

    public function unFollowAction(Request $request, $id)
    {
        $user = $this->getCurrentUser();
        $this->getFollowService()->unFollowTopic($user['id'], $id);

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
        $users = ArrayToolKit::index($users, 'id');
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

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }
}