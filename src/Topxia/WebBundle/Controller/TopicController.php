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
        $topics = $this->getTopicService()->findAllTopics();
        $followedTopics = $this->getFollowTopicService()->findFollowedTopics();
        $followedTopicsId = array();
        foreach ($followedTopics as $value) {
            $followedTopicsId[] = $value['objectId'];
        }
        foreach ($topics as $key => $topic) {
            $topics[$key]['hasFollowed'] = false;
            if (in_array($topic['id'], $followedTopicsId)) {
                $topics[$key]['hasFollowed'] = true;
            }
        }

        return $this->render('TopxiaWebBundle:Topic:topic.html.twig',array(
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
        return $this->getServiceKernel('topic_service');
    }

    protected function getFollowTopicService()
    {
        return $this->getServiceKernel('follow_topic_service');
    }
}