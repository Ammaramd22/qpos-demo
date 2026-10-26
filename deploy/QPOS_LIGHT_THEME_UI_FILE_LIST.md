# Files in QPOS-light-theme-ui-update.zip

Extract the ZIP in the existing QPOS `/sl` folder (the folder that contains `.env`). Paths below are relative to that folder.

| ZIP path | Action |
| --- | --- |
| `config/constants.php` | Replace. Asset version 899 → 900 only. |
| `public/sw.js` | Replace. Service worker cache name v4 → v5 only. |
| `public/css/pos-theme.css` | Replace. Desktop POS cart stays in the viewport. |
| `public/css/qpos-light.css` | Add. Light theme colors. |
| `public/js/pos-theme.js` | Replace. Theme toggle and per-user browser preference. |
| `resources/views/layouts/app.blade.php` | Replace. Applies the saved theme and loads the light stylesheet. |
| `resources/views/layouts/restaurant.blade.php` | Replace. Same theme hook for kitchen/orders screens. |
| `resources/views/layouts/partials/css.blade.php` | Replace. Admin table padding no longer forces POS cart cells. |
| `resources/views/layouts/partials/extracss.blade.php` | Replace. Sort icons, scrolling tables, modal width. |
| `resources/views/layouts/partials/javascripts.blade.php` | Replace. Loads `pos-theme.js`. |
| `resources/views/layouts/partials/header.blade.php` | Replace. Theme button and readable user-menu hover. |
| `resources/views/layouts/partials/header-pos.blade.php` | Replace. POS theme button. |
| `resources/views/layouts/partials/header-restaurant.blade.php` | Replace. Kitchen theme button. |
| `resources/views/purchase/partials/purchase_table.blade.php` | Replace. Purchase table scrolls inside DataTables. |

Manual step after extract, only if the file exists:

- Back up and then delete `bootstrap/cache/config.php` so asset version 900 is used.
- Do not delete `.env` or anything in `public/uploads` or `storage/app`.

No database import is required.
