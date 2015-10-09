<?php

function output_pswp_html($content) {
    //check if there is a post gallery. if so, output the html
    if(get_post_gallery()) :

        $content .= '<!-- Root element of PhotoSwipe. Must have class pswp. -->
            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                <!-- Background of PhotoSwipe.
                     Its a separate element, as animating opacity is faster than rgba(). -->
                <div class="pswp__bg"></div>

                <!-- Slides wrapper with overflow:hidden. -->
                <div class="pswp__scroll-wrap">

                    <!-- Container that holds slides.
                            PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                    <div class="pswp__container">
                        <!-- dont modify these 3 pswp__item elements, data is added later on -->
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                    </div>

                    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                    <div class="pswp__ui pswp__ui--hidden">

                        <div class="pswp__top-bar">

                            <!--  Controls are self-explanatory. Order can be changed. -->

                            <div class="pswp__counter"></div>

                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                            <!-- <button class="pswp__button pswp__button--share" title="Share"></button> -->

                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                            <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                            <!-- element will get class pswp__preloader--active when preloader is running -->
                            <div class="pswp__preloader">
                                <div class="pswp__preloader__icn">
                                  <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div>
                        </div>

                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                        </button>

                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                        </button>

                        <div class="pswp__caption">
                            <div class="pswp__caption__center"></div>
                        </div>

                      </div>

                    </div>

            </div>';

    endif;

    return $content;
}

add_filter( 'the_content', 'output_pswp_html' );


//============================== insert HTML header tag ========================//

add_shortcode( 'gallery', 'photoswipe_shortcode' );
add_shortcode( 'photoswipe', 'photoswipe_shortcode' );

// image sizes
add_image_size('gallery-big-thumbnail', 500, 500, true);
add_image_size('gallery-medium-thumbnail', 300, 300, true);

add_image_size('gallery-big', 0, 800);
add_image_size('gallery-med', 0, 500, true);
add_image_size('gallery-small', 0, 300, true);

function photoswipe_scripts_method() {
    if(is_singular()) {
        wp_enqueue_script( 'osteo-photoswipe', get_template_directory_uri() . '/js/photoswipe/photoswipe.min.js', array(), '20130115', true );
        wp_enqueue_script( 'osteo-photoswipe-ui', get_template_directory_uri() . '/js/photoswipe/photoswipe-ui-default.min.js', array(), '20130115', true );
        wp_enqueue_script( 'photoswipe-gallery',        get_template_directory_uri() . '/js/photoswipe/photoswipe-init.js', array( 'jquery' ));
    }
}
add_action('wp_enqueue_scripts', 'photoswipe_scripts_method');


function photoswipe_shortcode( $attr ) {

    global $post;

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    $args = shortcode_atts(array(
        'id'                => intval($post->ID),
        'columns'    => 3,
        'size'       => 'thumbnail',
        'order'      => 'DESC',
        'orderby'    => 'menu_order ID',
        'include'    => '',
        'exclude'    => ''
    ), $attr);


    $output_buffer='';

    if ( !empty($args['include']) ) {

        //"ids" == "inc"

        $include = preg_replace( '/[^0-9,]+/', '', $args['include'] );
        $_attachments = get_posts( array('include' => $args['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } elseif ( !empty($args['exclude']) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $args['exclude'] );
        $attachments = get_children( array('post_parent' => $args['id'], 'exclude' => $args['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );
    } else {

        $attachments = get_children( array('post_parent' => $args['id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );

    }

    // get the number so we know how many columns to output
    $num_of_imgs = count($attachments);
    if(7 <= $num_of_imgs || 4 === $num_of_imgs) {
        $cols = 'four-gallery';
    } elseif(3 <= $num_of_imgs) {
        $cols = 'three-gallery';
    } else {
        $cols = 'two-gallery';
    }

    $output_buffer .='<div id="photoswipe-gallery" class="photoswipe-gallery '.$cols.'" itemscope itemtype="http://schema.org/ImageGallery" >';


    if ( !empty($attachments) ) {
        foreach ( $attachments as $aid => $attachment ) {

            $_post = get_post($aid);

            $image_title = esc_attr($_post->post_title);
            $image_caption = $_post->post_excerpt;
            // maybe do an if-empty with the image_caption?
            // $image_description = $_post->post_content;

            $img_big = wp_get_attachment_image_src( $aid, 'gallery-big' );
            $img_med = wp_get_attachment_image_src( $aid, 'gallery-med' );
            $img_small = wp_get_attachment_image_src( $aid, 'gallery-small' );
            $img_thumb_big = wp_get_attachment_image_src( $aid, 'gallery-big-thumbnail' );
            $img_thumb_medium = wp_get_attachment_image_src( $aid, 'gallery-medium-thumbnail' );
            $img_thumb_small = wp_get_attachment_image_src( $aid, 'thumbnail' );
            $alt_text = get_post_meta($aid , '_wp_attachment_image_alt', true);

            if(500 === $img_big[1] ) { // if the big thumbnail isn't big enough, grab the smaller one
                $srcset = $img_thumb_big[0].' '.$img_thumb_big[1].'w,'
                        .$img_thumb_medium[0].' '.$img_thumb_medium[1].'w,'
                        .$img_thumb_small[0].' '.$img_thumb_small[1].'w';
            } else {
                $srcset = $img_thumb_medium[0].' '.$img_thumb_medium[1].'w,'
                .$img_thumb_small[0].' '.$img_thumb_small[1].'w';
            }

            $output_buffer .='
            <figure class="gallery-item" itemscope itemtype="http://schema.org/ImageObject">
                <a href="'. $img_big[0] .'" itemprop="contentUrl" data-size="'.$img_big[1].'x'.$img_big[2].'">
                    <img class="gallery-image"
                        itemprop="thumbnail"
                        sizes="(min-width: 34em) 33vw,
                               50vw"
                        srcset="'.$srcset.'"
                        title="'.$image_title.'"
                        alt="'.$alt_text.'"
                    />
                </a>
                <figcaption class="gallery-caption" >'. $image_caption .'</figcaption>
            </figure>';
        }
    }

    $output_buffer .= "</div>";

    return $output_buffer;
}
