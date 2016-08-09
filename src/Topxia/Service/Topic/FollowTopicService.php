<?php

namespace Topxia\Service\Topic;

interface FollowTopicService
{
    public function followTopic($topicId);

    public function unFollowTopic($topicId);
}