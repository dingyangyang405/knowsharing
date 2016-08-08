<?php
namespace Topxia;

use Codeages\Biz\Framework\Context\Kernel;
use Topxia\Service\User\Impl\UserServiceImpl;
use Topxia\Service\User\Dao\Impl\UserDaoImpl;
use Topxia\Service\Theme\Impl\ThemeServiceImpl;
use Topxia\Service\Theme\Dao\Impl\ThemeDaoImpl;
use Topxia\Service\Knowledge\Impl\KnowledgeServiceImpl;
use Topxia\Service\Knowledge\Dao\Impl\KnowledgeDaoImpl;
use Topxia\Service\Collection\Impl\CollectionServiceImpl;
use Topxia\Service\Collection\Dao\Impl\CollectionDaoImpl;
use Topxia\Service\Knowledge\Dao\Impl\CommentDaoImpl;


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

        $this['collection_dao'] = $this->dao(function($container) {
            return new CollectionDaoImpl($container);
        });

        $this['collection_service'] = function($container) {
            return new CollectionServiceImpl($container);
        };

        $this['comment_dao'] = $this->dao(function($container) {
            return new CommentDaoImpl($container);
        });

    }
}
