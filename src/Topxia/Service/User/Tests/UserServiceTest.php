<?php

namespace Topxia\Service\Knowledge\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserServiceTest extends BaseTestCase
{
    public function testFindUsersByIds()
    {
        $userTest1 = array(
            'name' => '江南',
            'roles' => '游客',
            'picture' => 'lalallaal',
            'mobile' => '13567730096',
            'password' => '123456',
            'email' => '405954049@qq.com',
            'followNum' => '1',
        );
        $userTest2 = array(
            'name' => '南派',
            'roles' => '游客',
            'picture' => 'lalallaal',
            'mobile' => '13567730098',
            'password' => '1234567',
            'email' => '405954094@qq.com',
            'followNum' => '233',
        );
        $userTest1 = $this->getUserDao()->create($userTest1);
        $userTest2 = $this->getUserDao()->create($userTest2);
        $users = $this->getUserService()->findUsersByIds(array($userTest1['id'],$userTest2['id']));
        $this->assertEquals(count($users),2);
    }

    public function testGetUser()
    {
        $user1 = array(
            'name' => 'name1',
            'roles' => '游客',
            'picture' => '123123',
            'mobile' => '123454678912',
            'password' => '123456',
            'email' => '157842369@qq.com',
            'followNum' => '20',
        );

        $user1 = $this->getUserDao()->create($user1);
        $result = $this->getUserService()->getUser($user1['id']);
        $this->assertEquals($user1['name'],$result['name']);
    }

    public function testFollowUser()
    {
        $followUser = array(
            'userId' => 1,
            'type' => 'user',
            'objectId' => 2
        );
        $this->getUserService()->followUser(2);
        $status = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,2);
        $this->assertEquals($status,1);
    }

    public function testUnfollowUser()
    {
        $followUser = array(
            'userId' => 1,
            'type' => 'user',
            'objectId' => 2
        );
        $this->getUserService()->followUser(2);
        $status0 = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,2);
        $this->getUserService()->unfollowUser(2);
        $status1 = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,2);
        $this->assertEquals($status0,1);
        $this->assertEquals($status1,0);
    }

    protected function getUserService()
    {
        return self::$kernel['user_service'];
    }

    protected function getUserDao()
    {
        return self::$kernel['user_dao'];
    }

    protected function getFollowDao()
    {
        return $this->container['follow_user_dao'];
    }
}