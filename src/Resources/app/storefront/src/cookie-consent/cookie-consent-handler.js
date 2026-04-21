import Plugin from 'src/plugin-system/plugin.class';
import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';

/**
 * Shopware's CookieConfiguration_Update event only carries cookies that
 * changed against its internal lastState. When the visitor uses the
 * "Accept all" shortcut on the cookie bar (not the off-canvas), that
 * lastState is empty and the event fires with an empty detail object.
 * Keying off event.detail['brevo-chat-widget'] therefore silently
 * missed the change, so the widget only appeared on the next full page
 * load. Read document.cookie directly and compare against the state
 * captured at init time.
 */
const COOKIE_NAME = 'brevo-chat-widget';
const COOKIE_PATTERN = new RegExp('(?:^|; )' + COOKIE_NAME + '=1');

export default class ActBrevoCookieHandlerPlugin extends Plugin {
    init() {
        this._lastAccepted = COOKIE_PATTERN.test(document.cookie);
        this._onUpdate = this._onUpdate.bind(this);
        document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, this._onUpdate);
    }

    _onUpdate() {
        const accepted = COOKIE_PATTERN.test(document.cookie);
        if (accepted === this._lastAccepted) {
            return;
        }

        this._lastAccepted = accepted;

        if (!accepted) {
            const widget = document.querySelector('#brevo-conversations-widget');
            if (widget) {
                widget.style.display = 'none';
            }
            const iframe = document.querySelector('iframe[src*="conversations-widget.brevo.com"]');
            if (iframe) {
                iframe.remove();
            }
        }

        setTimeout(() => window.location.reload(), 75);
    }
}
