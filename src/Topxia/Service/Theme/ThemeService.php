<?php

namespace Topxia\Service\Theme;

interface ThemeService
{
    public function findAllThemes();

    public function followTheme($id);

    public function unfollowTheme($id);
}