<?php
/* Hide Admin Bar */

add_action( 'set_current_user', 'hide_admin_bar' );

function hide_admin_bar() {

    show_admin_bar( false );

}

//Disable admin bar

add_filter('show_admin_bar', '__return_false');
