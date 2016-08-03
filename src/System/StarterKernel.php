<?php
namespace System;

use Codeages\Biz\Framework\Context\Kernel;
use System\Service\User\Impl\UserServiceImpl;
use System\Service\User\Dao\Impl\UserDaoImpl;

class StarterKernel extends Kernel
{
    public function boot($options = array())
    {
        $this->registerService();
        $this->put('migration_directories', dirname(dirname(__DIR__)). '/migrations');
        parent::boot();
    }

    public function registerProviders()
    {
        return [];
    }

    protected function registerService()
    {
        $this['user_dao'] = $this->dao(function($container) {
            return new UserDaoImpl($container);
        });

        $this['user_service'] = function($container) {
            return new UserServiceImpl($container);
        };
    }
}
