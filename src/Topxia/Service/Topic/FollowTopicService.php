<?php

namespace Topxia\Service\Topic;

interface FollowTopicService
{
    public function followTopic($topicId);

    public function unFollowTopic($topicId);

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId);

    public function waveFollowNum($ids, $diffs);

    public function findAllFollowedTopics();
}