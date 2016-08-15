<?php

namespace Biz\Follow;

interface FollowService
{
    public function followUser($id);

    public function unfollowUser($id);

    public function followTopic($topicId);

    public function unFollowTopic($topicId);

    public function waveFollowNum($ids, $diffs);

    public function findFollowTopicsByUserId($userId);

    public function hasFollowTopics($topics,$userId);

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId);

    public function searchMyFollowsByUserIdAndType($userId, $type);
}