<?php
return [
    'service_manager' => [
        'factories' => [
            \trello\V1\Rest\Board\BoardResource::class => \trello\V1\Rest\Board\BoardResourceFactory::class,
            \trello\V1\Rest\Column\ColumnResource::class => \trello\V1\Rest\Column\ColumnResourceFactory::class,
            \trello\V1\Rest\Task\TaskResource::class => \trello\V1\Rest\Task\TaskResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'trello.rest.board' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/board[/:board_id]',
                    'defaults' => [
                        'controller' => 'trello\\V1\\Rest\\Board\\Controller',
                    ],
                ],
            ],
            'trello.rest.column' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/column[/:column_id]',
                    'defaults' => [
                        'controller' => 'trello\\V1\\Rest\\Column\\Controller',
                    ],
                ],
            ],
            'trello.rest.task' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/task[/:task_id]',
                    'defaults' => [
                        'controller' => 'trello\\V1\\Rest\\Task\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'trello.rest.board',
            1 => 'trello.rest.column',
            2 => 'trello.rest.task',
        ],
    ],
    'api-tools-rest' => [
        'trello\\V1\\Rest\\Board\\Controller' => [
            'listener' => \trello\V1\Rest\Board\BoardResource::class,
            'route_name' => 'trello.rest.board',
            'route_identifier_name' => 'board_id',
            'collection_name' => 'board',
            'entity_http_methods' => [],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \trello\V1\Rest\Board\BoardEntity::class,
            'collection_class' => \trello\V1\Rest\Board\BoardCollection::class,
            'service_name' => 'board',
        ],
        'trello\\V1\\Rest\\Column\\Controller' => [
            'listener' => \trello\V1\Rest\Column\ColumnResource::class,
            'route_name' => 'trello.rest.column',
            'route_identifier_name' => 'column_id',
            'collection_name' => 'column',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PUT',
                3 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'POST',
                1 => 'PATCH',
                2 => 'PUT',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \trello\V1\Rest\Column\ColumnEntity::class,
            'collection_class' => \trello\V1\Rest\Column\ColumnCollection::class,
            'service_name' => 'column',
        ],
        'trello\\V1\\Rest\\Task\\Controller' => [
            'listener' => \trello\V1\Rest\Task\TaskResource::class,
            'route_name' => 'trello.rest.task',
            'route_identifier_name' => 'task_id',
            'collection_name' => 'task',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PATCH',
                3 => 'PUT',
                4 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \trello\V1\Rest\Task\TaskEntity::class,
            'collection_class' => \trello\V1\Rest\Task\TaskCollection::class,
            'service_name' => 'task',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'trello\\V1\\Rest\\Board\\Controller' => 'HalJson',
            'trello\\V1\\Rest\\Column\\Controller' => 'HalJson',
            'trello\\V1\\Rest\\Task\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'trello\\V1\\Rest\\Board\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'trello\\V1\\Rest\\Column\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'trello\\V1\\Rest\\Task\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'trello\\V1\\Rest\\Board\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/json',
            ],
            'trello\\V1\\Rest\\Column\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/json',
            ],
            'trello\\V1\\Rest\\Task\\Controller' => [
                0 => 'application/vnd.trello.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \trello\V1\Rest\Board\BoardEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.board',
                'route_identifier_name' => 'board_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \trello\V1\Rest\Board\BoardCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.board',
                'route_identifier_name' => 'board_id',
                'is_collection' => true,
            ],
            \trello\V1\Rest\Column\ColumnEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.column',
                'route_identifier_name' => 'column_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \trello\V1\Rest\Column\ColumnCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.column',
                'route_identifier_name' => 'column_id',
                'is_collection' => true,
            ],
            \trello\V1\Rest\Task\TaskEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.task',
                'route_identifier_name' => 'task_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \trello\V1\Rest\Task\TaskCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'trello.rest.task',
                'route_identifier_name' => 'task_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'trello\\V1\\Rest\\Board\\Controller' => [
            'input_filter' => 'trello\\V1\\Rest\\Board\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'trello\\V1\\Rest\\Board\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
        ],
    ],
];
