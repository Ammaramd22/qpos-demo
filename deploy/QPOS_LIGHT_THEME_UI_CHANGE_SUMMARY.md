# QPOS light theme and UI update — change summary

## What was wrong

The dark theme is the live look of QPOS. A light theme was only partly built:

- `public/js/pos-theme.js` could save `light` or `dark` and look for a toggle button, but no layout loaded that file.
- The POS layout forced `data-vspos-theme="dark"` on every POS page, so a saved choice could not apply.
- Admin pages never set a theme attribute. Their colors are hardcoded dark in `css.blade.php`, `extracss.blade.php`, `app.blade.php`, the header, and the sidebar.
- Light rules existed only for a few POS modals.

UI bugs that came from shared CSS:

- DataTables sort icons are absolutely positioned and need about 28px of right padding. Later rules set header padding with `!important`, so the icon sat on top of the column title.
- Admin table cells used `white-space: nowrap` globally, including the POS cart, so text and buttons could spill into the next column.
- The purchase list scrolled the whole card and the DataTables body at the same time, which lets the header and body columns drift apart.
- Bootstrap `.row` negative margins inside DataTables wrappers added a sideways page scroll.
- Classic POS locked the cart to the viewport only up to 1680px wide. On a 1920px desktop, `#scrollable-container` is `overflow: hidden`, so extra cart rows and the Pay panel could be clipped.
- The user-menu button turned light gray on hover while the name stayed white, so the name disappeared.

## What the light theme includes

The existing switcher is now connected. It is not a second settings system and it does not use a database column.

- A small script in the page head reads the saved choice before the page paints.
- The choice is stored in the browser as `vspos_theme_u_<user id>`, so two users on one browser do not share a theme.
- If nobody has chosen yet, the theme stays dark.
- The sun/moon button is in the admin top bar, the POS header (desktop and the mobile POS bar), and the restaurant/kitchen header.
- `public/css/qpos-light.css` supplies the light colors for admin pages, the dashboard, forms, tables, Select2, menus, dialogs, date pickers, POS, and touch POS.
- Dark styles are unchanged when `data-vspos-theme="dark"`.
- Asset version is 900, and the service-worker cache name is `qpos-sw-v5`, so browsers drop old stylesheets.

## UI fixes

- Sort icons sit in reserved header padding instead of on the label.
- Admin cells wrap unless the table is one of the wide scrolling lists (sales, purchases, and the other scroll wrappers).
- Purchase list scrolling matches the sales list: the DataTables body scrolls, and the header stays aligned.
- DataTables toolbars no longer use the Bootstrap row's negative margin.
- Modals on narrow screens stay within the viewport and the body can scroll.
- Classic desktop POS keeps the cart list and the order panel inside the viewport from 992px upward, so added rows scroll instead of being clipped.
- User-menu hover stays readable in the dark theme.

## Files modified

- `config/constants.php`
- `public/sw.js`
- `public/css/pos-theme.css`
- `public/css/qpos-light.css` (new)
- `public/js/pos-theme.js`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/restaurant.blade.php`
- `resources/views/layouts/partials/css.blade.php`
- `resources/views/layouts/partials/extracss.blade.php`
- `resources/views/layouts/partials/header.blade.php`
- `resources/views/layouts/partials/header-pos.blade.php`
- `resources/views/layouts/partials/header-restaurant.blade.php`
- `resources/views/layouts/partials/javascripts.blade.php`
- `resources/views/purchase/partials/purchase_table.blade.php`

No sales, purchase, stock, accounting, or payment calculations were changed. No migration was added. No Composer or npm packages were added.

## Tests performed

Browser checks on a local preview that loads `qpos-light.css` and `pos-theme.js` against the same kind of forced-dark rules the admin pages use:

- Dark theme: cards `rgb(17, 17, 17)`, light text.
- Light theme: cards and inputs `rgb(255, 255, 255)`, text `rgb(17, 24, 39)`, navbar text `rgb(17, 24, 39)`.
- The toggle button label switched between "Switch to light theme" and "Switch to dark theme".
- After a reload, the saved theme was still light, then switching back saved dark.
- A second user key (`vspos_theme_u_99`) stayed empty.
- No sideways page overflow at 768px, 1366px (screenshot), or 1920px.
- Applying the sort-icon padding rule produced `padding-right: 28px` and placed the icon at `right: 6px`.

Not verified in a logged-in QPOS session: the local MySQL database `VsoftPOS` was not reachable from this machine, so login, live DataTables, POS cart entry, payments, reports, and module screens were not clicked through in the real application. Those screens use the shared layout and stylesheet changes above. Confirm them on the live site after upload, using the steps in the installation guide.

## Deployment

Use `deploy/QPOS-light-theme-ui-update.zip` with cPanel File Manager. Follow `deploy/QPOS_LIGHT_THEME_UI_CPANEL_GUIDE.md`. The file list is `deploy/QPOS_LIGHT_THEME_UI_FILE_LIST.md`.
