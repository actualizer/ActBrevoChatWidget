<?php declare(strict_types=1);

namespace Act\BrevoChatWidget\Subscriber;

use Shopware\Core\Content\Cookie\Event\CookieGroupCollectEvent;
use Shopware\Core\Content\Cookie\Struct\CookieEntry;
use Shopware\Core\Content\Cookie\Struct\CookieEntryCollection;
use Shopware\Core\Content\Cookie\Struct\CookieGroup;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CookieGroupCollectSubscriber implements EventSubscriberInterface
{
    private const GROUP_TECHNICAL_NAME = 'cookie.groupChat';

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
            CookieGroupCollectEvent::class => 'onCookieGroupCollect'
        ];
    }

    public function onCookieGroupCollect(CookieGroupCollectEvent $event): void
    {
        $salesChannelId = $event->getSalesChannelContext()->getSalesChannelId();

        $consentType = $this->systemConfigService->get('ActBrevoChatWidget.config.consentType', $salesChannelId);
        if ($consentType !== 'shopware') {
            return;
        }

        $group = $event->cookieGroupCollection->get(self::GROUP_TECHNICAL_NAME);
        if (!$group instanceof CookieGroup) {
            $group = new CookieGroup(self::GROUP_TECHNICAL_NAME);
            $group->description = 'cookie.groupChatDescription';
            $group->setEntries(new CookieEntryCollection());
            $event->cookieGroupCollection->add($group);
        }

        // A group that is a cookie itself must not carry entries; setEntries()
        // would throw and take down every storefront page.
        if ($group->getCookie() !== null) {
            return;
        }

        $entries = $group->getEntries();
        if ($entries === null) {
            $entries = new CookieEntryCollection();
            $group->setEntries($entries);
        }

        $entry = new CookieEntry('brevo-chat-widget');
        $entry->name = 'brevo.cookie.name';
        $entry->description = 'brevo.cookie.description';
        $entry->value = '1';
        $entry->expiration = 30;

        $entries->add($entry);
    }
}
