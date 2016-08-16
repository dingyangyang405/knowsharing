<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Biz\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function topicKnowledgeAction($id)
    {

    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

    protected function getFollowService()
    {
        return $this->biz['follow_service'];
    }
}