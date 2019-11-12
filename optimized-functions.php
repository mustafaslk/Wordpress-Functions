<?php
* Disable unneccessary tags, emojis, etc... */

remove_action( 'wp_head', 'rsd_link' );

remove_action( 'wp_head', 'wlwmanifest_link' );

remove_action( 'wp_head', 'wp_generator' );

remove_action( 'wp_head', 'wp_shortlink_wp_head' );

remove_action( 'wp_head', 'wp_generator' );

remove_action( 'wp_head', 'feed_links', 2 );

remove_action( 'wp_head', 'index_rel_link' );

remove_action( 'wp_head', 'feed_links_extra', 3 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

remove_action( 'wp_head', 'wp_resource_hints', 2 );

remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

remove_action( 'welcome_panel', 'wp_welcome_panel' );

add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter( 'json_enabled', '__return_false' );

add_filter( 'json_jsonp_enabled', '__return_false' );



function disable_wp_emojicons() {

    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

}

add_action( 'init', 'disable_wp_emojicons' );



function disable_emojicons_tinymce( $plugins ) {

    if ( is_array( $plugins ) ) {

        return array_diff( $plugins, array( 'wpemoji' ) );

    } else {

        return array();

    }

}



/* Unregister default wp widgets */

function unregister_default_wp_widgets() {

    unregister_widget( 'WP_Widget_Pages' );

    unregister_widget( 'WP_Widget_Calendar' );

    unregister_widget( 'WP_Widget_Archives' );

    unregister_widget( 'WP_Widget_Links' );

    unregister_widget( 'WP_Widget_Meta' );

    unregister_widget( 'WP_Widget_Recent_Comments' );

    unregister_widget( 'WP_Widget_RSS' );

    unregister_widget( 'WP_Widget_Tag_Cloud' );

}

add_action( 'widgets_init', 'unregister_default_wp_widgets', 1 );



/* Remove dashboard items */

add_action( 'wp_dashboard_setup', 'my_custom_dashboard_widgets' );

function my_custom_dashboard_widgets() {

    global $wp_meta_boxes;

    unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_right_now' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_recent_comments' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_incoming_links' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_activity' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_plugins' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_primary' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_secondary' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_quick_press' ] );

    unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_recent_drafts' ] );

}



/* Disable rss feeds */

function fb_disable_feed() {

    wp_die( __( 'No feed available,please visit our <a href="' . get_bloginfo( 'url' ) . '">homepage</a>!' ) );

}

add_action( 'do_feed', 'fb_disable_feed', 1 );

add_action( 'do_feed_rdf', 'fb_disable_feed', 1 );

add_action( 'do_feed_rss', 'fb_disable_feed', 1 );

add_action( 'do_feed_rss2', 'fb_disable_feed', 1 );

add_action( 'do_feed_atom', 'fb_disable_feed', 1 );



/* Remove Customize Menu */

add_action( 'admin_menu', function () {

    global $submenu;

    if ( isset( $submenu[ 'themes.php' ] ) ) {

        foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {

            if ( in_array( 'Customize', $menu_item ) ) {

                unset( $submenu[ 'themes.php' ][ $index ] );

            }

        }

    }

} );

// Disable Tags Dashboard WP

add_action('admin_menu', 'my_remove_sub_menus');

function my_remove_sub_menus() {

    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');

}

// Remove tags support from posts

function myprefix_unregister_tags() {

    unregister_taxonomy_for_object_type('post_tag', 'post');

}

add_action('init', 'myprefix_unregister_tags');