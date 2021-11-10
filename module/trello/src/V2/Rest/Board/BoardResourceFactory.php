<?php
namespace trello\V2\Rest\Board;

class BoardResourceFactory
{
    public function __invoke($services)
    {
        return new BoardResource();
    }
}
