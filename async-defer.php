<?php
/**
 * Custom Functions for Wordpress
 */

//Add Async JS Files
function add_async_forscript($url)
{
    if (strpos($url, '#async')===false)
        return $url;
    else if (is_admin())
        return str_replace('#async', '', $url);
    else
        return str_replace('#async', '', $url)."' async='async"; 
}
add_filter('clean_url', 'add_async_forscript', 11, 1);



//Add Defer JS Files
function defer_js_async($tag){

    $scripts_to_defer = array('acf-gmaps.js', 'readmore.min.js', 'elfsight-instagram-feed.js');
    foreach($scripts_to_defer as $defer_script){
        if(true == strpos($tag, $defer_script ) )
        return str_replace( ' src', ' defer="defer" src', $tag );	
    }
    return $tag;
    }
    add_filter( 'script_loader_tag', 'defer_js_async', 10 );