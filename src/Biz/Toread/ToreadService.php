<?php

namespace Biz\Toread;

interface ToreadService
{
    public function createToreadKnowledge($id, $userId);

    public function deleteToreadKnowledge($id, $userId);

    public function getToreadlistCount($conditons);
}