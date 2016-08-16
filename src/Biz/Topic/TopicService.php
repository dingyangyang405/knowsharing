<?php

namespace Biz\Topic;

interface TopicService
{
    public function findAllTopics();

    public function searchTopics($conditions, $orderBy, $start, $limit);

    public function findTopTopics($type);
}