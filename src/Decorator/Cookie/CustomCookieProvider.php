<?php declare(strict_types=1);

namespace Act\BrevoChatWidget\Decorator\Cookie;

use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Framework\Cookie\CookieProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomCookieProvider implements CookieProviderInterface
{
    private CookieProviderInterface $originalService;
    private SystemConfigService $systemConfigService;
    private RequestStack $requestStack;

    public function __construct(
        CookieProviderInterface $service,
        SystemConfigService $systemConfigService,
        RequestStack $requestStack
    ) {
        $this->originalService = $service;
        $this->systemConfigService = $systemConfigService;
        $this->requestStack = $requestStack;
    }

    private const singleCookie = [
        'snippet_name' => 'brevo.cookie.name',
        'snippet_description' => 'brevo.cookie.description',
        'cookie' => 'brevo-chat-widget',
        'value' => '1',
        'expiration' => '30'
    ];

    private const cookieGroup = [
        'snippet_name' => 'cookie.groupChat',
        'snippet_description' => 'cookie.groupChatDescription',
        'entries' => [
            [
                'snippet_name' => 'brevo.cookie.name',
                'snippet_description' => 'brevo.cookie.description',
                'cookie' => 'brevo-chat-widget',
                'value' => '1',
                'expiration' => '30'
            ]
        ],
    ];

    public function getCookieGroups(): array
    {
        $cookies = $this->originalService->getCookieGroups();

        $salesChannelId = $this->resolveSalesChannelId();

        // Prüfe ob Shopware Cookie Consent aktiviert ist
        $consentType = $this->systemConfigService->get('ActBrevoChatWidget.config.consentType', $salesChannelId);
        if ($consentType !== 'shopware') {
            return $cookies;
        }

        $cookieIsSet = false;

        foreach ($cookies as &$cookie) {
            if ($cookie['snippet_name'] === 'cookie.groupChat') {
                $cookieIsSet = true;
                if (isset($cookie['entries']) && is_array($cookie['entries'])) {
                    $cookie['entries'][] = self::singleCookie;
                } else {
                    $cookie['entries'] = [self::singleCookie];
                }
            }
        }

        if (!$cookieIsSet) {
            $cookies = array_merge($cookies, [self::cookieGroup]);
        }

        return $cookies;
    }

    private function resolveSalesChannelId(): ?string
    {
        $request = $this->requestStack->getMainRequest();
        if ($request === null) {
            return null;
        }

        $salesChannelId = $request->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_ID);

        return is_string($salesChannelId) ? $salesChannelId : null;
    }
}
