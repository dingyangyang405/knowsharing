<?php

namespace Topxia\Service\Topic;

interface TopicService
{
    public function findAll();

    public function findAllFollowedTopics();

    public function followTopic($topicId);

    public function unfollowTopic($topicId);
}