<?php
namespace Topxia;

use Codeages\Biz\Framework\Context\Kernel;
use Topxia\Service\User\Impl\UserServiceImpl;
use Topxia\Service\User\Dao\Impl\UserDaoImpl;
use Topxia\Service\User\Dao\Impl\FollowUserDaoImpl;
use Topxia\Service\Topic\Impl\TopicServiceImpl;
use Topxia\Service\Topic\Impl\FollowTopicServiceImpl;
use Topxia\Service\Topic\Dao\Impl\TopicDaoImpl;
use Topxia\Service\Topic\Dao\Impl\FollowTopicDaoImpl;
use Topxia\Service\Knowledge\Impl\KnowledgeServiceImpl;
use Topxia\Service\Knowledge\Impl\KnowledgeShareServiceImpl;
use Topxia\Service\Knowledge\Dao\Impl\KnowledgeDaoImpl;
use Topxia\Service\Knowledge\Dao\Impl\CommentDaoImpl;
use Topxia\Service\Like\Impl\LikeServiceImpl;
use Topxia\Service\Like\Dao\Impl\LikeDaoImpl;
use Topxia\Service\Favorite\Impl\FavoriteServiceImpl;
use Topxia\Service\Favorite\Dao\Impl\FavoriteDaoImpl;

class BizKernel extends Kernel
{
    protected $extraContainer;

    public function __construct($config, $extraContainer)
    {
        parent::__construct($config);
        $this->extraContainer = $extraContainer;
    }

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
        $this['password_encoder'] = function($container) {
            $class = $this->extraContainer->getParameter('app.current_user.class');
            $user = new $class(array());
            return $this->extraContainer->get('security.encoder_factory')->getEncoder($user);
        };

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

        $this['knowledge_share_service'] = function($container) {
            return new KnowledgeShareServiceImpl($container);
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

        $this['follow_topic_service'] = function($container) {
            return new FollowTopicServiceImpl($container);
        };

        $this['follow_topic_dao'] = $this->dao(function($container) {
            return new FollowTopicDaoImpl($container);
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
