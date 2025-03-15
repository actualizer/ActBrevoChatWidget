# Actualize: Brevo Chat Widget

Dieses Shopware 6 Plugin ermöglicht die DSGVO-konforme Integration des Brevo Chat Widgets in deinen Shopware 6 Shop.

## Funktionen

- Einfache Integration des Brevo Chat Widgets
- DSGVO-konforme Einbindung über die Shopware Cookie-Verwaltung
- Konfigurierbare Brevo Conversations ID

## Installation

1. Lade das Plugin in das Verzeichnis `custom/plugins/ActBrevoChatWidget` deines Shopware 6 Shops hoch.
2. Installiere das Plugin über die Shopware Administration oder über die Kommandozeile:

```bash
bin/console plugin:install --activate ActBrevoChatWidget
```

3. Leere den Cache:

```bash
bin/console cache:clear
```

## Konfiguration

1. Öffne die Shopware Administration und navigiere zu **Erweiterungen > Meine Erweiterungen**.
2. Wähle das Plugin "Actualize: Brevo Chat Widget" aus und klicke auf "Konfigurieren".
3. Aktiviere das Plugin, indem du den Schalter "Brevo Chat Widget aktiv" auf "Ja" setzt.
4. Gib deine Brevo Conversations ID ein. Diese findest du in deinem Brevo Account.
5. Wähle den gewünschten Cookie Consent Typ aus:
   - **Ohne Consent**: Das Chat Widget wird immer geladen, ohne dass der Benutzer zustimmen muss.
   - **Shopware Cookie Consent**: Das Chat Widget wird nur geladen, wenn der Benutzer den entsprechenden Cookie akzeptiert hat.
6. Speichere die Konfiguration.

## Verwendung

Nach der Installation und Konfiguration wird das Brevo Chat Widget automatisch im Frontend deines Shops angezeigt, sofern der Benutzer den entsprechenden Cookie akzeptiert hat (abhängig von der gewählten Cookie Consent Konfiguration).

## Support

Bei Fragen oder Problemen wende dich bitte an [Actualize](https://www.actualize.de).
