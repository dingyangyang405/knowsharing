<?php
namespace Topxia;

use Codeages\Biz\Framework\Context\Kernel;
use Topxia\Service\User\Impl\UserServiceImpl;
use Topxia\Service\User\Dao\Impl\UserDaoImpl;
use Topxia\Service\Theme\Impl\ThemeServiceImpl;
use Topxia\Service\Theme\Dao\Impl\ThemeDaoImpl;
use Topxia\Service\Knowledge\Impl\KnowledgeServiceImpl;
use Topxia\Service\Knowledge\Dao\Impl\KnowledgeDaoImpl;
use Topxia\Service\User\Dao\Impl\UserCollectDaoImpl;
use Topxia\Service\User\Dao\Impl\UserLikeDaoImpl;

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

        $this['theme_service'] = function($container) {
            return new ThemeServiceImpl($container);
        };

        $this['theme_dao'] = $this->dao(function($container) {
            return new ThemeDaoImpl($container);
        });

        $this['knowledge_service'] = function($container) {
            return new KnowledgeServiceImpl($container);
        };

        $this['knowledge_dao'] = $this->dao(function($container) {
            return new KnowledgeDaoImpl($container);
        });

        $this['userCollect_dao'] = $this->dao(function($container) {
            return new UserCollectDaoImpl($container);
        });

        $this['userLike_dao'] = $this->dao(function($container) {
            return new UserLikeDaoImpl($container);
        });
    }
}
