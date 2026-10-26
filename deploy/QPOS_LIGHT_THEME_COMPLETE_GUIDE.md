# QPOS light theme completion — cPanel install

This update fixes Light Theme colors. It does not change sales, stock, payments, accounting, or the database.

The ZIP is `deploy/QPOS-light-theme-complete.zip`.
Extract it into the Laravel folder that already contains `.env`, not into `public/` only.

## 1. Back up

1. In cPanel File Manager, open the directory that contains `.env`, `artisan`, `app`, `public`, and `resources`.
2. Compress that folder and download the backup ZIP.
3. In phpMyAdmin, export the QPOS database as SQL and save it with the file backup.

This update does not run a migration. The database export is only for rollback safety. Do not replace `.env`, `public/uploads`, or `storage/app`.

## 2. Upload

1. Upload `QPOS-light-theme-complete.zip` into the Laravel root.
2. Extract it there so these paths are replaced:

- `config/constants.php`
- `public/sw.js`
- `public/css/qpos-light.css`
- `public/js/common.js`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/partials/css.blade.php`
- `resources/views/layouts/partials/extracss.blade.php`
- `resources/views/layouts/partials/javascripts.blade.php`

## 3. Clear caches

1. If `bootstrap/cache/config.php` exists, delete that file only.
2. Delete the compiled files inside `storage/framework/views`. Do not delete the folder, `storage/app`, or `public/uploads`.
3. Hard refresh the site (Ctrl+F5) or use a private window.
4. The service worker cache name is `qpos-sw-v9` (registration query `v=10`). Asset version is `904`.

## 4. Check

1. Light Theme: dashboard Export PDF is a white button with dark text, same as Export CSV and Columns. Tables, search fields, Previous/Next, and Portrait/Landscape stay readable.
2. Dark Theme: the same controls return to charcoal surfaces with light text. Save stays blue, Delete stays red, and the gold brand accent stays.

## 5. Roll back

Extract the backup ZIP from step 1 over the Laravel root, restore `bootstrap/cache/config.php` if you deleted it, and hard refresh. The database does not need to be restored unless it was changed outside this update.
