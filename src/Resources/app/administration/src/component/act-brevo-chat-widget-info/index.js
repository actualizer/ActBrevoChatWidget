import template from './act-brevo-chat-widget-info.html.twig';
import './act-brevo-chat-widget-info.scss';

const { Component } = Shopware;

const HOW_TO_ITEM_COUNT = 5;

Component.register('act-brevo-chat-widget-info', {
    template,

    computed: {
        howToItems() {
            return Array.from(
                { length: HOW_TO_ITEM_COUNT },
                (_, index) => `act-brevo-chat-widget.settings.info.howTo.item${index + 1}`,
            );
        },
    },
});
