import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';

try {
    document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, eventCallback);
} catch(e) {
    // error handling
}

function eventCallback(updatedCookies) {
    try {
        if (typeof updatedCookies.detail['brevo-chat-widget'] !== 'undefined' && updatedCookies.detail['brevo-chat-widget']) {
            setTimeout(() => {
                window.location.reload(); // reload page
            }, 75);
        }
    } catch(e) {
        // error handling
    }
}
