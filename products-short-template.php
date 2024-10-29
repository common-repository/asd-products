<?php
/**
 * A template for inserting asdproduct post types with the shorcode.
 *
 * @package        WordPress
 * @subpackage     ASD_Products
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

global $post;
echo '<div id="' . esc_attr( $post->post_name ) . '"></div>';
	echo '<div class="asd-template-excerpt asd-products-short-template">';

if ( has_post_thumbnail() ) {
	echo '<div style="margin-right:15px;float:left;">';
		the_post_thumbnail();
	echo '</div>';
}

	echo '<h2>' . esc_attr( get_the_title() ) . '</h2>';
	the_excerpt();

	echo '<a href="' . esc_url( get_permalink() ) . '">';
		echo 'Read More';
	echo '</a>';
echo '</div>';
