=== ASD Products ===
Contributors: michaelfahey
Tags: structured data, schema.org, json-ld, rich content, seo
Requires PHP: 5.6
Requires at least: 3.6
Tested up to: 5.0.3
Stable tag: 2.201901281
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Plugin URI:  https://artisansitedesigns.com/plugins/asd-products/
Author URI:  https://artisansitedesigns.com/staff/michael-h-fahey/

Creates an "ASD Product" Custom Post Type in order to create schema.org "Product" type Rich Content using JSON-LD Structured Data. Included are a grouping Taxonomy, and a shortcode with multiple templates.

=== Description ===
The ASD Products plugin is useful for those who wish to define and populate the search engines with well-formed Product type Structured Data, without setting up a full e-commerce solution.

= Rich Content =
The primary function of the ASD Product Type is to generate Rich Content through the insertion of JSON-LD Structured Data into the HTML Footer for the Schema.org "Product" definition.  Each ASD Product contains additional defined metadata such as Product Description, Rating, Image, etc. 
[Schema.org Product definition](http://schema.org/Product)
[Google's Into to Structured Data](https://developers.google.com/search/docs/guides/intro-structured-data/)
[JSON-LD stands for 'JSON for Linking data'](https://json-ld.org/)

= Shortcode =
Included is a shortcode that allows Products to be inserted directly into other pages, using several provided templates, or a custom template that you define.

= Featured Images =
The ASD Product post type and shortcode templates support Featured Images.

= Taxonomy =
The "ASD Product Groups" taxonomy is included for grouping and managing ASD Products. The Taxonomy is visible in the ASD PRoduct list and can use used for filtering.

= Additional Strutured Data =
If the ASD FastBuild Widgets are also installed, additional JSON-LD fields will be included with the ASD Product, including the Seller properties, and its included properties.
[ASD FastBuild Widgets](https://artisansitedesigns.com/products/asd-fastbuild-widgets/)

== Installation ==

= Manual installation =
At a command prompt or using a file manager, unzip the .ZIP file in the WordPress plugins directory, usually ~/public_html/wp-content/plugins . In the In the WordPress admin Dashboard (usually http://yoursite.foo/wp-a    dmin ) click Plugins, scroll to ASD Products, and click "activate".

= Upload in Dashboard =
Download the ZIP file to your workstation.  In the WordPress admin Dashboard (usually http://yoursite.foo/wp-admin ) Select Plugins, Add New, click Upload Plugin, Choose File and navigate to the downloaded ZIP file. After that, click Install Now, and when the installer finishes, click Activate Plugin.

== Frequently Asked Questions ==
This Product Type does not include e-commerce Shopping Cart or Checkout functionality.

= Creating A New ASD Product =
In the WordPress Admin Dashboard, look for the Artisan Site Designs Menu, and select Products. Click Add New, and populate the various fields. 
**These fields are for JSON-LD Structured Data only and are not displayed in content.**
* Product Description 
* Product Image: *an URL to an image*
* Offer/Price: *numeric value, ex: 100.00*
* Currency: *example USD = US dollar*
* Aggregate Review
* Review Count

Use Google's Structured Data Testing Tool to see how the search engine
sees your structured data.
[Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/)

The fields Leading HTML and Trailing HTML are used to wrap the product in addional CSS classes. Only div elements and class attributes are allowed.

= Shortcode Syntax =
[asd_insert_products ids='123']
*Inserts ASD Product with ID = 123*

[asd_insert_products ids='123,234']
*Inserts ASD Products with IDs = 123 and 234*

[asd_insert_products name='my-product-slug']
*Inserts ASD Products with Slug (Name) my-product-slug*

[asd_insert_products name='my-product-slug' template='my-product-template.php']
*Inserts ASD Products with Slug (Name) my-product-slug and use a template named my-product-template.php*

= Shortcode Templates =
Three shortcode templates are included with the plugin
* products-banner-template.php
* products-short-template.php
* products-template.php

Copy any of these templates to your theme location so they can be customized. The theme directory is checked first, then the plugin directory. If no matching template file is found, the default template (products-template.php) is used.

= Taxonomy =
A new Taxonomy "ASD Product Groups" (slug: "asdproductgroups") is included for grouping and organizing ASD Products.

== Screenshots ==
1. ASD Products Type in Dashboard
2. Edit ASD Product
3. Results in the Structured Data Testing Tool

== Changelog ==
= 2.201901281 2019-01-28 =
*Tweak	Submodule Updates
*Tweak	Updated codesniffer audit

= 2.201812101 2018-12-10 =
*Tweak	Submodule Updates
*Fix		class-asd-addcustomposts no longer uses posts_per_page=-1

= 2.201808181 2018-08-20 =
*Tweak	The asd-admin-menu and register-site-data function libraries now are version sensitive, so that the lastest version will always be loaded, even when mixed versions are present. This allows mixed versions of plugins which use these libraries to peacefully coexist.

= 2.201808065 2018-08-06 =
*Tweak   plugin now set up to use cuztom library, class and parent classes based definitions for defining and adding custom "product" post types. This chenge is entirely internal, class is the same in Dashboard and front end.
*Tweak   using shared asd-admin-menu.php
*Tweak   using shared register-site-data.php
*Tweak   taxonomy-filters are rolled into custom post parent class and are no longer loaded as standalone functions.
*Fix     wrapperclasses closing div comments were incorrect

= 1.201804101 2018-04-10 =
* Tweak  changed taxonomy-filters.php for use in all other plugins

= 1.201804021 2018-04-02 =
* Fix    fixes applied that were found while working up asd_pagesections
* Fix    found and fixed potential bug in wrapperclasses

= 1.20180321 2018-03-22 =
* Tweak  added short_content() to get a specific excerpt, with balanced tags
* Tweak  also added fourth built-in shortcode template to handle it

= 1.201803171 2018-03-17 =
* Fix    change sanitize_text_field to sanitize_textarea_field, so that hard returns are preserved.

= 1.201803152 2018-03-15 =
* Tweak  applied codesniffer phpcs with WordPress ruleset standard, zero errors, zero warnings remain

= 1.201803131 (Second RC) 2018-03-13 =
* Tweak	Replaced clumsy and error-prone leading/trailing HTML class fields with single wrapper classes field, added code to sanitize and embed these classes into leading and trailing <div> tags

= 1.201803113 2018-03-11 =
* Tweak	Elimination of all use of strcmp().
* Tweak	Improvement in shortcode template heirarchy.
* Fix		Removal of calls to load external HTML.
* Fix		Improvements to readme.txt.
* Fix		Elimination of double-quotes where possible.
* Tweak	Added <a> tags around the_post_thumbnail in shortcode banner template, aimed at get_the_permalink()

== Upgrade Notice ==
= 2.201901281 2019-01-28 =

= 2.201808201 2018-08-20 =

= 2.201808065 2018-08-06 =
No fallout anticipated from this upgrade.

= 1.201803131 2018-03-13 =
DOM classes must be copied from "leading_html" post meta field, and moved to "wrapperclasses" post meta field. I personally performed this task for the handful of sites which are currently running this plugin.
