<?php

namespace CodeEmailMKT\Application\Form\Factory;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\InputFilter\CampaignInputFilter;
use CodeEmailMKT\Domain\Entity\Campaign;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Interop\Container\ContainerInterface;

class CampaignFormFactory
{
    public function __invoke(ContainerInterface $container) : CampaignForm
    {
        $entityManager = $container->get(EntityManager::class);
        $form = new CampaignForm();

        $form->setHydrator(new DoctrineHydrator($entityManager));
        $form->setObject(new Campaign());
        $form->setInputFilter(new CampaignInputFilter());
        $form->setObjectManager($entityManager);
        $form->init();

        return $form;
    }
}
