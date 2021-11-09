<?php
namespace trello\V1\Rest\Column;

class ColumnResourceFactory
{
    public function __invoke($services)
    {
        return new ColumnResource();
    }
}
