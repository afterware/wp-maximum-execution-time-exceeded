<?php
// Run only in the disposable WordPress test environment.
require_once ABSPATH . 'wp-admin/includes/file.php';
$path = get_home_path() . '.htaccess';
$initial = file_get_contents( $path );
if ( 1 !== substr_count( $initial, '# WP Maximum Execution Time Exceeded' ) ) {
    throw new RuntimeException( 'Activation did not add exactly one directive' );
}
wpmete_on_activation_wc();
if ( $initial !== file_get_contents( $path ) ) {
    throw new RuntimeException( 'Repeated activation changed .htaccess' );
}
wpmete_on_deactivation_dc();
if ( false !== strpos( file_get_contents( $path ), '# WP Maximum Execution Time Exceeded' ) ) {
    throw new RuntimeException( 'Deactivation did not remove the directive' );
}
wpmete_on_deactivation_dc();
echo "PASS activation is idempotent and deactivation removes the directive\n";

if ( is_callable( 'set_time_limit' ) ) {
    set_time_limit( 30 );
    wpmete_apply_runtime_limit();
    if ( (int) ini_get( 'max_execution_time' ) !== 300 ) {
        throw new RuntimeException( 'Runtime limit was not increased' );
    }
    set_time_limit( 600 );
    wpmete_apply_runtime_limit();
    if ( (int) ini_get( 'max_execution_time' ) !== 600 ) {
        throw new RuntimeException( 'An existing higher limit was shortened' );
    }
    set_time_limit( 0 );
    wpmete_apply_runtime_limit();
    if ( (int) ini_get( 'max_execution_time' ) !== 0 ) {
        throw new RuntimeException( 'An unlimited runtime was shortened' );
    }
    echo "PASS PHP execution limit and existing higher limits\n";
}
