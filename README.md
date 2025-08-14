# ActBrevoChatWidget - Shopware Plugin

A Shopware 6 plugin that provides GDPR-compliant integration of the Brevo Chat Widget with configurable consent management and seamless Shopware cookie integration.

## Features

- ✅ Easy integration of Brevo Chat Widget
- ✅ GDPR-compliant implementation with cookie consent management
- ✅ Integration with Shopware's native cookie consent system
- ✅ Configurable consent types (with/without consent)
- ✅ Admin configuration for Brevo Conversations ID
- ✅ Automatic widget loading based on consent status
- ✅ Multi-language support (German & English)
- ✅ Compatible with Shopware 6.6.10 - 6.7.x

## Requirements

- Shopware 6.6.10 or higher (up to 6.7.x)
- PHP 8.3 or higher
- Valid Brevo account with Conversations feature

## Installation

1. Download or clone this plugin into your `custom/plugins/` directory
2. Install and activate the plugin via CLI:
   ```bash
   bin/console plugin:refresh
   bin/console plugin:install --activate ActBrevoChatWidget
   bin/console cache:clear
   ```

## Configuration

1. Go to Admin Panel → Settings → System → Plugins
2. Find "Actualize: Brevo Chat Widget" and click on the three dots
3. Click "Config" to access plugin settings

### Configuration Options

- **Brevo Chat Widget Active**: Enable/disable the chat widget
- **Brevo Conversations ID**: Your unique Brevo Conversations ID from your Brevo account
- **Cookie Consent Type**: Choose between:
  - `none`: Widget loads without consent (not GDPR compliant)
  - `shopware`: Widget loads only after user accepts cookies via Shopware's cookie consent

## How it works

### Cookie Consent Integration
1. **Shopware Cookie Consent**: When enabled, the plugin registers a new cookie group in Shopware's cookie management
2. **User Consent**: The chat widget only loads after the user accepts the "Chat" cookie category
3. **Cookie Management**: Users can revoke consent at any time through Shopware's cookie preferences

### Widget Loading
1. **Configuration Check**: Plugin verifies that chat widget is enabled and Conversations ID is provided
2. **Consent Verification**: Checks user's cookie consent status (if Shopware consent is enabled)
3. **Widget Initialization**: Loads Brevo chat widget script when all conditions are met
4. **Dynamic Loading**: Widget respects real-time consent changes without page reload

## Technical Details

### Events Used
- `PageLoadedEvent` - To inject chat widget configuration into all storefront pages

### Cookie Management
- Registers custom cookie group for chat functionality
- Integrates with Shopware's `CookieProviderInterface`
- Provides proper cookie descriptions and expiration settings

### Template Integration
- Injects widget configuration variables into Twig templates
- Supports conditional loading based on consent status
- No template modifications required - uses Shopware's extension system

## File Structure

```
ActBrevoChatWidget/
├── composer.json
├── LICENSE
├── README.md
├── src/
│   ├── ActBrevoChatWidget.php
│   ├── Decorator/
│   │   └── Cookie/
│   │       └── CustomCookieProvider.php
│   ├── Resources/
│   │   ├── app/
│   │   │   └── storefront/
│   │   │       ├── dist/
│   │   │       │   └── storefront/
│   │   │       │       └── js/
│   │   │       │           └── act-brevo-chat-widget/
│   │   │       │               └── act-brevo-chat-widget.js
│   │   │       └── src/
│   │   │           ├── cookie-consent/
│   │   │           │   └── cookie-consent-handler.js
│   │   │           └── main.js
│   │   ├── config/
│   │   │   ├── config.xml
│   │   │   ├── plugin.png
│   │   │   └── services.xml
│   │   ├── snippet/
│   │   │   ├── de_DE/
│   │   │   │   └── storefront.de-DE.json
│   │   │   └── en_GB/
│   │   │       └── storefront.en-GB.json
│   │   └── views/
│   │       └── storefront/
│   │           ├── base.html.twig
│   │           └── brevo_chat_widget.html.twig
│   └── Subscriber/
│       └── StorefrontRenderSubscriber.php
```

## Development

### Building/Testing
After making changes:
```bash
bin/console cache:clear
bin/console theme:compile
```

### Debugging
- Check browser console for chat widget loading errors
- Verify Brevo Conversations ID in plugin configuration
- Test cookie consent functionality in browser developer tools

## Getting Your Brevo Conversations ID

1. Log into your Brevo account
2. Navigate to **Conversations** → **Settings**
3. Go to **Installation** tab
4. Copy the Conversations ID from the widget installation code
5. Enter this ID in the plugin configuration

## Privacy & GDPR Compliance

### Cookie Information
- **Cookie Name**: `brevo-chat-widget`
- **Purpose**: Stores chat widget preferences and session data
- **Expiration**: 30 days
- **Type**: Functional/Marketing (depending on usage)

### Compliance Features
- User consent required before loading widget (when Shopware consent is enabled)
- Clear cookie descriptions in multiple languages
- Easy consent withdrawal through Shopware's cookie preferences
- No data collection without explicit user consent

## Compatibility

- **Shopware Version**: 6.6.10 - 6.7.x
- **PHP Version**: 8.3+
- **Brevo Integration**: Compatible with current Brevo Conversations API
- **Cookie Consent**: Integrates with Shopware's native cookie management

## Support

For issues and feature requests, please use the GitHub issue tracker.

## License

This plugin is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits

Developed by Actualize

---

Made with ❤️ for the Shopware Community
