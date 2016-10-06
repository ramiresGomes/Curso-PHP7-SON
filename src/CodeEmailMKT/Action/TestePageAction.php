<?php

namespace CodeEmailMKT\Action;

use CodeEmailMKT\Entity\Address;
use CodeEmailMKT\Entity\Category;
use CodeEmailMKT\Entity\Client;
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
        $client = new Client();
        $client->setName('Client 1');
        $client->setEmail('client1@admin.com');
        $client->setCpf('652.685.415.58');

        $this->manager->persist($client);

        $address1 = new Address();
        $address1->setClient($client);
        $address1->setAddress("Rua do dolar, 123");
        $address1->setCity("São Gonçalo");
        $address1->setState("SP");
        $address1->setZipcode("36854-965");
        $this->manager->persist($address1);

        $address2 = new Address();
        $address2->setClient($client);
        $address2->setAddress("Rua do Assentamento, 123");
        $address2->setCity("Uberaba");
        $address2->setState("MG");
        $address2->setZipcode("45854-975");
        $this->manager->persist($address2);

        $address3 = new Address();
        $address3->setClient($client);
        $address3->setAddress("Avenida Sobe Descendo, 123");
        $address3->setCity("Juazeiro do Norte");
        $address3->setState("MT");
        $address3->setZipcode("45686-910");
        $this->manager->persist($address3);

        $this->manager->flush();

        $clients = $this->manager->getRepository(Address::class)->findAll();

        return new HtmlResponse($this->template->render('app::teste', [
            'data' => 'dados passados para o template',
            'clients' => $clients,
        ]));
    }
}
