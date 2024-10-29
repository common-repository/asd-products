<?php
/**
 *  Defines the ASD_ProductsShortcode class.
 *
 *  @package         WordPress
 *  @subpackage      ASD_Products
 *  Author:          Michael H Fahey
 *  Author URI:      https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_ProductsShortcode
 *   used to create a shortcode for asdproduct post types and instantiate the
 *   ASD_AddProducts class to return template-formatted post data.
 *  --------------------------------------------------------------------------*/
class ASD_ProductsShortcode {

		/** ----------------------------------------------------------------------------
		 *   constructor
		 *   Defines a new shortcode for inserting asdproduct custom post types.
		 *   Shortcode is [asd_insert_products]
		 *  --------------------------------------------------------------------------*/
	public function __construct() {
		add_shortcode( 'asd_insert_products', array( &$this, 'asd_insert_products' ) );
	}

		/** ----------------------------------------------------------------------------
		 *   function asd_insert_products( $shortcode_params )
		 *   This function is a callback set in add_shortcode in the class constructor.
		 *   This function instantiates a new ASD_AddProducts class object and
		 *   passes parameter data from the shortcode to the new object.
		 *  ----------------------------------------------------------------------------
		 *
		 *   @param Array $shortcode_params - data from the shortcode.
		 */
	public function asd_insert_products( $shortcode_params ) {
		$shortcode_posts = new ASD_AddProducts( $shortcode_params );

		ob_start();
		echo wp_kses_post( $shortcode_posts->output_customposts() );
		return ob_get_clean();
	}
}

