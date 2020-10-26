<?php
    // we create class instance outside loop, so we need to take wp query instance directly
    $single = JNews\Single\SinglePost::getInstance()->set_post_id($wp_query->post->ID);

    get_header();
    do_action('single_post_' . $single->get_template());
?>
    <div class="post-wrapper">

        <div class="<?php echo apply_filters('jnews_post_wrap_class', 'post-wrap', $wp_query->post->ID); ?>" <?php echo apply_filters('jnews_post_wrap_attribute', '', $wp_query->post->ID); ?>>

            <?php do_action('jnews_single_post_begin', $wp_query->post->ID); ?>

            <div class="jeg_main <?php $single->main_class(); ?>">
                <div class="jeg_container">
					  <?php  					
					  $contentSource= get_post_meta( $wp_query->post->ID);	
					 // print_r($contentSource);
					  $logoIcon		= $contentSource['feed_logo'][0];				  
					  $logoLink		= $contentSource['echo_post_full_url'][0];
					  $logoTitle	= $contentSource['echo_feed_title'][0];
					  $youTubeIcon	= $contentSource['youtubomatic_featured_img'][0];
					  $youTubeLink	= $contentSource['youtubomatic_post_url'][0];
					  $pageCrawLink	= $contentSource['crawlomatic_post_orig_url'][0];
					  $iconWidth	='';
					  $imgLogShow	=true;
					   if(!empty($youTubeIcon)){
						   $iconWidth='width="14%;"';
						   $logoIcon='https://www.youtube.com/img/desktop/yt_1200.png';
						   $logoLink=$contentSource['youtubomatic_post_url'][0];
						   $logoTitle='Youtube';
					   }elseif(!empty($pageCrawLink)){
						   $imgLogShow=false;
						   $logoLink	=	$pageCrawLink;
						   $logoTitle	= $contentSource['crawlomatic_item_title'][0];;
						   
					   }
					  ?>
					  <div style="text-align:center;margin-top:20px;"><span style="">Origin Source</span>  <a href="<?php echo $logoLink;?>" target="_blank" title="<?php echo $logoTitle;?>">
					  <?php if($imgLogShow)	{?>				  <img src="<?php echo $logoIcon;?>" alt="<?php echo $logoTitle;?>" title="<?php echo $logoTitle;?>" <?php echo $iconWidth;?>>
						  <?php }else{?> <?php echo $logoLink; }?>
						  </div>
					  
                    <?php get_template_part('fragment/post/single-post-' . $single->get_template()); ?>
                </div>
            </div>

            <div id="post-body-class" <?php body_class(); ?>></div>

            <?php do_action('jnews_single_post_end', $wp_query->post->ID); ?>

        </div>

        <?php get_template_part('fragment/post/post-overlay'); ?>

    </div>
<?php get_footer(); ?>
