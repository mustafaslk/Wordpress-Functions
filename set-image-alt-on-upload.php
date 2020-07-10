<?php
/* Automatically set the image Title, Alt-Text, Caption & Description upon upload
--------------------------------------------------------------------------------------*/
add_action('add_attachment', 'set_image_meta_upon_image_upload');
function set_image_meta_upon_image_upload($post_ID)
{
    if (wp_attachment_is_image($post_ID)) {
        $my_image_title = get_post($post_ID)->post_title;
        $my_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $my_image_title);
        $my_image_title = ucwords(strtolower($my_image_title));
        $my_image_meta = array(
            'ID' => $post_ID,
            'post_title' => $my_image_title,
            'post_excerpt' => $my_image_title,
            'post_content' => $my_image_title,
        );
        update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);
        wp_update_post($my_image_meta);

    }
}