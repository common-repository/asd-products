<?php
/**
 *
 * This is the root file of the ASD Products WordPress plugin
 *
 * @package ASD_Products
 * Plugin Name:    ASD Products
 * Plugin URI:     https://artisansitedesigns.com/products/asd-products/
 * Description:    Defines an "ASD Product" Custom Post Type in order to create Rich Content using JSON-LD Structured Data. Included are a grouping Taxonomy, and a shortcode with multiple templates.
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 * Text Domain:    asd_products
 * License:        GPL3
 * Version:        2.201901281
 *
 * ASD Products is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * ASD Products is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ASD Products. If not, see
 * https://www.gnu.org/licenses/gpl.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

if ( ! defined( 'ASD_PRODUCTS_DIR' ) ) {
	define( 'ASD_PRODUCTS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'ASD_PRODUCTS_URL' ) ) {
	define( 'ASD_PRODUCTS_URL', plugin_dir_url( __FILE__ ) );
}

require_once 'includes/asd-admin-menu/asd-admin-menu.php';
require_once 'includes/asd-function-lib/asd-function-lib.php';
require_once 'includes/class-asd-addcustomposts/class-asd-addcustomposts.php';
require_once 'includes/class-asd-custom-post/class-asd-custom-post.php';
require_once 'includes/register-site-data/register-site-data.php';
require_once 'includes/class-asd-addproducts.php';
require_once 'includes/class-asd-products.php';
require_once 'includes/class-asd-productsshortcode.php';

/* include components */
if ( ! class_exists( 'Gizburdt\Cuztom\Cuztom' ) ) {
	include 'components/cuztom/cuztom.php';
}


/** ----------------------------------------------------------------------------
 *   Function asd_products_admin_submenu()
 *   Adds two submenu pages to the admn menu with the asd_settings slug.
 *   This admin top menu is loaded in includes/asd-admin-menu.php .
 *  --------------------------------------------------------------------------*/
function asd_products_admin_submenu() {
	global $asd_cpt_dashboard_display_options;

	if ( get_option( 'asd_products_display' ) !== $asd_cpt_dashboard_display_options[1] ) {
		add_submenu_page(
			'asd_settings',
			'Products',
			'Products',
			'manage_options',
			'edit.php?post_type=asdproducts',
			''
		);
	}
	if ( 'false' !== get_option( 'asd_productgroups_display' ) ) {
		add_submenu_page(
			'asd_settings',
			'Product Groups',
			'Product Groups',
			'manage_options',
			'edit-tags.php?taxonomy=productgroups',
			''
		);
	}
}
if ( is_admin() ) {
	add_action( 'admin_menu', 'asd_products_admin_submenu', 16 );
}


/** ----------------------------------------------------------------------------
 *   function instantiate_asdproduct_class_object()
 *   create a single ASD_Pagersections instance
 *   Hooks into the init action
 *  --------------------------------------------------------------------------*/
function instantiate_asdproduct_class_object() {
	$asd_product_type = new ASD_Products();
}
add_action( 'init', 'instantiate_asdproduct_class_object' );


/** ----------------------------------------------------------------------------
 *   function instantiate_asdproduct_shortcode_object()
 *   create a single ASD_PageSectionsShortcode instance
 *   Hooks into the plugins_loaded action
 *  --------------------------------------------------------------------------*/
function instantiate_asdproduct_shortcode_object() {
	new ASD_ProductsShortcode();
}
add_action( 'plugins_loaded', 'instantiate_asdproduct_shortcode_object' );


/** ----------------------------------------------------------------------------
 *   function asdproduct_rewrite_flush()
 *   This rewrites the permalinks but ONLY when the plugin is activated
 *  --------------------------------------------------------------------------*/
function asdproduct_rewrite_flush() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'asdproduct_rewrite_flush' );


/** ----------------------------------------------------------------------------
 *   function asd_register_settings_asd_products()
 *  --------------------------------------------------------------------------*/
function asd_register_settings_asd_products() {
	register_setting( 'asd_dashboard_option_group', 'asd_products_display' );
	register_setting( 'asd_dashboard_option_group2', 'asd_productgroups_display' );
	/** ----------------------------------------------------------------------------
	 *   add the names of the post types and taxonomies being added
	 *  --------------------------------------------------------------------------*/
	global $asd_cpt_list;
	global $asd_tax_list;
	array_push(
		$asd_cpt_list,
		array(
			'name' => 'Products',
			'slug' => 'asdproducts',
			'desc' => 'Facilitate setting up JSON-LD Structured Data for products. Do not confuse with Woo Commerce products.',
			'link' => 'https://wordpress.org/plugins/asd-products',
		)
	);
	array_push( $asd_tax_list, 'asdproductgroups' );
}
if ( is_admin() ) {
	add_action( 'admin_init', 'asd_register_settings_asd_products' );
}


/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_products()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_products() {
	global $asd_cpt_dashboard_display_options;

	add_settings_field(
		'asd_products_display_fld',
		'show Products in:',
		'asd_select_option_insert',
		'asd_dashboard_option_group',
		'asd_dashboard_option_section_id',
		array(
			'settingname'   => 'asd_products_display',
			'selectoptions' => $asd_cpt_dashboard_display_options,
		)
	);

}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section', 'asd_add_settings_asd_products' );
}

/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_productgroups()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_productgroups() {
	add_settings_field(
		'asd_productgroups_display_fld',
		'show Productgroups in submenu:',
		'asd_truefalse_select_insert',
		'asd_dashboard_option_group2',
		'asd_dashboard_option_section2_id',
		'asd_productgroups_display'
	);
}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section2', 'asd_add_settings_asd_productgroups' );
}




/** ----------------------------------------------------------------------------
 *   Function asd_products_plugin_action_links()
 *   Adds links to the Dashboard Plugin page for this plugin.
 *  ----------------------------------------------------------------------------
 *
 *   @param Array $actions -  Returned as an array of html links.
 */
function asd_products_plugin_action_links( $actions ) {
	if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
		$actions[0] = '<a target="_blank" href="https://artisansitedesigns.com/asdproducts/asd-products/">Help</a>';
		/* $actions[1] = '<a href="' . admin_url() . '">' .  'Settings'  . '</a>';  */
	}
	return apply_filters( 'asdproducts_actions', $actions );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'asd_products_plugin_action_links' );

