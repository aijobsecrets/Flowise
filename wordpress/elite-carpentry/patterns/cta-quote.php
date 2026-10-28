<?php
/**
 * Title: Call to action – quote request form
 * Slug: elite-carpentry/cta-quote
 * Categories: elite-carpentry, call-to-action
 * Keywords: cta, quote, estimate, contact, form
 * Viewport Width: 1440
 *
 * The form is the "Quote Request Form" block from the Elite Carpentry Core plugin.
 *
 * @package Elite_Carpentry
 */
?>
<!-- wp:cover {"url":"<?php echo elite_carpentry_img( 'bath-hero', 2000 ); ?>","alt":"","dimRatio":85,"overlayColor":"primary-dark","isUserOverlayColor":true,"align":"full","anchor":"quote","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div id="quote" class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><span aria-hidden="true" class="wp-block-cover__background has-primary-dark-background-color has-background-dim-90 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo elite_carpentry_img( 'bath-hero', 2000 ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60","top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Free estimate</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"white"} -->
<h2 class="wp-block-heading has-white-color has-text-color">Let's talk about your kitchen or bathroom</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#eadfce"}},"fontSize":"large"} -->
<p class="has-text-color has-large-font-size" style="color:#eadfce">Tell us a little about the project and we will get back to you within one business day to book a free, no-obligation visit.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-checklist","style":{"color":{"text":"#eadfce"}}} -->
<ul style="color:#eadfce" class="wp-block-list is-style-checklist has-text-color"><!-- wp:list-item -->
<li>Written, fixed-scope quotes</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>One project lead from start to finish</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Daily clean-up and dust protection</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"elite-carpentry/business","args":{"key":"phone_cta"}}}},"textColor":"white","fontSize":"large"} -->
<p class="has-white-color has-text-color has-large-font-size">Prefer to talk? Call <a href="tel:+15195550100">(519) 555-0100</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:group {"className":"is-style-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"textColor":"contrast","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card has-contrast-color has-text-color" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Request your free estimate</h3>
<!-- /wp:heading -->

<!-- wp:elite-carpentry/quote-form /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->
