<?php
// Special Characters Fixer

add_filter( 'sanitize_file_name', 't5_sanitize_filename', 10 );

function t5_sanitize_filename( $filename ){

    $filename    = html_entity_decode( $filename, ENT_QUOTES, 'utf-8' );

    $filename    = t5_translit( $filename );

    $filename    = t5_lower_ascii( $filename );

    $filename    = t5_remove_doubles( $filename );

    return $filename;

}

function t5_lower_ascii( $str )
{

    $str     = strtolower( $str );

    $regex   = array(

        'pattern'        => '~([^a-z\d_.-])~'

    , 'replacement'  => ''

    );

    return preg_replace( $regex['pattern'], $regex['replacement'], $str );

}

function t5_remove_doubles( $str )

{

    $regex = apply_filters(

        'germanix_remove_doubles_regex'

        , array(

            'pattern'        => '~([=+.-])\\1+~'

        , 'replacement'  => "\\1"

        )

    );

    return preg_replace( $regex['pattern'], $regex['replacement'], $str );

}

function t5_translit( $str )

{

    $utf8 = array(

        'Ç'    => 'C'

    , 'ç'    => 'c'

    , 'ğ'    => 'g'

    , 'Ğ'    => 'G'

    , 'ı'    => 'i'

    , 'I'    => 'I'

    , 'Ö'    => 'O'

    , 'ö'    => 'o'

    , 'ş'    => 's'

    , 'Ş'    => 'S'

    , 'Ü'    => 'U'

    , 'ü'    => 'u'

    , 'İ'    => 'i'

    );

    $str = strtr( $str, $utf8 );

    return trim( $str, '-' );

}