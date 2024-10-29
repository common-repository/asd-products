<?php
/**
 * A template for inserting asdproduct post types with the shorcode
 *
 * @package        WordPress
 * @subpackage     ASD_Products
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

require_once 'includes/asd-function-lib/asd-function-lib.php';

global $post;
echo '<div id="' . esc_attr( $post->post_name ) . '"></div>';
echo '<div class="asd-template-detail asd-products-banner-template">';
	echo '<div class="col-xs-6 col-sm-12 leftfloat clearfix">';
		echo '<a href="' . esc_url( get_the_permalink() ) . '">';
			the_post_thumbnail( 'full' );
		echo '</a>';
	echo '</div>';
	echo wp_kses_post( apply_filters( 'the_content', short_content( get_the_content() ) ) );
echo '</div>';


