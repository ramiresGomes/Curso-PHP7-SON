<?php

use CodeEmailMKT\Application\Action\Customer\{
    CustomerCreatePageAction, CustomerListPageAction, CustomerDeletePageAction, CustomerUpdatePageAction,
    Factory\CustomerCreatePageFactory, Factory\CustomerListPageFactory, Factory\CustomerDeletePageFactory, Factory\CustomerUpdatePageFactory
};

use CodeEmailMKT\Application\Action\Tag\{
    TagCreatePageAction, TagListPageAction, TagDeletePageAction, TagUpdatePageAction,
    Factory\TagCreatePageFactory, Factory\TagListPageFactory, Factory\TagDeletePageFactory, Factory\TagUpdatePageFactory
};

use CodeEmailMKT\Application\Action\Campaign\{
    CampaignCreatePageAction, CampaignListPageAction, CampaignDeletePageAction, CampaignReportPageAction, CampaignSenderPageAction, CampaignUpdatePageAction, Factory\CampaignCreatePageFactory, Factory\CampaignListPageFactory, Factory\CampaignDeletePageFactory, Factory\CampaignReportPageFactory, Factory\CampaignSenderPageFactory, Factory\CampaignUpdatePageFactory
};

use CodeEmailMKT\Application\Action\{
    LoginPageAction, LoginPageFactory, LogoutAction, LogoutFactory
};

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
        ],
        'factories' => [
            LoginPageAction::class => LoginPageFactory::class,
            LogoutAction::class => LogoutFactory::class,

            CustomerListPageAction::class => CustomerListPageFactory::class,
            CustomerCreatePageAction::class => CustomerCreatePageFactory::class,
            CustomerUpdatePageAction::class => CustomerUpdatePageFactory::class,
            CustomerDeletePageAction::class => CustomerDeletePageFactory::class,

            TagListPageAction::class => TagListPageFactory::class,
            TagCreatePageAction::class => TagCreatePageFactory::class,
            TagUpdatePageAction::class => TagUpdatePageFactory::class,
            TagDeletePageAction::class => TagDeletePageFactory::class,

            CampaignListPageAction::class => CampaignListPageFactory::class,
            CampaignCreatePageAction::class => CampaignCreatePageFactory::class,
            CampaignUpdatePageAction::class => CampaignUpdatePageFactory::class,
            CampaignDeletePageAction::class => CampaignDeletePageFactory::class,
            CampaignSenderPageAction::class => CampaignSenderPageFactory::class,
            CampaignReportPageAction::class => CampaignReportPageFactory::class,
        ],
    ],

    'routes' => [
        ['name' => 'home', 'path' => '/', 'middleware' => CustomerListPageAction::class, 'allowed_methods' => ['GET']],
        ['name' => 'auth.login', 'path' => '/auth/login', 'middleware' => LoginPageAction::class, 'allowed_methods' => ['GET', 'POST']],
        ['name' => 'auth.logout', 'path' => '/auth/logout', 'middleware' => LogoutAction::class, 'allowed_methods' => ['GET']],

        ['name' => 'customer.list', 'path' => '/admin/customers', 'middleware' => CustomerListPageAction::class, 'allowed_methods' => ['GET']],
        ['name' => 'customer.create', 'path' => '/admin/customer/create', 'middleware' => CustomerCreatePageAction::class, 'allowed_methods' => ['GET', 'POST']],
        ['name' => 'customer.update', 'path' => '/admin/customer/update/{id}', 'middleware' => CustomerUpdatePageAction::class, 'allowed_methods' => ['GET', 'PUT'], 'options' => ['tokens' => ['id' => '\d+']]],
        ['name' => 'customer.delete', 'path' => '/admin/customers/delete/{id}', 'middleware' => CustomerDeletePageAction::class, 'allowed_methods' => ['GET', 'DELETE'], 'options' => ['tokens' => ['id' => '\d+']]],

        ['name' => 'tag.list', 'path' => '/admin/tags', 'middleware' => TagListPageAction::class, 'allowed_methods' => ['GET']],
        ['name' => 'tag.create', 'path' => '/admin/tag/create', 'middleware' => TagCreatePageAction::class, 'allowed_methods' => ['GET', 'POST']],
        ['name' => 'tag.update', 'path' => '/admin/tag/update/{id}', 'middleware' => TagUpdatePageAction::class, 'allowed_methods' => ['GET', 'PUT'], 'options' => ['tokens' => ['id' => '\d+']]],
        ['name' => 'tag.delete', 'path' => '/admin/tags/delete/{id}', 'middleware' => TagDeletePageAction::class, 'allowed_methods' => ['GET', 'DELETE'], 'options' => ['tokens' => ['id' => '\d+']]],

        ['name' => 'campaign.list', 'path' => '/admin/campaigns', 'middleware' => CampaignListPageAction::class, 'allowed_methods' => ['GET']],
        ['name' => 'campaign.create', 'path' => '/admin/campaign/create', 'middleware' => CampaignCreatePageAction::class, 'allowed_methods' => ['GET', 'POST']],
        ['name' => 'campaign.update', 'path' => '/admin/campaign/update/{id}', 'middleware' => CampaignUpdatePageAction::class, 'allowed_methods' => ['GET', 'PUT'], 'options' => ['tokens' => ['id' => '\d+']]],
        ['name' => 'campaign.delete', 'path' => '/admin/campaigns/delete/{id}', 'middleware' => CampaignDeletePageAction::class, 'allowed_methods' => ['GET', 'DELETE'], 'options' => ['tokens' => ['id' => '\d+']]],
        ['name' => 'campaign.sender', 'path' => '/admin/campaigns/sender/{id}', 'middleware' => CampaignSenderPageAction::class, 'allowed_methods' => ['GET', 'POST'], 'options' => ['tokens' => ['id' => '\d+']]],
        ['name' => 'campaign.report', 'path' => '/admin/campaigns/report/{id}', 'middleware' => CampaignReportPageAction::class, 'allowed_methods' => ['GET'], 'options' => ['tokens' => ['id' => '\d+']]],
    ],
];
