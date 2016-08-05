<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function addLink($field);

    public function getKnowledgeDetial($id);
}