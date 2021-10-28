<?php
namespace trello\V1\Rest\Board;

class BoardResourceFactory
{
    public function __invoke($services)
    {
        return new BoardResource();
    }
}
