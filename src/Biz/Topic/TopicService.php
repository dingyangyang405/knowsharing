<?php

namespace Biz\Topic;

interface TopicService
{
    public function findAllTopics();

    public function searchTopics($conditions, $orderBy, $start, $limit);

    public function findTopTopics($type);

    public function getTopicsCount($conditions);

    public function getTopicById($id);

    public function createTopic($field);

    public function getTopicByName($name);

    public function deleteTopicById($id);

    public function findTopicsByIds($ids);
}