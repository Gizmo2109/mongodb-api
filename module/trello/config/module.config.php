<?php
return [
    'service_manager' => [
        'factories' => [
            \trello\V1\Rest\Board\BoardResource::class => \trello\V1\Rest\Board\BoardResourceFactory::class,
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
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'trello.rest.board',
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
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \trello\V1\Rest\Board\BoardEntity::class,
            'collection_class' => \trello\V1\Rest\Board\BoardCollection::class,
            'service_name' => 'board',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'trello\\V1\\Rest\\Board\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'trello\\V1\\Rest\\Board\\Controller' => [
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
