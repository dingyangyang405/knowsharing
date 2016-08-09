<?php

namespace Topxia\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    public function getServiceKernel($service)
    {
        $container = $this->container->get('biz_kernel');
        
        return $container[$service];
    }
}