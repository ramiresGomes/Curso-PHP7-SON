<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            CodeEmailMKT\Action\PingAction::class => CodeEmailMKT\Action\PingAction::class,
        ],
        'factories' => [
            CodeEmailMKT\Action\HomePageAction::class => CodeEmailMKT\Action\HomePageFactory::class,
            CodeEmailMKT\Action\TestePageAction::class => CodeEmailMKT\Action\TestePageFactory::class,
            CodeEmailMKT\Action\ExerciseOnePageAction::class => CodeEmailMKT\Action\ExerciseOnePageFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => CodeEmailMKT\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'api.ping',
            'path' => '/api/ping',
            'middleware' => CodeEmailMKT\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'teste',
            'path' => '/teste-aula',
            'middleware' => CodeEmailMKT\Action\TestePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'exercise.one',
            'path' => '/teste',
            'middleware' => CodeEmailMKT\Action\ExerciseOnePageAction::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
