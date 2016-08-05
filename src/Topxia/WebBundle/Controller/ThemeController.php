<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;

class ThemeController extends Controller
{
    public function indexAction()
    {
        $themes = $this->getThemeService()->findAllThemes();
        return $this->render('TopxiaWebBundle:Theme:theme.html.twig',array('themes' => $themes));
    }

    public function getThemeService()
    {
        $container = $this->container->get('biz_kernel');
        return $container['theme_service'];
    }
}