<?php
/**
 * Quote Request Form – front-end markup.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner content (unused).
 * @var WP_Block $block      Block instance.
 *
 * @package Elite_Carpentry_Core
 */

defined( 'ABSPATH' ) || exit;

echo elite_carpentry_quote_form_html( $attributes, get_block_wrapper_attributes( array( 'class' => 'ec-quote-form' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the function.
