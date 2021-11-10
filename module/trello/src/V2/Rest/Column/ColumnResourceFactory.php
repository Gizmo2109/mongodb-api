<?php
namespace trello\V2\Rest\Column;

class ColumnResourceFactory
{
    public function __invoke($services)
    {
        return new ColumnResource();
    }
}
