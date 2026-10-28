<?php
/**
 * Title: Before / after slider
 * Slug: elite-carpentry/before-after
 * Categories: elite-carpentry, gallery
 * Keywords: before, after, compare, slider, transformation
 * Viewport Width: 1440
 *
 * Replace the two images with a real "before" (first) and "after" (second)
 * photo of the same room, taken from the same spot. The theme script turns
 * any Group with the class "ec-before-after" into a drag-to-compare slider.
 *
 * @package Elite_Carpentry
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base-2","layout":{"type":"constrained","contentSize":"1040px"}} -->
<div class="wp-block-group alignfull has-base-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:paragraph {"align":"center","className":"is-style-eyebrow"} -->
<p class="has-text-align-center is-style-eyebrow">Transformation</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Drag to see the difference</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"ec-before-after","style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group ec-before-after" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo elite_carpentry_img( 'plans', 1600 ); ?>" alt="Before: the original room"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo elite_carpentry_img( 'kitchen-island', 1600 ); ?>" alt="After: the finished renovation"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","textColor":"contrast-2","fontSize":"small"} -->
<p class="has-text-align-center has-contrast-2-color has-text-color has-small-font-size">Swap in your own before and after photos — first image is “before”, second is “after”.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
