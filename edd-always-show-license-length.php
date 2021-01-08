<?php
defined( 'ABSPATH' ) or exit;
/**
 * Plugin Name: Easy Digital Downloads - Always Show License Length
 * Plugin URI: https://github.com/csalzano/edd-always-show-license-length
 * Description: Adds a note like "per year" near pricing options in the purchase button or [purchase_link] shortcode.
 * Version: 1.0.0
 * Author: Corey Salzano
 * Author URI: https://breakfastco.xyz
 * Text Domain: edd-license-length
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

function edd_always_show_license_length( $price_output, $download_id, $key, $price, $form_id, $item_prop )
{
	$pattern = '<span class="edd_price_option_license_length">%s</span>';
	$note = '';

	//Is the license lifetime?
	if( '1' == get_post_meta( $download_id, 'edd_sl_download_lifetime', true ) )
	{
		$note = sprintf( $pattern, esc_html__( ' one time', 'edd-license-length' ) );
	}

	//No, it's limited. Is it per year?
	else if( '1' == get_post_meta( $download_id, '_edd_sl_exp_length', true ) 
		&& 'years' == get_post_meta( $download_id, '_edd_sl_exp_unit', true ) )
	{
		$note = sprintf( $pattern, esc_html__( ' per year', 'edd-license-length' ) );
	}

	return $price_output . apply_filters( 'edd_price_option_license_length', $note, $download_id );
}
add_filter( 'edd_price_option_output', 'edd_always_show_license_length', 10, 6 );
