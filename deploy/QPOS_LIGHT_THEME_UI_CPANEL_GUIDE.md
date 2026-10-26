# QPOS light theme and UI update — cPanel installation

This update does not change the database, `.env`, uploaded files, or business calculations. You can install it with cPanel File Manager only.

The live site is `qpos.avenque.io/sl`. The ZIP extracts into the existing QPOS folder (the folder that already contains `app`, `public`, `resources`, `config`, and `.env`). Do not extract it into `public` only.

## 1. Back up the current files

1. In cPanel, open **File Manager**.
2. Open the QPOS folder used by `/sl`.
3. Select these existing files and folders and click **Compress** to make a backup ZIP. Download that ZIP to your computer before continuing.

   - `config/constants.php`
   - `public/sw.js`
   - `public/css/pos-theme.css`
   - `public/js/pos-theme.js`
   - `resources/views/layouts/app.blade.php`
   - `resources/views/layouts/restaurant.blade.php`
   - `resources/views/layouts/partials/css.blade.php`
   - `resources/views/layouts/partials/extracss.blade.php`
   - `resources/views/layouts/partials/javascripts.blade.php`
   - `resources/views/layouts/partials/header.blade.php`
   - `resources/views/layouts/partials/header-pos.blade.php`
   - `resources/views/layouts/partials/header-restaurant.blade.php`
   - `resources/views/purchase/partials/purchase_table.blade.php`

4. Leave `.env`, `storage/app`, and `public/uploads` untouched.

## 2. Database backup

This package does not add or change database tables. A database backup is still recommended before any live update.

1. Open **phpMyAdmin** from cPanel.
2. Select the QPOS database.
3. Open **Export**.
4. Choose **Quick** and format **SQL**.
5. Click **Go** and save the `.sql` file.

Do not import that file unless you are rolling back the database. This update does not need an import.

## 3. Upload the ZIP

1. In File Manager, open the QPOS `/sl` folder (the same folder that contains `.env`).
2. Click **Upload**.
3. Upload `QPOS-light-theme-ui-update.zip`.
4. After the upload finishes, go back to the folder. You should see the ZIP next to `app`, `public`, and `resources`.

## 4. Extract it

1. Right-click `QPOS-light-theme-ui-update.zip`.
2. Click **Extract**.
3. Extract into the current QPOS folder, not into a new subfolder.
4. When cPanel asks to overwrite existing files, confirm overwrite for the files in this package only.
5. Check that `public/css/qpos-light.css` now exists. That file is new.
6. Delete the uploaded ZIP from the server after a successful check, so it is not left in the web root. Deleting the ZIP does not remove the extracted files.

Do not overwrite or delete `.env`. The ZIP does not contain `.env`.

## 5. Files that are added or replaced

Added:

- `public/css/qpos-light.css`

Replaced:

- `config/constants.php` (asset version only, so browsers load the new CSS and JavaScript)
- `public/sw.js` (cache name only, so phones and installed apps drop the old stylesheet cache)
- `public/css/pos-theme.css`
- `public/js/pos-theme.js`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/restaurant.blade.php`
- `resources/views/layouts/partials/css.blade.php`
- `resources/views/layouts/partials/extracss.blade.php`
- `resources/views/layouts/partials/javascripts.blade.php`
- `resources/views/layouts/partials/header.blade.php`
- `resources/views/layouts/partials/header-pos.blade.php`
- `resources/views/layouts/partials/header-restaurant.blade.php`
- `resources/views/purchase/partials/purchase_table.blade.php`

No other files should be replaced. Uploaded logos, product images, invoices, and the database stay as they are.

## 6. Special handling

`config/constants.php` is included only to move the asset version from 899 to 900. It does not contain database passwords. If you have local edits in that file that are not in this package, copy your other settings back after extract and keep `'asset_version' => 900`.

If `bootstrap/cache/config.php` exists, Laravel will keep serving the old asset version and browsers may keep the old CSS.

1. Download a copy of `bootstrap/cache/config.php` first.
2. Delete only that file.
3. Do not delete `.env`, `bootstrap/cache/packages.php`, or `bootstrap/cache/services.php`.

Laravel rebuilds config from `.env` on the next page load. If the site shows an error after this deletion, upload your downloaded `config.php` again.

Compiled page templates are normally rebuilt when the Blade file is newer. If a page still looks old after a hard refresh:

1. Open `storage/framework/views/`.
2. Delete the `.php` files inside that folder.
3. Do not delete the folder itself, and do not delete anything under `storage/app` or `public/uploads`.

No terminal, Artisan, Composer, or npm command is required.

## 7. Verify

1. Hard-refresh the site (Ctrl+F5), or open it in a private window.
2. Log in.
3. In the top bar, use the sun / moon button.
4. Confirm the page turns light: white cards, dark text, light sidebar.
5. Click the button again and confirm the original dark theme returns.
6. Open Products, Purchases, and a report. Headers should not sit on top of the sort icon. Wide tables should scroll inside the card.
7. Open POS. Add several products. Cart rows should stay reachable, and Pay should stay on screen on a desktop window.
8. Refresh the page. The theme you selected should still be active.
9. Log out and log in again in the same browser. That user's theme should still be active. Another user on the same browser keeps a separate choice.

## 8. Roll back

1. Upload the backup ZIP you made in step 1 into the same QPOS folder.
2. Extract it and overwrite the updated files.
3. If you deleted `bootstrap/cache/config.php`, upload the copy you saved.
4. Hard-refresh the browser.
5. Do not import the SQL backup unless you also changed the database yourself. This update did not change it.
