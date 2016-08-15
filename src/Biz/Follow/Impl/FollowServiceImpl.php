<?php 

namespace Biz\Follow\Impl;

use Biz\Follow\FollowService;

class FollowServiceImpl implements FollowService
{
    protected  $container;

    public  function __construct($container)
    {
        $this->container = $container;
    }

    // public function followUser($id)
    // {   
    //     // $user = $this->getCurrentUser();
    //     $user['id'] = 1;
    //     $followUser = $this->getFollowDao()->create(array(
    //         'userId'=> $user['id'],
    //         'type'=>'user',
    //         'objectId'=>$id
    //     ));
    //     if ($user['id'] ==1 && $followUser['objectId'] ==$id) {
    //         return true;
    //     } else {
    //         throw new \RuntimeException("关注该用户失败");
    //     }    
    // }

    // public function unfollowUser($id)
    // {
    //     $user['id'] = 1;
    //     $followUser = $this->getFollowDao()->getFollowUserByUserIdAndObjectUserId($user['id'], $id);
    //     $status = $this->getFollowDao()->delete($followUser['id']);
    //     if ($status == 1) {
    //         return true;
    //     } else {
    //         throw new \RuntimeException("取消关注该用户失败");
    //     }  
    // }

    public function followUser($id)
    {   
        $user['id'] = 1;//当前用户,传过来的$id是要查看的用户
        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $user = $this->getUserDao()->get($id);
        if (empty($user)) {
            throw new \Exception('被关注的用户不存在');
        }
        $user = $this->getFollowUserByUserIdAndObjectUserId($user['id'], $id);
        if ($user) {
            throw new \Exception('已经被关注');
        }
        $user['id'] = 1;
        $followUser = $this->getFollowDao()->create(array(
            'userId'=> $user['id'],
            'type'=>'user',
            'objectId'=>$id
        ));
        if ($user['id'] ==1 && $followUser['objectId'] ==$id) {
            return true;
        } else {
            throw new \RuntimeException("关注该用户失败");
        }    
    }

    public function unfollowUser($id)
    {
        $user['id'] = 1;
        $followUser = $this->getFollowDao()->getFollowUserByUserIdAndObjectUserId($user['id'], $id);
        $status = $this->getFollowDao()->delete($followUser['id']);
        if ($status == 1) {
            return true;
        } else {
            throw new \RuntimeException("取消关注该用户失败");
        }  
    }

    public function followTopic($topicId)
    {
        $user['id'] = 1;

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }
        $topic = $this->getTopicDao()->get($topicId);
        if (empty($topic)) {
            throw new \Exception('主题不存在');
        }

        $followed = $this->getFollowTopicByUserIdAndTopicId($user['id'], $topicId);
        if ($followed) {
            throw new \Exception('已经被关注');
        }

        $this->getFollowDao()->create(array(
            'objectId' => $topicId,
            'userId' => $user['id'],
            'type' => 'topic',
        ));

        $ids = array($topicId);
        $diffs = array('followNum' => 1);
        $this->waveFollowNum($ids, $diffs);

        return true;
    }

    public function unFollowTopic($topicId)
    {
        $user['id'] = 1;

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $topic = $this->getTopicDao()->get($topicId);
        if (empty($topic)) {
            throw new \Exception('主题不存在');
        }

        $followed = $this->getFollowTopicByUserIdAndTopicId($user['id'], $topicId);
        if (empty($followed)) {
            throw new \Exception('未被关注');
        }
        
        $this->getFollowDao()->delete($followed[0]['id']);

        $ids = array($topicId);
        $diffs = array('followNum' => -1);
        $this->waveFollowNum($ids, $diffs);


        return true;
    }

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId)
    {
        $conditions = array(
            'userId' => $userId,
            'objectId' => $topicId,
            'type' => 'topic',
        );

        $orderBy = array('objectId', 'ASC');

        return $this->getFollowDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
    }

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId)
    {
        $objectUser = $this->getFollowDao()->getFollowUserByUserIdAndObjectUserId($userId,$objectId);
        if (isset($objectUser)) {
            return true;
        } else {
            return false;
        }
    }

    public function findFollowTopicsByUserId($userId)
    {
        $conditions = array(
            'userId' => $userId,
            'type' => 'topic',
        );
        $orderBy = array('objectId', 'ASC');
        
        return $this->getFollowDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
    }

    public function waveFollowNum($ids, $diffs)
    {
        return $this->getTopicDao()->wave($ids, $diffs);
    }

    public function hasFollowTopics($topics,$userId)
    {
        $followedTopics = $this->findFollowTopicsByUserId($userId);
        $followedTopicIds = array();
        foreach ($followedTopics as $value) {
            $followedTopicIds[] = $value['objectId'];
        }
        foreach ($topics as $key => $topic) {
            $topics[$key]['hasFollow'] = false;
            if (in_array($topic['id'], $followedTopicIds)) {
                $topics[$key]['hasFollow'] = true;
            }
        }
        return $topics;
    }

    public function searchMyFollowsByUserIdAndType($userId, $type)
    {
        $conditions = array(
            'userId' => $userId, 
            'type' => $type
        );
        $orderBy = array('id', 'DESC');
        
        $myFollows = $this->getFollowDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);

        return $myFollows;
    }

    protected function getFollowDao()
    {
        return $this->container['follow_dao'];
    }

    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }

    protected function getUserDao()
    {
        return $this->container['user_dao'];
    }
}