import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';

try {
    document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, eventCallback);
} catch(e) {
    // error handling
}

function eventCallback(updatedCookies) {
    try {
        // Check if brevo-chat-widget cookie status has changed
        if (typeof updatedCookies.detail['brevo-chat-widget'] !== 'undefined') {
            const isAccepted = updatedCookies.detail['brevo-chat-widget'];
            
            if (isAccepted) {
                // Cookie accepted - reload to show widget
                setTimeout(() => {
                    window.location.reload();
                }, 75);
            } else {
                // Cookie rejected - hide widget immediately and reload
                const brevoWidget = document.querySelector('#brevo-conversations-widget');
                if (brevoWidget) {
                    brevoWidget.style.display = 'none';
                }
                // Also remove the widget iframe if exists
                const brevoIframe = document.querySelector('iframe[src*="conversations-widget.brevo.com"]');
                if (brevoIframe) {
                    brevoIframe.remove();
                }
                // Reload to ensure clean state
                setTimeout(() => {
                    window.location.reload();
                }, 75);
            }
        }
    } catch(e) {
        // error handling
    }
}
