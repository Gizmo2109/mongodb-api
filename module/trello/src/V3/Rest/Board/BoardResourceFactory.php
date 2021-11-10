<?php
namespace trello\V3\Rest\Board;

class BoardResourceFactory
{
    public function __invoke($services)
    {
        return new BoardResource();
    }
}
