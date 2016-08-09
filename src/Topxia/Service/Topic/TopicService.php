<?php

namespace Topxia\Service\Topic;

interface TopicService
{
    public function findAllTopics();

    public function findAllFollowedTopics();

    public function followTopic($topicId);

    public function unfollowTopic($topicId);
}