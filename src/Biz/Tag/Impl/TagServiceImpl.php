<?php

namespace Biz\Tag\Impl;

use Biz\Tag\TagService;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class TagServiceImpl extends KernelAwareBaseService implements TagService
{
    public function searchTags($conditions, $orderBy, $start, $limit)
    {
        return $this->getTagDao()->search($conditions, $orderBy, $start, $limit);
    }

    protected function getTagDao()
    {
        $this->container['tag_dao'];
    }
}