<?php
/**
 *
 * Defines the ASD_Products class.
 *
 * @package        WordPress
 * Plugin Name:    Defines class ASD_Products
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 * description:    Defines the ASD_Products class.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

if ( ! class_exists( 'ASD_Products' ) ) {
	/** ----------------------------------------------------------------------------
	 *   Defines the class ASD_Products
	 *  --------------------------------------------------------------------------*/
	class ASD_Products extends ASD_Custom_Post_1_201811241 {

		/** ----------------------------------------------------------------------------
		 *
		 * @var $customargs holds settings for the custom post type
		 *  --------------------------------------------------------------------------*/
		private $customargs = array(
			'label'               => 'Products',
			'description'         => 'Products',
			'labels'              => array(
				'name'               => 'Products',
				'singular_name'      => 'Product',
				'menu_name'          => 'Products',
				'parent_item_colon'  => 'Parent Product:',
				'all_items'          => 'All Products',
				'view_item'          => 'View Product',
				'add_new_item'       => 'Add New Product',
				'add_new'            => 'Add New',
				'edit_item'          => 'Edit Product',
				'update_item'        => 'Update Product',
				'search_items'       => 'Search Products',
				'not_found'          => 'Product Not Found',
				'not_found_in_trash' => 'Product Not Found In Trash',
			),
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'          => array( 'productgroups', 'category' ),
			'heirarchical'        => false,
			'public'              => true,
			'has_archive'         => false,
			'rewrite'             => array( 'slug' => 'asdproducts' ),
			'capability_type'     => 'page',
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_admin_column'   => true,
			'can_export'          => true,
			'menu_position'       => 31,
		);

		/** ----------------------------------------------------------------------------
		 *
		 * @var $meta_section_def defines custom post meta fields for passing
		 * to cuztom functions.
		 *  --------------------------------------------------------------------------*/
		private $meta_section_def = array(
			'title'  => 'Product Fields',
			'fields' => array(
				array(
					'id'    => 'product_description',
					'label' => 'Description (structured data only)',
					'type'  => 'textarea',
				),
				array(
					'id'    => 'product_image',
					'label' => 'Product Image URL',
					'type'  => 'text',
				),
				array(
					'id'    => 'offer_price',
					'label' => 'Offer Price',
					'type'  => 'text',
				),
				array(
					'id'    => 'rating_value',
					'label' => 'Rating Value (1-5)',
					'type'  => 'text',
				),
				array(
					'id'    => 'review_count',
					'label' => 'Review Count (How Many)',
					'type'  => 'text',
				),
			),
		);

		/** ----------------------------------------------------------------------------
		 *   function __construct()
		 *   Constructor, calls the parent constructor, adds structured data hook
		 *   to the wp_print_footer_scripts action.
		 *  --------------------------------------------------------------------------*/
		public function __construct() {

			/* check the option, and if it's not set don't show this cpt in the dashboard main meny */
			global $asd_cpt_dashboard_display_options;
			if ( get_option( 'asd_products_display' ) === $asd_cpt_dashboard_display_options[2] ) {
				$this->customargs['show_in_menu'] = 0;
			}

			parent::__construct( 'asdproducts', $this->customargs );
			$meta_section = register_cuztom_meta_box( 'meta_section', $this->custom_type_name, $this->meta_section_def );

			add_action( 'wp_print_footer_scripts', array( &$this, 'product_json' ) );
		}

		/** ----------------------------------------------------------------------------
		 *   function product_json()
		 *   prints json-ld structured data
		 *  --------------------------------------------------------------------------*/
		public function product_json() {

			global $post;

			if ( get_post_type( $post ) === 'asdproducts' ) {
				$a_product = array();

				$a_product['@context'] = 'https://schema.org/';
				$a_product['@type']    = 'Product';
				$a_product['name']     = the_title( '', '', false );
				if ( get_post_meta( $post->ID, 'product_description', true ) ) {
					$a_product['description'] = esc_attr( get_post_meta( $post->ID, 'product_description', true ) );
				}

				if ( get_post_meta( $post->ID, 'product_image', true ) ) {
					$a_product['image'] = esc_url_raw( get_post_meta( $post->ID, 'product_image', true ) );
				}
				if ( get_post_meta( $post->ID, 'offer_price', true ) ) {
					$a_offer          = array();
					$a_offer['@type'] = 'Offer';
					$a_offer['price'] = esc_attr( get_post_meta( $post->ID, 'offer_price', true ) );
					if ( get_post_meta( $post->ID, 'currency_type', true ) ) {
						$a_offer['priceCurrency'] = esc_attr( get_post_meta( $post->ID, 'currency_type', true ) );
					} else {
						$a_offer['priceCurrency'] = 'USD';
					}

					if ( get_option( 'asd_fastbuild_org' )['text_string'] ) {
						if ( get_option( 'asd_fastbuild_org_type' )['text_string'] ) {
							$a_seller           = array();
							$a_seller ['@type'] = esc_attr( get_option( 'asd_fastbuild_org_type' )['text_string'] );
							$a_seller ['name']  = esc_attr( get_option( 'asd_fastbuild_org' )['text_string'] );
							if ( get_option( 'asd_fastbuild_org_image' )['text_string'] ) {
								$a_seller['image'] = esc_attr( get_option( 'asd_fastbuild_org_image' )['text_string'] );
							}

							$a_address         = array();
							$a_ddress['@type'] = 'PostalAddress';
							if ( get_option( 'asd_fastbuild_addr_street1' )['text_string'] ) {
								$a_address['streetAddress'] = esc_attr( get_option( 'asd_fastbuild_addr_street1' )['text_string'] );
							}
							if ( get_option( 'asd_fastbuild_addr_city' )['text_string'] ) {
								$a_address['addressLocality'] = esc_attr( get_option( 'asd_fastbuild_addr_city' )['text_string'] );
							}
							if ( get_option( 'asd_fastbuild_addr_state' )['text_string'] ) {
								$a_address['addressRegion'] = esc_attr( get_option( 'asd_fastbuild_addr_state' )['text_string'] );
							}
							if ( get_option( 'asd_fastbuild_addr_zip' )['text_string'] ) {
								$a_address['postalCode'] = esc_attr( get_option( 'asd_fastbuild_addr_zip' )['text_string'] );
							}

							if ( get_option( 'asd_fastbuild_addr_country' )['text_string'] ) {
								$a_address['addressCountry'] = esc_attr( get_option( 'asd_fastbuild_addr_country' )['text_string'] );
							}
							$a_seller['address'] = $a_address;

							if ( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] ) {
								$a_seller['priceRange'] = esc_attr( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] );
							}
							if ( get_option( 'asd_fastbuild_phone1' )['text_string'] ) {
								$a_seller['telephone'] = esc_attr( get_option( 'asd_fastbuild_phone1' )['text_string'] );
							}
							if ( get_option( 'asd_fastbuild_email_info' )['text_string'] ) {
								$a_seller['email'] = esc_attr( get_option( 'asd_fastbuild_email_info' )['text_string'] );
							}
							$a_offer ['seller'] = $a_seller;
						}
					}
					$a_product['offers'] = $a_offer;
				}

				if ( get_post_meta( $post->ID, 'rating_value', true ) ) {
					$a_ratings                = array();
					$a_ratings ['@type']      = 'aggregateRating';
					$a_ratings['ratingValue'] = esc_attr( get_post_meta( $post->ID, 'rating_value', true ) );
					if ( get_post_meta( $post->ID, 'review_count', true ) ) {
						$a_ratings['reviewCount'] = esc_attr( get_post_meta( $post->ID, 'review_count', true ) );
					}
					$a_product['aggregateRating'] = $a_ratings;
				}

				echo '<script type="application/ld+json">' . "\r\n";
				echo wp_json_encode( $a_product, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
				echo '</script>' . "\r\n";
			}

		}

	}

}


