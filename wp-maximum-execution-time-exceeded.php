<?php

/**

 * Plugin Name: WP Maximum Execution Time Exceeded — Afterware

 * Plugin URI: http://johnniejodelljr.com/wp-aximum-execution-time-exceeded/

 * Update URI: https://updates.afterware.io/wp-maximum-execution-time-exceeded

 * Description: Increase the maximum execution time to 5 minutes. 

 * Version: 1.0.3.1
 * Requires PHP: 8.3.28
 * Requires at least: 6.8.3

 * Author: Johnnie J. O'Dell Jr.

 * Author URI: http://johnniejodelljr.com/

 * License: GPL2

 */

 /*  Copyright 2014  Johnnie J. O'Dell Jr.  (email : johnnie@johnniejodelljr.com)



    This program is free software; you can redistribute it and/or modify

    it under the terms of the GNU General Public License, version 2, as 

    published by the Free Software Foundation.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License

    along with this program; if not, write to the Free Software

    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
function wpmete_on_activation_wc(){

	$wpmetetxt = "
	# WP Maximum Execution Time Exceeded
	<IfModule mod_php5.c>
		php_value max_execution_time 300
	</IfModule>";

	if ( ! function_exists( 'get_home_path' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	$htaccess = get_home_path() . '.htaccess';
	$contents = file_exists( $htaccess ) ? file_get_contents( $htaccess ) : '';
	if ( false !== $contents && false === strpos( $contents, $wpmetetxt ) ) {
		file_put_contents( $htaccess, $contents . $wpmetetxt );
	}
}



/* On deactivation delete code (dc) from htaccess file */

function wpmete_on_deactivation_dc(){

	$wpmetetxt = "
	# WP Maximum Execution Time Exceeded
	<IfModule mod_php5.c>
		php_value max_execution_time 300
	</IfModule>";

	if ( ! function_exists( 'get_home_path' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	$htaccess = get_home_path() . '.htaccess';
	if ( ! file_exists( $htaccess ) ) {
		return;
	}
	$contents = file_get_contents( $htaccess );
	if ( false !== $contents && false !== strpos( $contents, $wpmetetxt ) ) {
		file_put_contents( $htaccess, str_replace( $wpmetetxt, '', $contents ) );
	}
	
}


/** Ask PHP to allow longer requests where the host permits runtime changes. */
function wpmete_apply_runtime_limit() {
    if ( ! is_callable( 'set_time_limit' ) ) {
        return;
    }
    $current = (int) ini_get( 'max_execution_time' );
    // Zero means unlimited; never shorten an existing limit.
    if ( $current > 0 && $current < 300 ) {
        @set_time_limit( 300 );
    }
}
add_action( 'init', 'wpmete_apply_runtime_limit' );

register_activation_hook(   __FILE__, 'wpmete_on_activation_wc' );

register_deactivation_hook( __FILE__, 'wpmete_on_deactivation_dc' );





?>