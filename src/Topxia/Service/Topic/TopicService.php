<?php

namespace Topxia\Service\Topic;

interface TopicService
{
    public function findAllTopics();

    public function findAllFollowedTopics();
}