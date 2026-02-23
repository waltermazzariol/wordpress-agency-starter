# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
npm start          # Dev server with live reload (BrowserSync at http://waltermazzariolcom.local/)
npm run build      # Production build — minifies, PurgeCSS, creates ZIP in /bundled/
npm run lint       # ESLint on src/assets/js/**/*.js
npm run lint:fix   # ESLint with auto-fix
```

The build system uses **Gulp 4 + Webpack 5 + Sass**. Gulp orchestrates compilation; Webpack bundles JS (entry: `src/assets/js/main.js`). Output goes to `dist/`.

## Architecture

### Theme Info
- **Text domain:** `wp_guarapo`
- **Based on:** Underscores starter theme
- **Stack:** WordPress + Bootstrap 5.3.2 + custom SCSS + Babel-transpiled JS

### Key PHP Files
- `functions.php` — All theme setup, hooks, and utility functions in a single file (764 lines)
- `inc/template-tags.php` — `wp_guarapo_posted_on()`, `wp_guarapo_posted_by()`, `wp_guarapo_post_thumbnail()`
- `inc/class-wp-bootstrap-navwalker.php` — Bootstrap-compatible nav walker
- `inc/customizer.php` — Customizer controls for accent color, footer bg/text

### Important Utility Functions (functions.php)
- `reading_time()` — Returns estimated read time: `ceil(word_count / 200) . " min"`
- `catch_that_image()` — Returns first post image or default
- `wp_guarapo_filter_posts_by_category()` — AJAX handler for front page post filtering
- `wp_guarapo_filter_blog_posts()` — AJAX handler for blog page post filtering

### Template Flow
- **Single posts:** `single.php` → `template-parts/content-post.php` (includes share buttons, reading time, related posts)
- **Blog listing:** `home.php` → `template-parts/content-blog.php`
- **Post cards/grid:** `template-parts/content-loop.php`
- **Share buttons:** `share-buttons-template.php` (included via `get_template_part` in content-post.php)

### SCSS Structure
Source: `src/scss/` — compiled to `dist/css/bundle.css`
- `abstracts/_variables.scss` — Colors, typography, Bootstrap overrides, breakpoints
- `components/` — One file per component (e.g. `_share-buttons.scss`, `_card-loop.scss`)
- `bundle.scss` — Main import manifest

**To add a new component:** create `src/scss/components/_name.scss` and import it in `bundle.scss`.

### JavaScript
- `src/assets/js/main.js` — Webpack entry point (bundled into `dist/js/bundle.js`)
- `src/assets/js/front-page.js` — Front page AJAX filtering + lightbox (compiled as standalone)
- `src/assets/js/blog-filter.js` — Blog page AJAX category filtering (compiled as standalone)
- jQuery is external (loaded by WordPress, available as global `$`)

**To add page-specific JS:** create file in `src/assets/js/`, register and enqueue conditionally in `functions.php` using `wp_enqueue_script()`.

### PurgeCSS
Enabled in production builds. Safe-list includes: `wp-*`, Bootstrap interactive classes (`modal*`, `carousel*`, `dropdown*`, `collapse*`, `show`, `fade`), `animate*`, `entry-*`, `filter-btn`, `wpcf7*`. If new dynamic classes are added, update the safelist in `gulpfile.babel.js`.

### AJAX Category Filtering
Two independent systems — do not mix them up:
- **Front page** (`front-page.js`) → action `filter_posts`, updates `#posts-container`, excludes `strava-activities` and `run` categories
- **Blog page** (`blog-filter.js`) → action `filter_blog_posts`, updates `#blog-posts-container`

### Assets
- Fonts: Self-hosted WOFF2/WOFF (Roboto 400/500, Anton) with `font-display: swap`
- Icons: Font Awesome 6.4.2 via CDN
- Bootstrap: 5.3.2 via CDN (JS) and partially included via SCSS (CSS)

### Customizer Colors
Three options registered: `accent_color`, `footer_color`, `footer_text_color`. Inline CSS output via `theme_get_customizer_css()` hooked to `wp_head`.
