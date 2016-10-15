<?php

declare(strict_types=1);

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReport implements CampaignReportInterface
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

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        Mailgun $mailgun,
        array $mailGunConfig,
        CustomerRepositoryInterface $repository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->mailGunConfig = $mailGunConfig;
        $this->mailgun = $mailgun;
        $this->repository = $repository;
    }

    public function setCampaign(Campaign $campaign) : CampaignReport
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function render() : ResponseInterface
    {

        return new HtmlResponse($this->templateRenderer->render('app::campaign/report', [
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCustomers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    protected function getCampaignData()
    {
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");

        return $response->http_response_body;
    }

    public function getCountOpenedDistinct()
    {
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}/opens", [
            'groupby' => 'recipient',
            'count' => true
        ]);

        return $response->http_response_body->count;
    }

    protected function getCountCustomers()
    {
        $tags = $this->campaign->getTags()->toArray();
        $customers = $this->repository->findByTags($tags);

        return count($customers);
    }
}