<?php

namespace Topxia\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Topxia\Common\CurlGet;

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

}