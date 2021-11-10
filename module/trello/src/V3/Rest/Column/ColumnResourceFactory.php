<?php
namespace trello\V3\Rest\Column;

class ColumnResourceFactory
{
    public function __invoke($services)
    {
        return new ColumnResource();
    }
}
