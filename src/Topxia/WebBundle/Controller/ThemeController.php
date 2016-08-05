<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;

class ThemeController extends BaseController
{
    public function indexAction()
    {
        $themes = $this->getThemeService()->findAllThemes();
        return $this->render('TopxiaWebBundle:Theme:Theme.html.twig',array('themes' => $themes));
    }

    public function getThemeService()
    {
        return $this->getServiceKernel('theme_service');
    }
}