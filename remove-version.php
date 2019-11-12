<?php
/* Remove wp version from js and css files */

function vc_remove_wp_ver_css_js( $src ) {

    if ( strpos( $src, 'ver=' ) )

        $src = remove_query_arg( 'ver', $src );

    return $src;

}

add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
