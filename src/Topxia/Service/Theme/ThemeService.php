<?php

namespace Topxia\Service\Theme;

interface ThemeService
{
    public function findAllThemes();

    public function followTheme($themeId);

    public function unfollowTheme($themeId);
}