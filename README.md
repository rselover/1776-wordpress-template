# 1776 WordPress Template

Demo WordPress theme for 1776, built from scratch (no parent or starter theme).

A minimal WordPress block theme (Full Site Editing) to build on.

## Structure
- `style.css` – theme header (name, version) and base styles
- `theme.json` – colors, typography, layout settings
- `functions.php` – theme setup hooks
- `templates/` – page templates (`index.html`)
- `parts/` – reusable parts (`header.html`, `footer.html`)

## Use it
1. Zip this folder (or clone it) into `wp-content/themes/1776-wordpress-template`.
2. In WordPress admin, go to Appearance → Themes and activate **1776**.

For local development, [WordPress Playground](https://wordpress.org/playground/), `wp-env`, or LocalWP all work.

## Hosting
WordPress needs PHP and a database, so it can't run on GitHub Pages. Use a managed WordPress host or a small VPS, or export a static copy (e.g. with Simply Static) if the site has no dynamic features.
