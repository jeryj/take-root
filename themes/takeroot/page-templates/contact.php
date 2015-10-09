<?php
/**
 * Template Name: Contact
 *
 * When you just want a simple, full width content page.
 *
 * @package osteo
 */

get_header(); ?>
    <div id="primary" class="content-area full-width">
        <main id="main" class="site-main row" role="main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->
            <?
                // setup columns
                $col_1 = '';
                $col_2 = '';

                while ( have_posts() ) : the_post();
                    if( !empty( get_the_content() ) ) :
                        $col_1 .= wpautop(get_the_content());
                    endif;
                endwhile; // end of the loop.

                // check if we have an address and whatnot
                $contact_info = contactInfo();
                if( !empty($contact_info) ) :
                    $col_1 .= $contact_info;
                endif;

                // check on the form
                // need this for gravity forms active check
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                // if it's true, let's see if there's actually a form and if gravity forms is installed
                $contact_form = get_option('contact_form');

                if(!empty($contact_form) && is_plugin_active('gravityforms/gravityforms.php') ) :
                            $col_2 .= do_shortcode('[gravityform id='.$contact_form.' title=false ajax=true]');
                endif;

                // Now build everything ?>
                <div class="row">
                    <? if( !empty($col_1) && !empty($col_2) ) : // if both columns are here, do a grid base?>
                        <div class="grid_6">
                            <? echo $col_1;?>
                        </div>
                        <div class="grid_6 last well">
                            <? echo $col_2;?>
                        </div>
                    <? else : // if there's only one column, just ouput both of them. It doesn't matter which one is empty or not
                        echo $col_1;
                        echo $col_2;
                    endif; ?>
                </div>
            </article>


        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer(); ?>
