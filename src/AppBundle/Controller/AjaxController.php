<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\CurlGet;

class AjaxController  extends BaseController
{
    public function linkAction(Request $request)
    {
        $requestData = $request->request->all();
        $title = CurlGet::get($requestData['link']);

        return new JsonResponse(array(
            'title' => $title
        ));
    }

    public function topicAction(Request $request)
    {
        $conditions= $request->request->all();
        $topics = $this->getTopicService()->searchTopics(
            $conditions,
            array('createdTime', 'DES')
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