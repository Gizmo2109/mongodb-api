<?php
namespace trello\V3\Rest\Task;

class TaskResourceFactory
{
    public function __invoke($services)
    {
        return new TaskResource();
    }
}
