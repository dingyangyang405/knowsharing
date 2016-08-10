<?php

namespace Topxia\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends Controller
{
//    public function getServiceKernel($service)
//    {
//        $container = $this->container->get('biz_kernel');
//
//        return $container[$service];
//    }
    protected $biz;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->biz = $this->container->get('biz');
    }
}