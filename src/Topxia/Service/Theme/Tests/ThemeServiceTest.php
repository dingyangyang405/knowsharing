<?php

namespace Topxia\Service\Theme\Tests;

use Topxia\Service\Theme\Impl\ThemeServiceImpl;

class ThemeServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAllThemes()
    {
        $ThemeServiceImpl = new ThemeServiceImpl();
        $theme = array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
            );
        $theme = $ThemeServiceImpl->createTheme($theme);
        $result = $ThemeServiceImpl->getTheme($theme['id']);
        /*array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
            );*/
        $this->assertEquals($theme['name'], $result['name']);
        $this->assertEquals($theme['createdTime'], $result['createdTime']);
        $this->assertEquals($theme['userId'], $result['userId']);
    }
}