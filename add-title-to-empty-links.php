<?php
/**
 * Add title="" to Empty Links.
 */
function auto_add_link_titles($content)
{

    if (empty($content) || !class_exists('DOMDocument')) {
        return $content;
    }

    $links = array();
    $dom = new DOMDocument('1.0', 'UTF-8');
    $internalErrors = libxml_use_internal_errors(true);
    $dom->loadHTML(utf8_decode($content));
    libxml_use_internal_errors($internalErrors);
    $dom->preserveWhiteSpace = false;
    foreach ($dom->getElementsByTagName('a') as $link) {
        if ($link->getAttribute('title')) {
            continue;
        }
        $link_text = $link->textContent;
        if (!$link_text && !empty($link->firstChild) && $link->firstChild->hasAttributes()) {
            $alt = $link->firstChild->getAttribute('alt');
            $alt = $alt ? $alt : $link->firstChild->getAttribute('title');
            $alt = str_replace('-', ' ', $alt);
            $alt = str_replace('_', ' ', $alt);

            // Return cleaned up alt
            $link_text = $alt;

        }
        if ($link_text) {
            $links[$link_text] = $link->getAttribute('href');
        }

    }

    if (!empty($links)) {
        foreach ($links as $text => $link) {
            if ($link && $text) {
                $text = ($text); // Sanitize
                $text = ucwords($text);  // Captilize words (looks better imo)
                $replace = $link . '" title="' . $text . '"'; // Add title to link
                $content = str_replace($link . '"', $replace, $content); // Replace post content
            }

        }
    }
    return $content;

}

add_filter('the_content', 'auto_add_link_titles');


/**
 * Add title="" to Empty Nav Links.
 */
add_filter('nav_menu_link_attributes', 'add_title_to_nav', 10, 4);
function add_title_to_nav($atts, $item, $args)
{
    $atts['title'] = $item->title;
    return $atts;
}