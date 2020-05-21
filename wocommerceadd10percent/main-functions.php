<?php
/**
 * PDS - Add 10% to Woocommerce orders with specific items
 *
 * Plugin Name: PDS - Add 10% to Woocommerce orders with specific items
 * Plugin URI:  progressiodev.com
 * Description: Codeable challenge, add 10% to the order if specific items are in the cart.
 * Version:     1.0
 * Author:      Progressio Development
 * Author URI:  https://progressiodev.com
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: pds-wc-add-ten
 */


if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

//Set up and include ACF for our field functionality
	// Define path and URL to the ACF plugin.
	define( 'MY_ACF_PATH', __DIR__ . '/includes/acf/' );
	define( 'MY_ACF_URL',  __DIR__ . '/includes/acf/' );

	// Include the ACF plugin.
	include_once( MY_ACF_PATH . 'acf.php' );

	// Customize the url setting to fix incorrect asset URLs.
	add_filter('acf/settings/url', 'my_acf_settings_url');
	function my_acf_settings_url( $url ) {
	    return MY_ACF_URL;
	}

	// (Optional) Hide the ACF admin menu item.
	add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
	function my_acf_settings_show_admin( $show_admin ) {
	    return false;
	}

	//Include our custom ACF Field Group to add the "trigger 10% inflation" choice on the individual product screen.
	include __DIR__ . '/assets/acf-fields.php';


// On the cart page, hook in and grab the cart object, check to see if there are any products inside
// If there are products, loop through them and check a specific user set field of whether or not to apply a 10% increase to the final cart total.
// If there is at least 1 item that should trigger the total hike, add 10% to the cart total

add_action('woocommerce_after_calculate_totals', 'pds_apply_the_ten');
function pds_apply_the_ten( $cart_object ){

	//set a quick boolean to help us confirm there's a specific item in the cart.
	$apply_price_hike = false;

	if( ! WC()->cart->is_empty() ):

				global $woocommerce;
				$items = $woocommerce->cart->get_cart();

				    foreach($items as $item => $values) {

								$_product =  wc_get_product( $values['data']->get_id());
								$product_id = $_product->get_ID();
				        $price = get_post_meta($values['product_id'] , '_price', true);
								$product_meta = get_post_meta($values['product_id']);
								//Check the specific meta value from our ACF field which the user can set if the item should trigger the total hike or not.
								if( $product_meta['trigger_10%_cart_total_inflation_if_product_in_cart'][0] == 1){
									$trigger_price_hike = true;
								} else {
									$trigger_price_hike = false;
								}

								// If the above field value was set to true, set our final test variable to true.
								// This way we can avoid applying the discount multiple times if 2 or more products in the cart have the total hike marked as true.
								if( $trigger_price_hike === true ) {

									$apply_price_hike = true;

								} else {
									// Do nothing if it's not set to true.
								}

						} // end foreach


	endif;


	//To Apply or Not to Apply? - Here we'll add the 10% increase if needed
	if( $apply_price_hike === true ){
		$new_total =  $cart_object->cart_contents_total * 1.1;
		$cart_object->total = $new_total;
	}


}
