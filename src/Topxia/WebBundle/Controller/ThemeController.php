<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

class ThemeController extends BaseController
{
    public function indexAction()
    {
        $themes = $this->getThemeService()->findAllThemes();
        var_dump($themes);exit();
        return $this->render('TopxiaWebBundle:Theme:theme.html.twig',array(
            'themes' => $themes
        ));
    }

    public function followAction(Request $request, $id)
    {
        $this->getThemeService()->followTheme($id);

        return new JsonResponse(true);
    }

    public function unfollowAction(Request $request, $id)
    {
        $this->getThemeService()->unfollowTheme($id);

        return new JsonResponse(true);
    }

    protected function getThemeService()
    {
        return $this->getServiceKernel('theme_service');
    }
}