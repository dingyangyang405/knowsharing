<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function getKnowledgesByUserId($id);

    public function addLink($field);

    public function getKnowledgeDetial($id);

}