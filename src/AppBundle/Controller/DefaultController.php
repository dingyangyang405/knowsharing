<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Common\ArrayToolKit;
use AppBundle\Common\Paginator;
use AppBundle\Common\Setting;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        $conditions = array();
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
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

        return $this->render('AppBundle:Default:index.html.twig', array(
            'knowledges' => $knowledges,
            'users' => $users,
            'paginator' => $paginator,
            'type' => 'newKnowledge'
        ));
    }

    public function listTopKnowledgesAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'like';
        } else {
            $type = $post['type'];
        }
        $topKnowledges = $this->getKnowledgeService()->findTopKnowledges($type);

        return $this->render('AppBundle:TopList:top-knowledge.html.twig',array(
            'topKnowledges' => $topKnowledges,
            'type' => $type
        ));
    }

    public function listTopTopicsAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'follow';
        } else {
            $type = $post['type'];
        }
        $topTopics = $this->getTopicService()->findTopTopics($type);

        return $this->render('AppBundle:TopList:top-topic.html.twig',array(
            'topTopics' => $topTopics,
            'type' => $type
        ));
    }

    public function listTopUsersAction(Request $request)
    {
        $post = $request->request->all();
        if (empty($post['type'])) {
            $type = 'score';
        } else {
            $type = $post['type'];
        }
        $topUsers = $this->getUserService()->findTopUsers($type);

        return $this->render('AppBundle:TopList:top-user.html.twig',array(
            'topUsers' => $topUsers,
            'type' => $type
        ));
    }
    
    public function noticeToDoListAction(Request $request)
    {
        $currentUser = $this->getCurrentUser();
        if ($currentUser->isLogin()) {
            $conditions = array(
                'userId' => $currentUser['id'],
            );
            $toReadListNum = $this->getToreadService()->getToreadlistCount($conditions);
            
            return $this->render('AppBundle::notice-todolist.html.twig', array(
                'toReadListNum' => $toReadListNum,
            ));
        }
        
        return $this->render('AppBundle::notice-todolist.html.twig', array());
    }

    public function searchRelatedInAction(Request $request)
    {
        $conditions = $request->query->all();
        if ($conditions['searchType'] == 'topic') {
            return $this->topicSearch($request, $conditions);
        } else if ($conditions['searchType'] == 'user') {
            return  $this->userSearch($request, $conditions);
        } else {
            return  $this->knowledgeSearch($request, $conditions);
        }

    }

    private function topicSearch($request, $conditions)
    {
        $currentUser = $this->getCurrentUser();
        $condition = array('name' => "%{$conditions['query']}%");
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $request,
            $this->getTopicService()->getTopicsCount($condition),
            20
        );
        $topics = $this->getTopicService()->searchTopics(
            $condition,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $topics = $this->getFollowService()->hasFollowTopics($topics,$currentUser['id']);
        return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
            'searchType' => $conditions['searchType'],
            'query' => $conditions['query'],
            'paginator'=> $paginator,
            'topics' => $topics,
        ));
    }

    private function knowledgeSearch($request, $conditions)
    {
        $condition = array('title' => "%{$conditions['query']}%");
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $request,
            $this->getKnowledgeService()->getKnowledgesCount($condition),
            20
        );
        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $condition,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
            'searchType' => $conditions['searchType'],
            'query' => $conditions['query'],
            'paginator'=> $paginator,
            'knowledges' => $knowledges,
            'users' => $users
        ));
    }

    private function userSearch($request, $conditions)
    {
        $orderBy = array('created', 'DESC');
        $condition = array('username' => "%{$conditions['query']}%");
        $paginator = new Paginator(
            $request,
            $this->getUserService()->getUsersCount($condition),
            20
        );

        $users = $this->getUserService()->findUsers(
            $condition,
            $orderBy ,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        return $this->render('AppBundle:Default:searchRelatedIn.html.twig',array(
            'searchType' => $conditions['searchType'],
            'query' => $conditions['query'],
            'paginator'=> $paginator,
            'users' => $users
        ));
    }

    public function docModalAction(Request $request)
    {
        return $this->render('AppBundle::add-file.html.twig');
    }

    public function linkModalAction(Request $request)
    {
        return $this->render('AppBundle::add-link.html.twig');
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getFavoriteService()
    {
        return $this->biz['favorite_service'];
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

    protected function getToreadService()
    {
        return $this->biz['toread_service'];
    }

    protected function getKnowledgeSearchService()
    {
        return $this->biz['knowledge_search'];
    }

    protected function getFollowService()
    {
        return $this->biz['follow_service'];
    }

}