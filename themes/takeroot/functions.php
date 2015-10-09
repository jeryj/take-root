<?php
/**
 * osteo functions and definitions
 *
 * @package osteo
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'osteo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function osteo_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on osteo, use a find and replace
	 * to change 'osteo' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'osteo', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1500, 400, true );

    /**
     * Add custom Image sizes
     *
     * @link http://codex.wordpress.org/Function_Reference/add_image_size
     */

    // ex: add_image_size('featured-image', 1500, 500, true);

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'osteo' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

}
endif; // osteo_setup
add_action( 'after_setup_theme', 'osteo_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function osteo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'osteo' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer One', 'osteo' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Two', 'osteo' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Three', 'osteo' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'osteo_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function osteo_scripts() {
    global $wp_styles;

	wp_enqueue_style( 'osteo-icons', get_template_directory_uri() . '/icons/style.css' );
	wp_enqueue_style( 'osteo-style', get_stylesheet_uri() );

    wp_enqueue_style( 'osteo-style-old-ie', get_stylesheet_directory_uri() . "/ie.css", array( 'osteo-style' ) );
    $wp_styles->add_data( 'osteo-style-old-ie', 'conditional', 'lt IE 9' );

    // tappy for removing 300ms delay on most mobile browsers
    wp_enqueue_script( 'tappy_js',  get_template_directory_uri() . '/js/tappy.js', array(), '20120206', true );

	wp_enqueue_script( 'osteo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    wp_enqueue_script( 'osteo-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'osteo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/* Disable Pre-loaded Jquery from Worpdress and use Google instead.
	If Developing without internet, comment out this section */
	if( !is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"), false, '1.11.2');
		wp_enqueue_script('jquery');
	}
}
add_action( 'wp_enqueue_scripts', 'osteo_scripts' );



/* Allow shortcodes in widgets */
add_filter('widget_text', 'do_shortcode');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/shortcodes/bloginfo.php';
require get_template_directory() . '/inc/photoswipe.php';


function archiveTitle() {
    if ( is_post_type_archive() ) :
        post_type_archive_title();

    elseif ( is_category() || is_tax() ) :
        single_cat_title();

    elseif ( is_tag() ) :
        single_tag_title();

    elseif ( is_author() ) :
        /* Queue the first post, that way we know
         * what author we're dealing with (if that is the case).
        */
        the_post();
        printf( __( 'Author: %s', 'osteo' ), '<span class="vcard">' . get_the_author() . '</span>' );
        /* Since we called the_post() above, we need to
         * rewind the loop back to the beginning that way
         * we can run the loop properly, in full.
         */
        rewind_posts();

    elseif ( is_day() ) :
        printf( __( 'Day: %s', 'osteo' ), '<span>' . get_the_date() . '</span>' );

    elseif ( is_month() ) :
        printf( __( 'Month: %s', 'osteo' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

    elseif ( is_year() ) :
        printf( __( 'Year: %s', 'osteo' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

    elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
        _e( 'Asides', 'osteo' );

    elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
        _e( 'Images', 'osteo');

    elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
        _e( 'Videos', 'osteo' );

    elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
        _e( 'Quotes', 'osteo' );

    elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
        _e( 'Links', 'osteo' );
    else :
        _e( 'Archives', 'osteo' );
    endif;
}

function contactInfo() {
    $address_line_1 = get_option('address_line_1');
    $address_line_2 = get_option('address_line_2');
    $city_st_zip = get_option('city_st_zip');
    $phone_number = get_option('phone_number');
    $contact_email = get_option('contact_email');

    $contact_info = '';

    // get the address all chained together
    if(!empty($address_line_1) || !empty($city_st_zip)) :
        // we know we'll show it, so start the address w/ icon
        $address = '<li><i class="icon-property"></i>';

        if(!empty($address_line_1)) :
            // we know we have the first address
            $address .= $address_line_1
                        // let's check for the second line.
                        .(!empty($address_line_2 ) ? '<br/>'.$address_line_2 : '');
        endif;

        // check on the city st zip
        if(!empty($city_st_zip)) :
            // if the address_line_1 is empty, then we don't need the <br/>. Otherwise, we just need the city_st_zp
            $address .= (!empty($address_line_1) ? '<br/>'.$city_st_zip : $city_st_zip );
        endif;

        // append the final li
        $address .= '</li>';
    endif;


    if(!empty($address) || !empty($phone_number) || !empty($contact_email) ) {
        $contact_info = '<ul class="contact-info i-list">'
             .(!empty($address ) ? $address : '')
             .(!empty($phone_number ) ? '<li><i class="icon-phonelight"></i>'.$phone_number.'</li>' : '')
             .(!empty($contact_email ) ? '<li><i class="icon-email"></i>'.$contact_email.'</li>' : '')
            .'</ul>';
    }

    return $contact_info;
}

function social_icons() {
    // Social Media
    $social_facebook = get_option('social_facebook');
    $social_twitter = get_option('social_twitter');
    $social_googleplus = get_option('social_googleplus');
    $social_linkedin = get_option('social_linkedin');
    // $social_instagram = get_option('social_instagram');
    // $social_pinterest = get_option('social_pinterest');

    if(!empty($social_pinterest ) || !empty($social_instagram) || !empty($social_facebook) || !empty($social_twitter) || !empty($social_googleplus) || !empty($social_linkedin)) {
        echo '<ul class="social-icons">'
                //.(!empty($social_instagram ) ? '<li><a href="'.$social_instagram.'"><i class="icon-instagram instagram"></i><div class="screen-reader-text">Instagram</div></a></li>' : '')
                .(!empty($social_facebook ) ? '<li><a href="'.$social_facebook.'"><i class="icon-facebook facebook"></i><div class="screen-reader-text">Facebook</div></a></li>' : '')
                .(!empty($social_twitter ) ? '<li><a href="'.$social_twitter.'"><i class="icon-twitter twitter"></i><div class="screen-reader-text">Twitter</div></a></li>' : '')
                .(!empty($social_googleplus ) ? '<li><a href="'.$social_googleplus.'"><i class="icon-google-plus"></i><div class="screen-reader-text">Google Plus</div></a></li>' : '')
                .(!empty($social_linkedin ) ? '<li><a href="'.$social_linkedin.'"><i class="icon-linkedin linkedin"></i><div class="screen-reader-text">Linkedin</div></a></li>' : '')
                //.(!empty($social_pinterest ) ? '<li><a href="'.$social_pinterest.'"><i class="icon-pinterest pinterest"></i><div class="screen-reader-text">Pinterest</div></a></li>' : '')
            .'</ul>';
    }
}


function new_excerpt_more($more) {
    global $post;
    // use &nbsp; to keep them on one line.
    return '&hellip; <a class="moretag" href="'. get_permalink($post->ID) . '">Read&nbsp;More&nbsp;<i class="icon-chevron-right read-more-icon"></i></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
