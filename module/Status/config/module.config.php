<?php
return [
    'controllers' => [
        'factories' => [
            'Status\\V1\\Rpc\\Ping\\Controller' => \Status\V1\Rpc\Ping\PingControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'status.rpc.ping' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ping',
                    'defaults' => [
                        'controller' => 'Status\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ],
                ],
            ],
            'status.rest.test' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/columns[/:columns_id]',
                    'defaults' => [
                        'controller' => 'Status\\V1\\Rest\\Test\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'status.rpc.ping',
            1 => 'status.rest.test',
        ],
    ],
    'api-tools-rpc' => [
        'Status\\V1\\Rpc\\Ping\\Controller' => [
            'service_name' => 'Ping',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'status.rpc.ping',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Status\\V1\\Rpc\\Ping\\Controller' => 'Json',
            'Status\\V1\\Rest\\Test\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Status\\V1\\Rpc\\Ping\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'Status\\V1\\Rest\\Test\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Status\\V1\\Rpc\\Ping\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ],
            'Status\\V1\\Rest\\Test\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Status\\V1\\Rpc\\Ping\\Controller' => [
            'input_filter' => 'Status\\V1\\Rpc\\Ping\\Validator',
        ],
        'Status\\V1\\Rest\\Test\\Controller' => [
            'input_filter' => 'Status\\V1\\Rest\\Test\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Status\\V1\\Rpc\\Ping\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'ack',
            ],
        ],
        'Status\\V1\\Rest\\Test\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Status\V1\Rest\Test\TestResource::class => \Status\V1\Rest\Test\TestResourceFactory::class,
        ],
    ],
    'api-tools-rest' => [
        'Status\\V1\\Rest\\Test\\Controller' => [
            'listener' => \Status\V1\Rest\Test\TestResource::class,
            'route_name' => 'status.rest.test',
            'route_identifier_name' => 'columns_id',
            'collection_name' => 'test',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'POST',
                4 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
                3 => 'PATCH',
                4 => 'DELETE',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Status\V1\Rest\Test\TestEntity::class,
            'collection_class' => \Status\V1\Rest\Test\TestCollection::class,
            'service_name' => 'test',
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Status\V1\Rest\Test\TestEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.test',
                'route_identifier_name' => 'columns_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Status\V1\Rest\Test\TestCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.test',
                'route_identifier_name' => 'columns_id',
                'is_collection' => true,
            ],
        ],
    ],
];
