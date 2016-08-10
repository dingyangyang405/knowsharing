<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Common\Paginator;

class KnowledgeShareController extends BaseController
{
    public function indexAction(Request $request)
    {   
        $userId = 1;
        $condition = array('userId'=>$userId);

        $paginator = new Paginator(
            $this->get('request'),
            $this->getShareService()->searchShareCount($condition),
            10
        );

        $shareKnowledge = $this->getShareService()->searchShareKnowledge(
            $condition,array('createTime', 'DESC'),
            $paginator->getOffsetCount(), 
            $paginator->getPerPageCount()
        );

        return $this->render('TopxiaWebBundle:KnowledgeShare:my-knowledge.html.twig',array(
            'shareKnowledge' => $shareKnowledge
        ));
    }

    protected function getShareService()
    {
        return $this->biz['knowledge_share_service'];
    }
}
