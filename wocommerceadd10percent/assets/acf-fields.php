<?php
/**
 * @package PDS - Add 10% to Woocommerce orders with specific items
 * Text Domain: pds-wc-add-ten
 */

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5ec5e12e96145',
	'title' => '10% Cart Inflation',
	'fields' => array(
		array(
			'key' => 'field_5ec5e145bdc41',
			'label' => 'Trigger 10% Cart Total Inflation if product in cart?',
			'name' => 'trigger_10%_cart_total_inflation_if_product_in_cart',
			'type' => 'true_false',
			'instructions' => 'Check this if you want the cart total to increase by 10% if this item is in the cart.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => 'Yes',
			'ui_off_text' => 'No',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
