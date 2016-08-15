<?php

namespace Biz\ToDoList\Impl;

use Biz\ToDoList\ToDoListService;

class ToDoListServiceImpl implements ToDoListService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function findToDoListByUserId($userId)
    {
        return $this->getToDoListDao()->findByUserId(array($userId));
    }

    protected function getToDoListDao()
    {
        return $this->container['todolist_dao'];
    }
}