<?php

use CodeEmailMKT\Application\Form\{
    CampaignForm, CustomerForm, Factory\CampaignFormFactory, Factory\CustomerFormFactory, Factory\LoginFormFactory, Factory\TagFormFactory, LoginForm, TagForm
};

use CodeEmailMKT\Infrastructure\View\HelperPluginManagerFactory;
use Zend\Form\ConfigProvider;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Helper\Service\IdentityFactory;
use Zend\View\HelperPluginManager;

$forms = [
    'dependencies' => [
        'alias' => [],
        'invokables' => [],
        'factories' => [
            HelperPluginManager::class => HelperPluginManagerFactory::class,
            CustomerForm::class => CustomerFormFactory::class,
            LoginForm::class => LoginFormFactory::class,
            TagForm::class => TagFormFactory::class,
            CampaignForm::class => CampaignFormFactory::class,
        ]
    ],
    'view_helpers' => [
        'alias' => [],
        'invokables' => [],
        'factories' => [
            'identity' => IdentityFactory::class
        ]
    ]
];

$configProviderForm = (new ConfigProvider())->__invoke();

return ArrayUtils::merge($configProviderForm, $forms);