import ActBrevoCookieHandlerPlugin from './cookie-consent/cookie-consent-handler';

window.PluginManager.register('ActBrevoCookieHandler', ActBrevoCookieHandlerPlugin, 'body');

if (module.hot) {
    module.hot.accept();
}
