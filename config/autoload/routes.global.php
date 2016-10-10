<?php

use CodeEmailMKT\Application\Action\Customer\CustomerCreatePageAction;
use CodeEmailMKT\Application\Action\Customer\CustomerCreatePageFactory;
use CodeEmailMKT\Application\Action\Customer\CustomerListPageAction;
use CodeEmailMKT\Application\Action\Customer\CustomerListPageFactory;
use CodeEmailMKT\Application\Action\Customer\CustomerRemovePageAction;
use CodeEmailMKT\Application\Action\Customer\CustomerRemovePageFactory;
use CodeEmailMKT\Application\Action\Customer\CustomerUpdatePageAction;
use CodeEmailMKT\Application\Action\Customer\CustomerUpdatePageFactory;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            CodeEmailMKT\Application\Action\PingAction::class => CodeEmailMKT\Application\Action\PingAction::class,
        ],
        'factories' => [
            CodeEmailMKT\Application\Action\HomePageAction::class => CodeEmailMKT\Application\Action\HomePageFactory::class,
            CodeEmailMKT\Application\Action\TestePageAction::class => CodeEmailMKT\Application\Action\TestePageFactory::class,
            CustomerListPageAction::class => CustomerListPageFactory::class,
            CustomerCreatePageAction::class => CustomerCreatePageFactory::class,
            CustomerUpdatePageAction::class => CustomerUpdatePageFactory::class,
            CustomerRemovePageAction::class => CustomerRemovePageFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => CodeEmailMKT\Application\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'api.ping',
            'path' => '/api/ping',
            'middleware' => CodeEmailMKT\Application\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'teste',
            'path' => '/teste-aula',
            'middleware' => CodeEmailMKT\Application\Action\TestePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.list',
            'path' => '/admin/customers',
            'middleware' => CustomerListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.create',
            'path' => '/admin/customer/create',
            'middleware' => CustomerCreatePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'customer.update',
            'path' => '/admin/customer/update/{id}',
            'middleware' => CustomerUpdatePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'customer.remove',
            'path' => '/admin/customers/remove/{id}',
            'middleware' => CustomerRemovePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
    ],
];
