<?php declare(strict_types=1);

namespace Act\BrevoChatWidget\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\PageLoadedEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Core\PlatformRequest;

class StorefrontRenderSubscriber implements EventSubscriberInterface
{
    const CONFIG_PATH = 'ActBrevoChatWidget.config';

    private $config = null;

    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    public function __construct(
        SystemConfigService $systemConfigService
    )
    {
        $this->systemConfigService = $systemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PageLoadedEvent::class => 'onPageLoaded'
        ];
    }

    public function onPageLoaded(PageLoadedEvent $event)
    {
        $request = $event->getRequest();
        $salesChannelId = $request->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_CONTEXT_OBJECT)->getSalesChannelId();
        
        // Load all config values
        $this->config = $this->systemConfigService->get(self::CONFIG_PATH, $salesChannelId);
        
        // Check if chat widget is active
        if (empty($this->config['brevoChatActive']) || empty($this->config['brevoConversationsID'])) {
            return;
        }

        $page = $event->getPage();
        
        // Add consent type to template
        $page->assign(['brevoConsentType' => $this->config['consentType'] ?? 'shopware']);
        $page->assign(['brevoConversationsID' => $this->config['brevoConversationsID']]);
    }
}
