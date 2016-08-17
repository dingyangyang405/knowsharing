<?php

namespace Biz\Tag;

interface TagService
{
    public function searchTags($conditions, $orderBy, $start, $limit);
}