<?php
/**
 * Plugin Name:       Custom Blocks
 * Description:       Enable custom blocks in Gutenberg editor
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_custom_block_init() {
	$blocks_path = [
		__DIR__ . '/build/nutritional-values-block',
		__DIR__ . '/build/test-block',
	];

	foreach ( $blocks_path as $block_path ) {
		register_block_type($block_path);
	}
	
}
add_action('init', 'create_custom_block_init');
