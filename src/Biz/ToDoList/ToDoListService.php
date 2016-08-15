<?php

namespace Biz\ToDoList;

interface ToDoListService
{
    public function findToDoListByUserId($userId);
}