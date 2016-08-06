<?php

namespace Topxia\Service\Knowledge\Tests;

use Topxia\Service\User\Impl\UserServiceImpl;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFindUsersByIds()
    {
        $userService = new UserServiceImpl();

        $knowledgeTest1 = array(
            'id' => 3,
            'title' => 'test1',
            'summary' => '这是测试方法',
            'type' => 'link',
            'theme_id' => 1,
            'like_num' => 22,
            'collect_num' => 23,
            'ownerId' => 1,
            'createdTime' => '1464591741',
            'updateTime' => '1464591743'
            );
        $knowledgeTest2 = array(
            'id' => 4,
            'title' => 'test1',
            'summary' => '这是测试方法',
            'type' => 'link',
            'theme_id' => 2,
            'like_num' => 22,
            'collect_num' => 21,
            'ownerId' => 2,
            'createdTime' => '1464591745',
            'updateTime' => '1464591755'
            );
        $users = $userService->findUsersByIds(array($knowledgeTest1['id'],$knowledgeTest2['id']));
        $this->assertEqual(count($users),2);
    }
}