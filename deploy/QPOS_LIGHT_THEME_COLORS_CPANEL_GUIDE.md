# QPOS light theme color fix — cPanel install

This update corrects Light Theme colors. It does not change sales, stock, purchases, payments, or the database.

The ZIP is `deploy/QPOS-light-theme-colors-update.zip`.
Extract it into the Laravel folder that already contains `.env` (the `/sl` installation), not into `public/` only.

## 1. Back up the site files

1. In cPanel, open **File Manager**.
2. Open the directory that contains `.env`, `artisan`, `app`, `public`, and `resources`.
3. Select that folder and use **Compress** to create a backup ZIP.
4. Download that backup ZIP to your computer before replacing anything.

## 2. Back up the database

1. In cPanel, open **phpMyAdmin**.
2. Select the QPOS database.
3. Open **Export**, leave the format as SQL, and click **Go**.
4. Save the `.sql` file with the file backup.

This update does not run a migration and does not change business data. The export is only for rollback safety.

## 3. Upload the update

1. In File Manager, stay in the Laravel root (the folder with `.env`).
2. Upload `QPOS-light-theme-colors-update.zip`.
3. Select the ZIP and click **Extract**.
4. Extract into the current directory so the paths inside the ZIP replace the matching files.
5. Confirm these files were replaced:

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

Do not replace `.env`, `public/uploads`, or anything under `storage/app`.

## 4. Clear cached files without a terminal

If `bootstrap/cache/config.php` exists, delete that file only. Do not delete `.env`. Deleting it lets the new asset version in `config/constants.php` load. cPanel will not rebuild it until someone runs artisan, which this server cannot do. The application still reads `config/constants.php` directly when that cache file is absent.

Optional, if the dashboard still looks like the old theme after a hard refresh:

1. Open `storage/framework/views`.
2. Delete the `.php` files inside that folder.
3. Do not delete the folder, and do not delete `storage/app` or `public/uploads`.

There is no public cache-clear URL. Do not add one.

## 5. Clear the browser cache

1. Open the site.
2. Hard refresh (Ctrl+F5), or use a private window.
3. The service worker cache name is now `qpos-sw-v8`. Reloading the site once replaces the previous worker.

## 6. Check Light Theme

1. Sign in and switch to Light Theme with the sun/moon control. Leave it selected and open another page. It should stay on Light Theme.
2. Home: the page behind the cards is a light grey. Cards are white. The welcome line, quote, and clock sit fully above the statistic cards. Clock digits are light grey with dark numbers. The date filter is a white button. Each metric icon has its own pastel tile. Text on the cards is dark.
3. POS: cart product names should be dark charcoal. SKU and the edit icon should be readable grey. Quantity pills can stay dark. The Pay button stays gold.
4. Open a list page (Products or Sales), a filter panel, a dropdown, and a modal. Text should be dark on white or light grey.

## 7. Check Dark Theme

1. Switch back to Dark Theme.
2. Home cards, the sidebar, and the POS product grid should return to the existing charcoal surfaces with light text. The clock returns to black digits with gold numbers, and the date filter returns to gold.
3. The Pay button stays gold. Prices on dark product cards stay gold.

## 8. Roll back

1. Delete the files listed above, or restore them from the backup ZIP by extracting the backup over the site.
2. If you deleted `bootstrap/cache/config.php`, restore that file from the backup as well.
3. If you deleted compiled views, restore `storage/framework/views` from the backup, or leave the folder empty so Laravel recompiles them on the next page load.
4. Hard refresh the browser.
5. Restore the database from the phpMyAdmin export only if something outside this update changed data. This package does not require a database restore.
