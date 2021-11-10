<?php
namespace trello\V2\Rest\Task;

class TaskResourceFactory
{
    public function __invoke($services)
    {
        return new TaskResource();
    }
}
