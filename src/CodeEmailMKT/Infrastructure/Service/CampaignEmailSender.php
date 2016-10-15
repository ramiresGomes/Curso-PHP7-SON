<?php

declare(strict_types=1);

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Mailgun\Messages\BatchMessage;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSender implements CampaignEmailSenderInterface
{
    /**
     * @var Campaign
     */
    private $campaign;
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;
    /**
     * @var array
     */
    private $mailGunConfig;
    /**
     * @var Mailgun
     */
    private $mailgun;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(TemplateRendererInterface $templateRenderer, Mailgun $mailgun, array $mailGunConfig, CustomerRepositoryInterface $repository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->mailGunConfig = $mailGunConfig;
        $this->mailgun = $mailgun;
        $this->repository = $repository;
    }

    public function setCampaign(Campaign $campaign) : CampaignEmailSender
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function send()
    {
        $this->createCampaign();
        $batchMessage = $this->getBatchMessage();
        $tags = $this->campaign->getTags()->toArray();

        foreach ($tags as $tag) {
            $batchMessage->addTag($tag->getName());
        }

        $customers = $this->repository->findByTags($tags);

        foreach ($customers as $customer) {
            $name = (!$customer->getName() or $customer->getName() == '') ?
                $customer->getEmail : $customer->getName();

            $batchMessage->addToRecipient($customer->getEmail(), ['full_name' => $name]);
        }

        $batchMessage->finalize();
    }

    protected function getBatchMessage() : BatchMessage
    {
        $batchMessage = $this->mailgun->BatchMessage($this->mailGunConfig['domain']);
        $batchMessage->addCampaignId("campaign_{$this->campaign->getId()}");
        $batchMessage->setFromAddress('gc.edilene@gmail.com', ['full_name' => 'Sistema de email']);
        $batchMessage->setSubject($this->campaign->getSubject());
        $batchMessage->setHtmlBody($this->getHtmlBody());

        return $batchMessage;
    }

    protected function getHtmlBody() : string
    {
        $template = $this->campaign->getTemplate();

        return $this->templateRenderer->render('app::campaign/_campaign_template', [
            'content' => $template
        ]);
    }

    protected function createCampaign()
    {
        $domain = $this->mailGunConfig['domain'];
        try {
            $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        } catch (MissingEndpoint $ex) {
            $this->mailgun->post("$domain/campaigns", [
                'id' => "campaign_{$this->campaign->getId()}",
                'name' => $this->campaign->getName()
            ]);
        }
    }
}