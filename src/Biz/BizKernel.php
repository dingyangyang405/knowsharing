<?php
namespace Biz;

use Codeages\Biz\Framework\Context\Kernel;
use Biz\User\Impl\UserServiceImpl;
use Biz\User\Dao\Impl\UserDaoImpl;
use Biz\User\Dao\Impl\FollowUserDaoImpl;
use Biz\Topic\Impl\TopicServiceImpl;
use Biz\Topic\Impl\FollowTopicServiceImpl;
use Biz\Topic\Dao\Impl\TopicDaoImpl;
use Biz\Topic\Dao\Impl\FollowTopicDaoImpl;
use Biz\Knowledge\Impl\KnowledgeServiceImpl;
use Biz\Knowledge\Impl\KnowledgeShareServiceImpl;
use Biz\Knowledge\Dao\Impl\KnowledgeDaoImpl;
use Biz\Knowledge\Dao\Impl\CommentDaoImpl;
use Biz\Like\Impl\LikeServiceImpl;
use Biz\Like\Dao\Impl\LikeDaoImpl;
use Biz\Favorite\Impl\FavoriteServiceImpl;
use Biz\Favorite\Dao\Impl\FavoriteDaoImpl;
use Biz\Toread\Impl\ToreadServiceImpl;
use Biz\Toread\Dao\Impl\ToreadDaoImpl;
use Biz\Learn\Impl\LearnServiceImpl;
use Biz\Learn\Dao\Impl\LearnDaoImpl;
use Biz\ToDoList\Impl\ToDoListServiceImpl;
use Biz\ToDoList\Dao\Impl\ToDoListDaoImpl;


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

        $this['toread_service'] = function($container) {
            return new ToreadServiceImpl($container);
        };

        $this['toread_dao'] = $this->dao(function($container) {
            return new ToreadDaoImpl($container);
        });

        $this['learn_service'] = function($container) {
            return new LearnServiceImpl($container);
        };

        $this['learn_dao'] = $this->dao(function($container) {
            return new LearnDaoImpl($container);
        });

        $this['todolist_service'] = function($container) {
            return new ToDoListServiceImpl($container);
        };

        $this['todolist_dao'] = $this->dao(function($container) {
            return new ToDoListDaoImpl($container);
        });
    }
}
