<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package osteo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<meta property="og:site_name" content="<? bloginfo('name');?>"/>
<meta property="og:title" content="<?php the_title();?>"/>
<?
if(has_post_thumbnail()) :
    $img_id = get_post_thumbnail_id( $post->ID );
    $img_large = wp_get_attachment_image_src( $img_id, 'large' );
    if(!empty($img_large)) :
        $og_img_src = $img_large[0];
    endif;
else :
    // $og_img_src = http://some other image, like the logo;
endif;

if(!empty($og_img_src)) : ?>
<meta property="og:image" content="<? echo $og_img_src;?>"/>
<? endif; ?>

<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri();?>/js/html5shiv.js"></script>
<![endif]-->
<script src="<?php bloginfo('template_directory');?>/js/picturefill.min.js" async></script>

<?php wp_head(); ?>
</head>

<body <?php body_class('no-js'); ?>>
<?php do_action( 'before' ); ?>

<header id="masthead" class="site-header section" role="banner">
    <div class="row">
        <div class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                Osteo
            </a>
        </div>
        <div class="menu-toggle">
            <div class="bar"></div>
        </div>
        <nav id="site-navigation" class="main-navigation" role="navigation">
            <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'osteo' ); ?>"><?php _e( 'Skip to content', 'osteo' ); ?></a></div>
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-wrap' ) ); ?>
        </nav><!-- #site-navigation -->
    </div>

</header><!-- #masthead -->

<div id="page" class="full-width extra-padding-bottom section">
	<div id="content" class="site-content xp-vertical xm-vertical row">
