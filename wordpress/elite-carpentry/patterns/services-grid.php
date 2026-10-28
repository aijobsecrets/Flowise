<?php
/**
 * Title: Services grid (6 cards)
 * Slug: elite-carpentry/services-grid
 * Categories: elite-carpentry, services
 * Keywords: services, cards, grid, kitchen, bathroom, basement
 * Viewport Width: 1440
 *
 * @package Elite_Carpentry
 */

$elite_services = array(
	array( 'kitchen-island', 'Kitchen Renovations', 'Layouts that actually work, custom cabinetry, islands, quartz and tile — built and installed by our own carpenters.', '/kitchens/' ),
	array( 'bath-modern', 'Bathroom Renovations', 'Walk-in showers, heated floors, custom vanities and spa-style ensuites with waterproofing done right.', '/bathrooms/' ),
	array( 'basement', 'Basement Finishing', 'Turn bare concrete into a family room, guest suite or home office — framed, insulated and finished to code.', '/services/#basements' ),
	array( 'exterior', 'Additions &amp; Decks', 'Sunrooms, mudrooms, and decks built to last Ontario winters, from permit drawings to final stain.', '/services/#additions' ),
	array( 'living', 'Custom Carpentry &amp; Trim', 'Built-ins, wainscoting, coffered ceilings, stair rails and finish carpentry that make a house feel custom.', '/services/#carpentry' ),
	array( 'plans', 'Design &amp; Planning', 'Measured drawings, 3D layouts and a clear fixed-scope quote before a single wall comes down.', '/contact/#quote' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"className":"ec-reveal","style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group ec-reveal" style="margin-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","className":"is-style-eyebrow"} -->
<p class="has-text-align-center is-style-eyebrow">What we build</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Every room, one trusted crew</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"contrast-2","fontSize":"large"} -->
<p class="has-text-align-center has-contrast-2-color has-text-color has-large-font-size">Kitchens and bathrooms are our specialty, but our carpenters handle the whole house.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"20rem"}} -->
<div class="wp-block-group alignwide"><?php foreach ( $elite_services as $elite_service ) : ?><!-- wp:group {"className":"is-style-card-hover ec-service-card ec-reveal","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card-hover ec-service-card ec-reveal"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"large","linkDestination":"custom"} -->
<figure class="wp-block-image size-large"><a href="<?php echo esc_url( $elite_service[3] ); ?>"><img src="<?php echo elite_carpentry_img( $elite_service[0], 900 ); ?>" alt="<?php echo elite_carpentry_alt( $elite_service[0] ); ?>" style="aspect-ratio:4/3;object-fit:cover"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><a href="<?php echo esc_url( $elite_service[3] ); ?>"><?php echo $elite_service[1]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static string. ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"contrast-2","fontSize":"small"} -->
<p class="has-contrast-2-color has-text-color has-small-font-size"><?php echo $elite_service[2]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static string. ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><strong><a href="<?php echo esc_url( $elite_service[3] ); ?>">Learn more →</a></strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
