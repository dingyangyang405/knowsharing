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
        $themes = $this->getThemeDao()->findAllThemes();
        $followedThemes = $this->findAllFollowedThemes();
        foreach ($themes as $key => $theme) {
            $themes[$key]['hasFollowed'] = false;
            foreach ($followedThemes as $value) {
                if ($theme['id'] === $value['objectId']) {
                    $themes[$key]['hasFollowed'] = true;
                }
            }
        }

        return $themes;
    }

    public function findAllFollowedThemes()
    {
        $user['id'] = 1;

        return $this->getFollowDao()->findFollowsByUserId($user['id'], 'theme');
    }

    public function followTheme($themeId)
    {
        $user['id'] = 1;

        $this->getFollowDao()->addFollow(array(
            'objectId' => $themeId,
            'userId' => $user['id'],
            'objectType' => 'theme',
        ));

        return true;
    }

    public function unfollowTheme($themeId)
    {
        $user['id'] = 1;

        $follow = $this->getFollowDao()->getFollowThemeByUserIdAndThemeId($user['id'], $themeId, 'theme');
        $this->getFollowDao()->deleteFollow($follow['id']);

        return true;
    }
    
    protected function getThemeDao()
    {
        return $this->container['theme_dao'];
    }

    protected function getFollowDao()
    {
        return $this->container['follow_dao'];
    }
}