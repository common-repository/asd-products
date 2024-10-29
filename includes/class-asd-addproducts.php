<?php
/**
 * Defines the ASD_AddProducts class
 *
 * @package        WordPress
 * @subpackage     ASD_Products
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_AddProducts
 *   instantiated by an instance of the ASD_ProductsShortscode class,
 *   which also passes along the shortcode parameters.
 *  --------------------------------------------------------------------------*/
class ASD_AddProducts extends ASD_AddCustomPosts_1_201811241 {

	/** ----------------------------------------------------------------------------
	 *   contsructor
	 *   calls two functions, to set default shortcode parameters,
	 *   and another to parse parameters from the shortcode
	 *  ----------------------------------------------------------------------------
	 *
	 *   @param Array $atts - Parameters passed from the shortcode through
	 *   the ASD_ProductsShortscode instance.
	 */
	public function __construct( $atts ) {
		parent::__construct( $atts, ASD_PRODUCTS_DIR, 'products-template.php', 'asdproducts' );
	}

}

