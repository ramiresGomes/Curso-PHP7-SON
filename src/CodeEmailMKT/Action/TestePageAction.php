<?php

namespace CodeEmailMKT\Action;

use CodeEmailMKT\Entity\Category;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class TestePageAction
{
    private $template;
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->manager = $manager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $category = new Category();
        $category->setName('Nome da minha categoria');

        $this->manager->persist($category);
        $this->manager->flush();

        $categories = $this->manager->getRepository(Category::class)->findAll();

        return new HtmlResponse($this->template->render('app::teste', [
            'data' => 'dados passados para o template',
            'categories' => $categories,
        ]));
    }
}
