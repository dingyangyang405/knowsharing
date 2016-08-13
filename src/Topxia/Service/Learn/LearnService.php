<?php

namespace Topxia\Service\Learn;

interface LearnService
{
    public function getLearnedByIdAndUserId($id, $userId);

    public function finishKnowledgeLearn($id, $userId);
}