<?php

namespace Topxia\Service\Favorite\Tests;

use Topxia\Service\Favorite\Impl\FavoriteServiceImpl;

class FavoriteServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFavoriteCount()
    {
        $favorite1 = array(
            'id' => 1,
            'userId' => 1,
            'knowledgeId' => 1
            'createdTime' => '1464591741'
        );
        $favorite2 = array(
            'id' => 2,
            'userId' => 1,
            'knowledgeId' => 2
            'createdTime' => '1464591742'
        );
        $count = $userService->getFavoriteCount(array(
            'userId' => 1,
        ));
        $this->assertEqual(2, $count);
    }
}