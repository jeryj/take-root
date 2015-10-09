<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package osteo
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
        // check if gravity forms is active
        // do we want to show the contact form in the footer?
        $show_contact_form = get_option('show_contact_in_footer');
        // will return as '1', so use == instead of ===
        // we also want to make sure we're not on the contact page template already
        if($show_contact_form == true && !is_page_template('page-templates/contact.php')) :
            // need this for gravity forms active check
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            // if it's true, let's see if there's actually a form and if gravity forms is installed
            $contact_form = get_option('contact_form');
            if(!empty($contact_form) && is_plugin_active('gravityforms/gravityforms.php') ) :?>
                <div class="contact section">
                    <section class="row-pad">
                        <h2 class="section-title xm-top">Contact Us</h2>
                        <?php echo do_shortcode('[gravityform id='.$contact_form.' title=false ajax=true]');?>
                    </section>
                </div>
            <?endif;
        endif; // end of show_contact_form === true?>

	<div class="site-info section xp-vertical">
		<div class="row">
			<div id="footer-1" class="widget-area center" role="complementary">
				<?php
					dynamic_sidebar( 'footer-1' );
				?>
			</div>
			<div id="footer-2" class="widget-area center" role="complementary">
				<?php
					dynamic_sidebar( 'footer-2' );
					social_icons();
				?>
			</div>
			<div id="footer-3" class="widget-area" role="complementary">
				<?php
				    dynamic_sidebar( 'footer-3' );
					 // Address
                    echo contactInfo();
				?>
			</div>
		</div><!-- .row -->
		<div class="row credits">
			<?php bloginfo( 'name' ); ?> &copy; <?php echo Date('Y'); ?>
			<aside class="created-by">
				Designed by <a href="http://jeremyjon.es" target="_blank">Jeremy Jones</a>
			</aside>
		</div>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
