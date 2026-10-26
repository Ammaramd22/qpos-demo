# QPOS light theme color fix — change and test report

## Root cause

Light Theme was already selected. The page, sidebar, and header followed it. Several surfaces did not, because their colors were fixed hex values instead of the theme variables.

1. Dashboard cards (`.db-stat`), the quote bar, the time chip, tables, and the shortcut menu used dark fills and light text in `home/index.blade.php`. The previous light stylesheet painted some panels white and then forced nearly every dashboard `div` to charcoal. Cards that stayed dark ended up with dark text on a dark fill. The clock and quote stayed on the dark fill.
2. Touch POS product names, SKUs, and stock were set to `#e5e5e5` in `public/css/pos-touch.css`. That file is linked from the POS page and those rules used `!important`. On a light card the secondary lines were too faint. Prices were forced to gold, which does not have enough contrast on white.
3. The sidebar search box was hardcoded `#141414` with `#f5f5f5` text in `sidebar.blade.php`. Those rules are printed in the page body, after the light stylesheet.
4. `layouts/app.blade.php` had a final block of dark `!important` rules for filters, DataTables, select2, and SweetAlert. It was not limited to Dark Theme, and it loaded after `qpos-light.css`. Any control the light file did not override stayed dark.

Dark Theme is unchanged in intent. The same properties now read CSS variables. Dark values are the previous hex colors. Light values are set only under `html[data-vspos-theme="light"]`.

## What changed

- Dashboard surfaces, text, tables, charts, cheque cards, and icons use `--db-*` tokens. Light values live on `.db-page`.
- Shortcut menu uses `--db-quick-*` tokens.
- Touch POS product, category, search, customer, and service colors use `--touch-*` tokens. Light names are `#111827`, secondary text is `#374151`, and prices are `#15803d`. Dark prices stay `#f5c518`.
- Empty product state no longer uses an inline dark button.
- Sidebar search uses `--sb-search-*` tokens.
- The late dark overrides in the admin layout apply only when `data-vspos-theme="dark"`.
- Asset version is `903`. Service worker cache is `qpos-sw-v8` (registration query `v=9`).

No sales, stock, payment, or accounting logic was changed. No migration was added.

## Files in the update ZIP

- `config/constants.php`
- `public/sw.js`
- `public/css/qpos-light.css`
- `public/css/pos-touch.css`
- `public/css/pos-theme.css`
- `resources/views/home/index.blade.php`
- `resources/views/home/partials/quick_menu.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/partials/sidebar.blade.php`
- `resources/views/sale_pos/partials/product_list.blade.php`

## Tests actually run

A local fixture page loaded the real `pos-theme.css`, `pos-touch.css`, `qpos-light.css`, and the dashboard and shortcut CSS from the Blade files. Computed colors were read in the browser.

Light Theme:

- Statistic card background `rgb(255, 255, 255)`, value text `rgb(17, 24, 39)`, label and description `rgb(75, 85, 99)`.
- Quote bar background `rgb(243, 244, 246)` with dark text. Clock digits stayed gold `rgb(245, 197, 24)`.
- Shortcut menu background white, label `rgb(17, 24, 39)`.
- Product card white. Product name `rgb(17, 24, 39)`. Stock line `rgb(55, 65, 81)`. Price `rgb(21, 128, 61)`.
- Category button white with dark text. Search field light with dark input text.

Dark Theme:

- Quote bar `rgba(20, 20, 20, 0.75)` with text `rgb(248, 250, 252)`.
- Shortcut menu `rgb(17, 17, 17)`.
- Product card `rgb(22, 22, 22)`, name `rgb(245, 245, 245)`, stock `rgb(212, 212, 212)`, price `rgb(245, 197, 24)`.
- Search field `rgb(10, 10, 10)`.
- Visual check of the dashboard fixture matched the existing charcoal cards and light text.

At the browser layout width (about 1440–1920px) the fixture had no horizontal overflow (`scrollWidth` equaled `clientWidth`).

## Tests not run

The local MySQL database did not accept a connection (`db_fail`), so a signed-in walkthrough of the live modules was not possible. These were not clicked in the running application:

- Theme toggle persistence across real navigation
- DataTables, date pickers, payment modal, and cart rows with live data
- Vehicle, tyre, and mobile shop screens
- Viewports 1366×768, 768px, and 360×740. The browser device override did not change the layout width reliably, so those sizes were not verified.

CSS brace counts were checked for the edited stylesheets. They balance.

## Follow-up from the live screenshots

The live Light Theme still had two problems after the first color pass.

Cart product names were forced to `#f5f5f5` by an unscoped rule in `public/css/pos-theme.css` (`body.lockscreen #pos_table ... .vspos-line-name`). That rule won over the light table-cell color, so names stayed near-white on the white cart. SKU and the edit icon used `#737373`. Those rules now use `--vspos-text` and `--vspos-text-soft`. Dark Theme still resolves them to `#f5f5f5` and `#737373`. Light Theme resolves them to `#111827` and `#475569`.

Dashboard cards overlapped the hero because `.db-hero` keeps 94px of bottom padding and `.db-stats-primary` is pulled up with a negative margin. That float is kept for Dark Theme. In Light Theme the hero padding is 24px and the cards start 18px below the hero, so they no longer cover the quote or the white band.

Browser check of the real stylesheets:

- Light: product name `rgb(17, 24, 39)`, SKU and edit icon `rgb(71, 85, 105)`, card margin `18px`, no overlap with the hero.
- Dark: product name `rgb(245, 245, 245)`, SKU `rgb(115, 115, 115)`, card margin `-52px`, hero padding `94px`, the original overlap remains.

Asset version is `903`. Service worker cache is `qpos-sw-v8`.

## Reference dashboard pass

The live Light Theme was readable but flatter than the reference: the page was one white field, several metric icons were grey or gold, the clock stayed a black LED, and the date filter stayed a gold button.

Light Theme now uses `#f8fafc` as the page background and white cards with a light slate border. Metric icons use separate pastel tiles (orange, green, yellow, pink, blue, lavender). The clock digits are light grey with dark numbers. The date filter is a white button. Dark Theme still uses the gold LED, gold icons, gold filter, and the overlapping card layout.

These rules are limited to `html[data-vspos-theme="light"]`.

## Limitations

Shared admin screens (products, contacts, purchases, reports, settings) pick up Light Theme through `qpos-light.css` plus the dark-only scope on the late override block. Those pages were not opened while signed in. If a module still has its own inline dark colors, that module still needs a follow-up. The dashboard, shortcut menu, sidebar search, and touch POS were the sources behind the screenshots and are the ones this package changes.
