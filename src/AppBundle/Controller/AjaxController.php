<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\Curl;

class AjaxController  extends BaseController
{
    public function linkAction(Request $request)
    {
        $requestData = $request->request->all();
        $title = Curl::getTitle($requestData['link']);

        return new JsonResponse(array(
            'title' => $title
        ));
    }

    public function topicAction(Request $request)
    {
        $conditions = $request->request->all();
        $conditions['name'] = "%{$conditions['name']}%";
        $topics = $this->getTopicService()->searchTopics(
            $conditions,
            array('createdTime', 'DESC'),
            0,
            PHP_INT_MAX
        );
        return new JsonResponse(array(
            'topics' => $topics
        ));
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

}