<?php
    // alternate banner images
    // put in header.php if you want to use it

    // Check for Featured Images
    $banner_bg = '';
    $tagline = '';
    $banner_classes = '';
    $service_icon = '';

    if(is_home()) :
        $news_page = get_option('page_for_posts');
        $page_title = get_the_title($news_page);
        if ( has_post_thumbnail( $news_page ) ) :
            $featured_img = get_post_thumbnail_id($news_page);
        endif;
    elseif(is_front_page()) :
        $slides = get_option('slide_imgs');
    elseif(is_post_type_archive()) :
        // do nothing
    elseif ( has_post_thumbnail( $post->ID ) ) :
        $featured_img = get_post_thumbnail_id();
        $page_title = get_the_title();
    else :
        $page_title = get_the_title();
    endif;


    // actually get the image now
    if(!empty($featured_img)) {
        $banner_bg = wp_get_attachment_image_src($featured_img,'post-thumbnail', true);
        $banner_classes .= ' banner-img';
    } else {
        $banner_classes .= ' no-banner-img';
    }

if(is_front_page() && !empty($slides)) :
    // output the flexslider?>
    <div id="banner" class="flexslider">
        <ul class="slides no-style">
        <?php
            foreach($slides as $slide) {?>
                <li><section>
                        <?php if(!empty($slide['image'])) : ?>
                            <div class="slide-image">
                                <?php $slide_img = wp_get_attachment_image_src($slide['image'],'tile', true);
                                if($slide_img !== false) :
                                    echo '<img class="aligncenter" src="'.$slide_img[0].'" />';
                                endif;
                                ?>
                            </div>
                        <? endif;?>
                        <div class="slide-content">
                            <h2><?php echo $slide['title'];?></h2>
                            <p><?php echo $slide['description'];?></p>
                            <p class="get-started"><a class="btn btn-primary" href="<?php echo $slide['button_link'];?>"><?php echo (!empty($slide['button_text']) ? $slide['button_text'] : 'Get Started');?></a></p>
                        </div>
                    </section>
                </li>
            <?}?>
        </ul>
    </div>
<?php else : // output the banner ?>
    <div id="banner" class="<?php echo (!empty($banner_classes) ? $banner_classes : '');?>"<?php echo (!empty($banner_bg) ? ' style="background-image: url('.$banner_bg[0].');"' : '');?>>
        <div class="banner-overlay <?php echo (!empty($banner_overlay) ? $banner_overlay : '');?>"></div>
        <div class="row-pad">
            <div class="title-section">
                <h1 class="page-title"><?php if(!empty($page_title)){ echo $page_title;}else{archiveTitle();}?></h1>
                <?php if(!empty($tagline)) :?>
                    <div class="page-tagline">
                        <p class="m-no"><?php echo $tagline;?></p>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </div>
<?php endif;?>
