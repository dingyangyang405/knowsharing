<?php
namespace Topxia\Service\Theme\Impl;

use Topxia\Service\Theme\Dao\Impl\ThemeDaoImpl;

use Topxia\Service\Theme\ThemeService;

class ThemeServiceImpl implements ThemeService
{
    protected  $container;

    public  function __construct($container)
    {
        $this->container = $container;
    }

    public function findAllThemes()
    {
        return $this->getThemeDao()->findAllThemes();
    }

    public function followTheme($themeId)
    {
        $user['id'] = 1;


    }

    public function unfollowTheme($themeId)
    {

    }
    
    protected function getThemeDao()
    {
        return $this->container['theme_dao'];
    }
}