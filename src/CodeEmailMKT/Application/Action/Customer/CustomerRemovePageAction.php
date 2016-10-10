<?php

namespace CodeEmailMKT\Application\Action\Customer;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerRemovePageAction
{
    private $template;

    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        CustomerRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $flash = $request->getAttribute('flash');

        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);

        if ($request->getMethod() == 'POST') {
            $flash = $request->getAttribute('flash');
            $flash->setMessage('success', "Contato \"{$entity->getName()}\" removido com sucesso!");

            $this->repository->remove($entity);

            $uri = $this->router->generateUri('customer.list');

            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::customer/remove', [
            'customer' => $entity
        ]));
    }
}
