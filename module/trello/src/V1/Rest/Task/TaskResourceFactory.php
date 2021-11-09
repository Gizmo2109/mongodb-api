<?php
namespace trello\V1\Rest\Task;

class TaskResourceFactory
{
    public function __invoke($services)
    {
        return new TaskResource();
    }
}
