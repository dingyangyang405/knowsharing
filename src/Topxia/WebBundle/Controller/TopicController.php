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
        $followedTopicIds = array();
        foreach ($followedTopics as $value) {
            $followedTopicIds[] = $value['objectId'];
        }
        foreach ($topics as $key => $topic) {
            $topics[$key]['hasFollowed'] = false;
            if (in_array($topic['id'], $followedTopicIds)) {
                $topics[$key]['hasFollowed'] = true;
            }
        }

        return $this->render('TopxiaWebBundle:Topic:index.html.twig', array(
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