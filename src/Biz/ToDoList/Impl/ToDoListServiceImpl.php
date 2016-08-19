<?php

namespace Biz\ToDoList\Impl;

use Biz\ToDoList\ToDoListService;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class ToDoListServiceImpl extends KernelAwareBaseService implements ToDoListService
{
    public function findToDoListByUserId($userId)
    {
        return $this->getToDoListDao()->findByUserId(array($userId));
    }

    protected function getToDoListDao()
    {
        return $this->biz['todolist_dao'];
    }
}