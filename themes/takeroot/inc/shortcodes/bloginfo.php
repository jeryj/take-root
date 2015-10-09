<?php
/***
*Path to Theme Shortcode [bloginfo key="template_url"]
***/

function bloginfo_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'key' => '',
    ), $atts));
    return get_bloginfo($key);
}
add_shortcode('bloginfo', 'bloginfo_shortcode');

?>