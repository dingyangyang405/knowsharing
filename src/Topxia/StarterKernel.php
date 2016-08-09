<?php
namespace Topxia;

use Codeages\Biz\Framework\Context\Kernel;
use Topxia\Service\User\Impl\UserServiceImpl;
use Topxia\Service\User\Dao\Impl\UserDaoImpl;
use Topxia\Service\User\Dao\Impl\FollowUserDaoImpl;
use Topxia\Service\Topic\Impl\TopicServiceImpl;
use Topxia\Service\Topic\Dao\Impl\TopicDaoImpl;
use Topxia\Service\Topic\Dao\Impl\FollowDaoImpl;
use Topxia\Service\Knowledge\Impl\KnowledgeServiceImpl;
use Topxia\Service\Knowledge\Dao\Impl\KnowledgeDaoImpl;
use Topxia\Service\Collection\Impl\CollectionServiceImpl;
use Topxia\Service\Collection\Dao\Impl\CollectionDaoImpl;
use Topxia\Service\Knowledge\Dao\Impl\CommentDaoImpl;
use Topxia\Service\Like\Impl\LikeServiceImpl;
use Topxia\Service\Like\Dao\Impl\LikeDaoImpl;
use Topxia\Service\Favorite\Impl\FavoriteServiceImpl;
use Topxia\Service\Favorite\Dao\Impl\FavoriteDaoImpl;

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

        $this['topic_service'] = function($container) {
            return new TopicServiceImpl($container);
        };

        $this['topic_dao'] = $this->dao(function($container) {
            return new TopicDaoImpl($container);
        });

        $this['knowledge_service'] = function($container) {
            return new KnowledgeServiceImpl($container);
        };

        $this['knowledge_dao'] = $this->dao(function($container) {
            return new KnowledgeDaoImpl($container);
        });

        $this['favorite_dao'] = $this->dao(function($container) {
            return new FavoriteDaoImpl($container);
        });

        $this['favorite_service'] = function($container) {
            return new FavoriteServiceImpl($container);
        };

        $this['comment_dao'] = $this->dao(function($container) {
            return new CommentDaoImpl($container);
        });

        $this['follow_dao'] = $this->dao(function($container) {

            return new FollowDaoImpl($container);
        });

        $this['follow_user_dao'] = $this->dao(function($container) {
            return new FollowUserDaoImpl($container);
        });

        $this['like_dao'] = $this->dao(function($container) {
            return new LikeDaoImpl($container);
        });

        $this['like_service'] = function($container) {
            return new LikeServiceImpl($container);
        };
    }
}
