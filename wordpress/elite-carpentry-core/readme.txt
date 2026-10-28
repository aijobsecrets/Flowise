=== Elite Carpentry Core ===
Requires at least: 6.6
Tested up to: 6.6
Requires PHP: 7.4
License: GPLv2 or later

Companion plugin for the Elite Carpentry theme.

== Features ==

* Projects post type (/projects/) with Project Types (Kitchen, Bathroom, Basement…) and Location / Timeline / Scope fields.
* "Quote Request Form" block and [elite_quote_form] shortcode. Leads are saved under Quote Requests and emailed to you. Spam protection: honeypot, signed timestamp, 5-per-hour rate limit. Hook `elite_carpentry_quote_received` to send leads to a CRM.
* Settings → Business Details: phone, email, address, hours, service area. Shown in the header, footer, contact page and CTAs via the Block Bindings API; [elite_info key="phone_link"] shortcode for anywhere else.
* LocalBusiness structured data on the homepage.
* Appearance → Elite Carpentry Setup: creates the pages, sample projects and imports demo photos in one click.
