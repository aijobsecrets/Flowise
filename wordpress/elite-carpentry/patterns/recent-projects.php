<?php
/**
 * Title: Recent projects (query loop)
 * Slug: elite-carpentry/recent-projects
 * Categories: elite-carpentry, query
 * Keywords: projects, portfolio, query, latest
 * Viewport Width: 1440
 *
 * Pulls the latest entries from the Projects post type (Elite Carpentry Core plugin).
 *
 * @package Elite_Carpentry
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:heading -->
<h2 class="wp-block-heading">Recent projects</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="/projects/">See the full portfolio →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":3,"query":{"perPage":3,"pages":0,"offset":0,"postType":"ec_project","order":"desc","orderBy":"date","inherit":false},"align":"wide","className":"ec-project-grid"} -->
<div class="wp-block-query alignwide ec-project-grid"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"is-style-card-hover","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card-hover"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:post-terms {"term":"ec_project_type","className":"is-style-eyebrow"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Projects you publish under <strong>Projects → Add New</strong> will appear here.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
