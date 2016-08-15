<?php

namespace Biz\Follow;

interface FollowService
{
    public function followUser($id);

    public function unfollowUser($id);

    public function followTopic($topicId);

    public function unFollowTopic($topicId);

    public function waveFollowNum($ids, $diffs);

    public function findFollowedTopicsByUserId($userId);

    public function hasFollowedTopics($topics,$userId);

    public function searchMyFollowedsByUserIdAndType($userId, $type);

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId);
}