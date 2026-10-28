<?php
/**
 * Title: Project gallery (lightbox)
 * Slug: elite-carpentry/gallery
 * Categories: elite-carpentry, gallery
 * Keywords: gallery, portfolio, photos, work
 * Viewport Width: 1440
 *
 * @package Elite_Carpentry
 */

$elite_gallery = array( 'kitchen-modern', 'bath-ensuite', 'kitchen-detail', 'bath-vanity', 'kitchen-open', 'living-2' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Recent work</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Crafted in Waterloo Region</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/projects/">View all projects</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:gallery {"columns":3,"linkTo":"none","sizeSlug":"large","align":"wide","className":"ec-gallery ec-reveal","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|20","left":"var:preset|spacing|20"}}}} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-3 is-cropped ec-gallery ec-reveal"><?php foreach ( $elite_gallery as $elite_key ) : ?><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo elite_carpentry_img( $elite_key, 1200 ); ?>" alt="<?php echo elite_carpentry_alt( $elite_key ); ?>"/></figure>
<!-- /wp:image -->

<?php endforeach; ?></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->
