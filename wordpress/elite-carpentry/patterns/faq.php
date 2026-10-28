<?php
/**
 * Title: FAQ (accordion)
 * Slug: elite-carpentry/faq
 * Categories: elite-carpentry, text
 * Keywords: faq, questions, accordion, details
 * Viewport Width: 1440
 *
 * @package Elite_Carpentry
 */

$elite_faqs = array(
	array( 'How much does a kitchen or bathroom renovation cost?', 'It depends on size, layout changes and finishes, so we don\'t quote from a phone call. After a free in-home visit you get a detailed, written, fixed-scope quote — no vague allowances and no surprise invoices at the end.' ),
	array( 'How long will my renovation take?', 'A typical bathroom takes a few weeks once materials are on site; kitchens usually take longer because of cabinetry and counters. You get a written schedule before we start, and one point of contact who keeps you updated as we go.' ),
	array( 'Do you handle permits and trades?', 'Yes. Where a permit is needed we handle the drawings and the application, and we coordinate licensed plumbers and electricians so you are not managing a list of trades yourself.' ),
	array( 'Can we live at home during the work?', 'Almost always. We seal off the work area with dust barriers, protect floors, and clean up at the end of every day. For kitchens we can help you set up a temporary kitchen elsewhere in the house.' ),
	array( 'Do you guarantee your work?', 'We stand behind our workmanship in writing, and manufacturer warranties on cabinets, fixtures and materials are passed on to you. Ask us for the details during your consultation.' ),
);
?>
<!-- wp:group {"align":"full","className":"ec-faq","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull ec-faq has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60","top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"36%"} -->
<div class="wp-block-column" style="flex-basis:36%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Good questions</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Before you renovate</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"contrast-2"} -->
<p class="has-contrast-2-color has-text-color">Straight answers to what homeowners ask us most. Something else on your mind? Just call — you will talk to a carpenter, not a call centre.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"64%"} -->
<div class="wp-block-column" style="flex-basis:64%"><?php foreach ( $elite_faqs as $elite_faq ) : ?><!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html( $elite_faq[0] ); ?></summary><!-- wp:paragraph {"textColor":"contrast-2"} -->
<p class="has-contrast-2-color has-text-color"><?php echo esc_html( $elite_faq[1] ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<?php endforeach; ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
