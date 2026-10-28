<?php
/**
 * Title: Testimonials (3 cards)
 * Slug: elite-carpentry/testimonials
 * Categories: elite-carpentry, testimonials
 * Keywords: reviews, testimonials, quotes, homestars, google
 * Viewport Width: 1440
 *
 * Placeholder copy on purpose: paste real reviews (with the client's
 * permission) from HomeStars or Google. Never publish invented reviews.
 *
 * @package Elite_Carpentry
 */

$elite_reviews = array(
	array( 'Paste a real client review here — ideally one that mentions the kitchen, the crew and how clean they kept the house.', 'Client name', 'Kitchen renovation · Kitchener' ),
	array( 'Paste a real client review here — bathroom clients often talk about the tile work, the timeline and the communication.', 'Client name', 'Bathroom renovation · Waterloo' ),
	array( 'Paste a real client review here — a basement, deck or custom carpentry job rounds out the set nicely.', 'Client name', 'Basement finishing · Cambridge' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base-2","layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull has-base-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","className":"is-style-eyebrow"} -->
<p class="has-text-align-center is-style-eyebrow">Client stories</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Homeowners who'd hire us again</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} -->
<div class="wp-block-group alignwide"><?php foreach ( $elite_reviews as $elite_review ) : ?><!-- wp:group {"className":"is-style-card ec-testimonial ec-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card ec-testimonial ec-reveal" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"className":"ec-stars","fontSize":"large"} -->
<p class="ec-stars has-large-font-size">★★★★★</p>
<!-- /wp:paragraph -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p><?php echo esc_html( $elite_review[0] ); ?></p>
<!-- /wp:paragraph --><cite><strong><?php echo esc_html( $elite_review[1] ); ?></strong><br><?php echo esc_html( $elite_review[2] ); ?></cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="margin-top:var(--wp--preset--spacing--40)">Read more reviews on <a href="https://homestars.com/companies/2787948-elite-carpentry-plus">HomeStars</a> and Google.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
