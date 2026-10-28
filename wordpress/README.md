# Elite Carpentry – WordPress site

A WordPress **block theme** plus a small **companion plugin** for a kitchen, bathroom and custom-carpentry renovation company (modelled on Elite Carpentry Plus, Kitchener-Waterloo). Every section is a native block pattern, so the whole site can be edited in **Appearance → Editor**. No page builder, and no build step.

```
wordpress/
├── elite-carpentry/          ← theme (upload as a zip under Appearance → Themes)
│   ├── theme.json            colours, fonts, spacing, shadows, block styles
│   ├── templates/            front page, pages, blog, projects, 404 …
│   ├── parts/                header, footer, quote CTA
│   ├── patterns/             13 sections + 5 full-page starters
│   ├── styles/coastal.json   alternate style variation
│   ├── inc/images.php        every demo photo URL in one place
│   └── assets/               small CSS/JS extras (sticky header, reveal, before/after slider)
├── elite-carpentry-core/     ← plugin (upload under Plugins → Add New → Upload)
│   ├── includes/post-types.php    Projects + Project Types + Quote Requests
│   ├── includes/quote-form.php    form handler, spam protection, email + admin list
│   ├── includes/business-info.php Settings → Business Details, block bindings, schema.org
│   ├── includes/setup.php         Appearance → Elite Carpentry Setup (one-click demo)
│   └── blocks/quote-form/         "Quote Request Form" block
├── release/                     ready-to-upload zips
└── build.sh                  rebuilds the zips
```

## Preview it without installing anything

- **Live WordPress in your browser:** [open in WordPress Playground](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/aijobsecrets/Flowise/claude/elite-carpentry-wordpress-t951k0/wordpress/blueprint.json). It runs `blueprint.json`, which installs the theme and plugin and builds the demo content. You're logged in as `admin` / `password`, so you can also try the editor. It's temporary and only exists in your browser tab.
- **Offline click-through:** open `preview/index.html` in a browser. It's a static snapshot of every page with desktop and phone views. The photos and fonts load from the internet. The quote form only shows a message, and the gallery lightbox is disabled.

## Install (about 5 minutes)

1. **Requirements:** WordPress 6.6 or newer, PHP 7.4 or newer.
2. Upload `release/elite-carpentry.zip` under **Appearance → Themes → Add New → Upload Theme**, then activate it.
3. Upload `release/elite-carpentry-core.zip` under **Plugins → Add New → Upload Plugin**, then activate it.
4. Go to **Appearance → Elite Carpentry Setup** and click **Build my site**. This:
   - creates the Kitchens, Bathrooms, Services, About and Contact pages from the theme's patterns,
   - adds 6 sample Projects (clearly labelled as samples) and copies their photos into the Media Library,
   - switches permalinks to "Post name" (the menu links such as `/kitchens/` depend on this),
   - sets the site title and tagline if they are still the WordPress defaults.
5. Enter the real phone, email, address and hours under **Settings → Business Details**. They update the header, footer, contact page and every call-to-action at once.
6. In **Appearance → Editor**, upload the logo (Header → Site Logo block) and adjust colours and fonts under **Styles**.

## WordPress features it uses

| Feature | Where |
|---|---|
| Full Site Editing (templates and template parts) | Header, footer and every template can be edited visually |
| Block patterns | Insert any section from the **Elite Carpentry** pattern category. New pages offer the full-page starters. |
| Global Styles / `theme.json` | Palette, fluid typography, spacing and shadows. Change them once and the whole site follows. |
| Style variations | "Coastal White" under Styles → Browse styles |
| Block style variations | Card, Checklist, Offset frame, Eyebrow, Outline-on-dark button |
| Block Bindings API | Phone, email, hours and copyright pulled from Settings → Business Details. Project details are pulled from post meta. |
| Custom post types and taxonomies | Projects (`/projects/`) filterable by Project Type; Quote Requests (private) |
| Query Loop | Projects archive, recent projects and blog |
| Image lightbox | Gallery images open full-screen |
| Details block | FAQ accordion with no JavaScript |
| Custom templates | "Landing page (no title, full width)" and "Page with quote sidebar" |
| Server-rendered block | Quote Request Form (works behind page caches, with no nonce expiry) |
| Structured data | `HomeAndConstructionBusiness` JSON-LD on the homepage |

Everything else WordPress offers works as normal: SEO plugins (Yoast/Rank Math), caching, the Font Library (to self-host the fonts), SMTP plugins for reliable email, and translation (all strings use text domains).

## Things you must change before going live

These are placeholders on purpose, and some of them are claims I could not verify:

- **Phone/email/address/hours.** The fallback text is `(519) 555-0100` and `info@yourdomain.ca`. Set the real values in Settings → Business Details.
- **Testimonials.** The cards say "Paste a real client review here". Use real reviews only, with the client's permission. The "Read more reviews" link points to the company's HomeStars profile.
- **Marketing claims.** "Since 1989", "Fully insured", "Licensed & insured · WSIB covered · Written workmanship warranty" (footer), "within one business day" and "built in our shop" are written as plausible copy. Delete anything that isn't true.
- **About page story.** It contains instructions for writing your own story, not a real history.
- **Photos.** These are Unsplash stock photos. Replace them with your own project photos as soon as you can, because real work sells renovations. To re-skin every pattern at once, edit `inc/images.php` or use the `elite_carpentry_images` filter.

## Rebuilding the zips

```bash
cd wordpress && ./build.sh
```
