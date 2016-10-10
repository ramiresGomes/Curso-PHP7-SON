<?php

namespace CodeEmailMKT\Application\Action\Customer;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerRemovePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CustomerRepositoryInterface::class);
        $route = $container->get(RouterInterface::class);

        return new CustomerRemovePageAction($repository, $template, $route);
    }
}