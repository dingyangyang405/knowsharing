<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

class TopicController extends BaseController
{
    public function indexAction()
    {
        $userId = 1;
        $topics = $this->getTopicService()->findAllTopics();
        $followedTopics = $this->getFollowTopicService()->findFollowedTopicsByUserId($userId);
        $topics = $this->getFollowTopicService()->hasFollowedTopics($topics,$userId);

        return $this->render('AppBundle:Topic:index.html.twig', array(
            'topics' => $topics
        ));
    }

    public function followAction(Request $request, $id)
    {
        $this->getFollowTopicService()->followTopic($id);

        return new JsonResponse(true);
    }

    public function unFollowAction(Request $request, $id)
    {
        $this->getFollowTopicService()->unFollowTopic($id);

        return new JsonResponse(true);
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

    protected function getFollowTopicService()
    {
        return $this->biz['follow_topic_service'];
    }
}