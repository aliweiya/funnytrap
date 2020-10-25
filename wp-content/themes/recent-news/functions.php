<?php
/**
 *Recommended way to include parent theme styles.
 *(Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 */
//after theme setup hook for background color
if (!function_exists('recent_news_setup')) :
    function recent_news_setup()
    {

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('refined_magazine_custom_background_args', array(
            'default-color' => '#ffffff ',
            'default-image' => '',
        )));

    }
endif;
add_action('after_setup_theme', 'recent_news_setup');
/**
 * Loads the child theme textdomain.
 */
function recent_news_load_language() {
    load_child_theme_textdomain( 'recent-news' );
}
add_action( 'after_setup_theme', 'recent_news_load_language' );

/**
* Enqueue Style
*/
add_action( 'wp_enqueue_scripts', 'recent_news_style' );
function recent_news_style() {
    wp_enqueue_style('recent-news-heading', '//fonts.googleapis.com/css?family=Oswald');
	wp_enqueue_style( 'refined-magazine-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'recent-news-style',get_stylesheet_directory_uri() . '/style.css',array('refined-magazine-style'));

    wp_enqueue_script('recent-news-custom-js', get_stylesheet_directory_uri() . '/js/recent-news-custom.js', array('jquery'), '20151215', true);
}

/**
 * Enqueue fonts for the editor style
 */
function recent_news_block_styles() {

    /*heading  */
    wp_enqueue_style('recent-news-editor-heading-font', '//fonts.googleapis.com/css?family=Helvetica');

    $recent_news_custom_css = '
    .editor-post-title__block .editor-post-title__input,
    .editor-styles-wrapper h1,
    .editor-styles-wrapper h2,
    .editor-styles-wrapper h3,
    .editor-styles-wrapper h4,
    .editor-styles-wrapper h5,
    .editor-styles-wrapper h6{
        font-family:Helvetica;
    } 
    ';

    wp_add_inline_style( 'recent-news-editor-styles', $recent_news_custom_css );
}

add_action( 'enqueue_block_editor_assets', 'recent_news_block_styles' );

/**
 * Refined Magazine Theme Customizer default values
 *
 * @package Refined Magazine
 */
if ( !function_exists('refined_magazine_default_theme_options_values') ) :
    function refined_magazine_default_theme_options_values() {
		$date=date('Y');
        $default_theme_options = array(

             /*General Colors*/
            'refined-magazine-primary-color' => '#d10014 ',
            'refined-magazine-site-title-hover'=> '',
            'refined-magazine-site-tagline'=> '',
            

            /*Logo Section Colors*/
            'refined-magazine-logo-section-background' => '#cc2222',

            /*logo position*/
            'refined-magazine-custom-logo-position'=> 'default',

            /*Site Layout Options*/
            'refined-magazine-site-layout-options'=>'full-width',
            'refined-magazine-boxed-width-options'=> 1500,

            /*Top Header Section Default Value*/
            'refined-magazine-enable-top-header'=> true,
            'refined-magazine-enable-top-header-social'=> true,
            'refined-magazine-enable-top-header-menu'=> true,
            'refined-magazine-enable-top-header-date' => true,
            
            /*Treding News*/
            'refined-magazine-enable-trending-news' => true,
            'refined-magazine-enable-trending-news-text'=> esc_html__('Trending News','recent-news'),
            'refined-magazine-trending-news-category'=> 0,

            /*Menu Section*/
            'refined-magazine-enable-menu-section-search'=> true,
            'refined-magazine-enable-sticky-primary-menu'=> true,
            'refined-magazine-enable-menu-home-icon' => true,

            /*Header Ads Default Value*/
            'refined-magazine-enable-ads-header'=> false,
            'refined-magazine-header-ads-image'=> '',
            'refined-magazine-header-ads-image-link'=> '',

            /*Slider Section Default Value*/
            'refined-magazine-enable-slider' => true,
            'refined-magazine-select-category'=> 0,
            'refined-magazine-select-category-featured-right' => 0,
            'refined-magazine-slider-post-date'=> true,
            'refined-magazine-slider-post-author'=> false,
            'refined-magazine-slider-post-category'=> true,
            'refined-magazine-slider-post-read-time'=> true,
            

            /*Sidebars Default Value*/
            'refined-magazine-sidebar-blog-page'=>'right-sidebar',
            'refined-magazine-sidebar-front-page' => 'right-sidebar',
            'refined-magazine-sidebar-archive-page'=> 'right-sidebar',

            /*Blog Page Default Value*/
            'refined-magazine-content-show-from'=>'excerpt',
            'refined-magazine-excerpt-length'=>25,
            'refined-magazine-pagination-options'=>'numeric',
            'refined-magazine-read-more-text'=> '',
            'refined-magazine-enable-blog-author'=> false,
            'refined-magazine-enable-blog-category'=> true,
            'refined-magazine-enable-blog-date'=> true,
            'refined-magazine-enable-blog-comment'=> false,
            'refined-magazine-enable-blog-tags'=> false,

            /*Single Page Default Value*/
            'refined-magazine-single-page-featured-image'=> true,
            'refined-magazine-single-page-related-posts'=> true,
            'refined-magazine-single-page-related-posts-title'=> esc_html__('Related Posts','recent-news'),
            'refined-magazine-enable-single-category' => true,
            'refined-magazine-enable-single-date' => true,
            'refined-magazine-enable-single-author' => true,
            

            /*Sticky Sidebar Options*/
            'refined-magazine-enable-sticky-sidebar'=> true,

            /*Social Share Options*/
            'refined-magazine-enable-single-sharing'=> true,
            'refined-magazine-enable-blog-sharing'=> false,
            'refined-magazine-enable-static-page-sharing' => false,

            /*Footer Section*/
            'refined-magazine-footer-copyright' =>  esc_html__('Copyright © '.$date.'  Brnfullstack   . All Rights Reserved.','recent-news'),
            'refined-magazine-go-to-top'=> true,
            
            
            /*Extra Options*/
            'refined-magazine-extra-breadcrumb'=> true,
            'refined-magazine-breadcrumb-text'=>  esc_html__('You are Here','recent-news'),
            'refined-magazine-extra-preloader'=> true,
            'refined-magazine-front-page-content' => false,
            'refined-magazine-extra-hide-read-time' => false,
            'refined-magazine-extra-post-formats-icons'=> true,
            'refined-magazine-enable-category-color' => false,
            'refined-magazine-post-published-date'=>'post-updated',

            'refined-magazine-breadcrumb-display-from-option'=> 'theme-default',
            'refined-magazine-breadcrumb-display-from-plugins'=> 'yoast',

            'refined-magazine-blog-col-options'=> 'three-columns',
            'refined-magazine-enable-post-carousel-below-slider'=> true,
            'refined-magazine-post-carousel-below-slider-cat'=> 0,
            'refined-magazine-enable-post-carousel-below-slider-title'=> esc_html__('Featured Posts Carousel','recent-news'),

        );
        return apply_filters( 'refined_magazine_default_theme_options_values', $default_theme_options );
    }
endif;


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function recent_news_customize_register( $wp_customize ) {

    $default = refined_magazine_default_theme_options_values();

     /*Blog Page Pagination Options*/
      $wp_customize->add_setting( 'refined_magazine_options[refined-magazine-blog-col-options]', array(
          'capability'        => 'edit_theme_options',
          'transport' => 'refresh',
          'default'           => $default['refined-magazine-blog-col-options'],
          'sanitize_callback' => 'refined_magazine_sanitize_select'
      ) );
      $wp_customize->add_control( 'refined_magazine_options[refined-magazine-blog-col-options]', array(
         'choices' => array(
             'one-column'    => __('Single Column','recent-news'),
             'two-columns'   => __('Two Column','recent-news'),
             'three-columns'   => __('Three Column','recent-news'),
      ),
         'label'     => __( 'Blog Column Options', 'recent-news' ),
         'description' => __('Select the Required Blog Page Column', 'recent-news'),
         'section'   => 'refined_magazine_blog_page_section',
         'settings'  => 'refined_magazine_options[refined-magazine-blog-col-options]',
         'type'      => 'select',
         'priority'  => 9,
      ) );


          /*Post Carousel Below Slider*/
    $wp_customize->add_section( 'refined_magazine_post_carousel_below_slider', array(
        'priority'       => 26,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __( 'Carousel Below Featured Section', 'recent-news' ),
        'panel'          => 'refined_magazine_panel',
    ) );
    /*Enable Post Carousel Below Slider*/
    $wp_customize->add_setting( 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider]', array(
        'capability'        => 'edit_theme_options',
        'transport' => 'refresh',
        'default'           => $default['refined-magazine-enable-post-carousel-below-slider'],
        'sanitize_callback' => 'refined_magazine_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider]', array(
        'label'     => __( 'Enable Post Carousel Below Slider', 'recent-news' ),
        'description' => __('Enable post carousel below Slider.', 'recent-news'),
        'section'   => 'refined_magazine_post_carousel_below_slider',
        'settings'  => 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider]',
        'type'      => 'checkbox',
        'priority'  => 20,
    ) );

    /*callback functions you may missed*/
if ( !function_exists('recent_news_post_carousel_enable') ) :
    function recent_news_post_carousel_enable(){
        global $refined_magazine_theme_options;
        $posts_carousel = absint($refined_magazine_theme_options['refined-magazine-enable-post-carousel-below-slider']);
        if( 1 == $posts_carousel ){
            return true;
        }
        else{
            return false;
        }
    }
endif;

/*Carousel Category*/
$wp_customize->add_setting( 'refined_magazine_options[refined-magazine-post-carousel-below-slider-cat]', array(
  'capability'        => 'edit_theme_options',
  'transport' => 'refresh',
  'default'           => $default['refined-magazine-post-carousel-below-slider-cat'],
  'sanitize_callback' => 'absint'
) );
$wp_customize->add_control(
  new refined_magazine_Customize_Category_Dropdown_Control(
    $wp_customize,
    'refined_magazine_options[refined-magazine-post-carousel-below-slider-cat]',
    array(
      'label'     => __( 'Select Category For Post Carousel', 'recent-news' ),
      'description' => __('From the dropdown select the category for the first column.', 'recent-news'),
      'section'   => 'refined_magazine_post_carousel_below_slider',
      'settings'  => 'refined_magazine_options[refined-magazine-post-carousel-below-slider-cat]',
      'type'      => 'category_dropdown',
      'priority'  => 20,
      'active_callback'=>'recent_news_post_carousel_enable'
    )
  )
);


/*Post Carousel Title*/
$wp_customize->add_setting( 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider-title]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['refined-magazine-enable-post-carousel-below-slider-title'],
    'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider-title]', array(
    'label'     => __( 'Title Post Carousel Below Slider', 'recent-news' ),
    'description' => __('Enter the title of Post Carousel.', 'recent-news'),
    'section'   => 'refined_magazine_post_carousel_below_slider',
    'settings'  => 'refined_magazine_options[refined-magazine-enable-post-carousel-below-slider-title]',
    'type'      => 'text',
    'priority'  => 20,
    'active_callback'=> 'recent_news_post_carousel_enable',
) );


     /*Post Published and Updated Date*/
      $wp_customize->add_setting( 'refined_magazine_options[refined-magazine-post-published-date]', array(
          'capability'        => 'edit_theme_options',
          'transport' => 'refresh',
          'default'           => $default['refined-magazine-post-published-date'],
          'sanitize_callback' => 'refined_magazine_sanitize_select'
      ) );
      $wp_customize->add_control( 'refined_magazine_options[refined-magazine-post-published-date]', array(
         'choices' => array(
             'post-published'    => __('Post Published Date','recent-news'),
             'post-updated'   => __('Post Updated Date','recent-news'),
      ),
         'label'     => __( 'Post Published or Updated Date', 'recent-news' ),
         'description' => __('Select the post published or update date in site.', 'recent-news'),
         'section'   => 'refined_magazine_extra_options',
         'settings'  => 'refined_magazine_options[refined-magazine-post-published-date]',
         'type'      => 'select',
         'priority'  => 9,
      ) );

}
add_action( 'customize_register', 'recent_news_customize_register', 999 );

/**
 * Load new thumbnail widget
 */
require get_stylesheet_directory() . '/candid-thumbnail-three-col.php';

/**
 * Implement the Custom Header feature.
 */
require get_stylesheet_directory() . '/inc/custom-header.php';

if (!function_exists('refined_magazine_constuct_carousel')) {
    /**
     * Add carousel on header
     *
     * @since 1.0.0
     */
    function refined_magazine_constuct_carousel()
    {

        if (is_front_page()) {
            global $refined_magazine_theme_options;
            $refined_magazine_site_layout = $refined_magazine_theme_options['refined-magazine-site-layout-options'];
            $slider_cat = $refined_magazine_theme_options['refined-magazine-select-category'];
            $featured_cat = $refined_magazine_theme_options['refined-magazine-select-category-featured-right'];
            $refined_magazine_enable_date = $refined_magazine_theme_options['refined-magazine-slider-post-date'];
            $refined_magazine_enable_author = $refined_magazine_theme_options['refined-magazine-slider-post-author'];
            ?>
            <div class="refined-magazine-featured-block refined-magazine-ct-row refined-awesome-carousel clearfix">
                <?php

                refined_magazine_main_carousel($slider_cat);


                $query_args = array(
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'posts_per_page' => 4,
                    'cat' => $featured_cat
                );

                $query = new WP_Query($query_args);
                if ($query->have_posts()) :
                    ?>
                    <div class="refined-magazine-col refined-magazine-col-2">
                        <div class="refined-magazine-inner-row clearfix">
                            <?php
                            $i=1;
                            while ($query->have_posts()) :
                                $query->the_post();



                                ?>
                                <div class="refined-magazine-col">
                                    <div class="featured-section-inner ct-post-overlay">
                                        <?php
                                        if (has_post_thumbnail()) {
                                                ?>
                                                <div class="post-thumb">
                                                    <?php
                                                    refined_magazine_post_formats(get_the_ID());
                                                    ?>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php
                                                        if ($refined_magazine_site_layout == 'boxed') {
                                                            the_post_thumbnail('refined-magazine-carousel-img');
                                                        } else {
                                                            the_post_thumbnail('refined-magazine-carousel-large-img');
                                                        }
                                                        ?>
                                                    </a>
                                                </div>
                                                <?php
                                        }else{
                                                ?>
                                                <div class="post-thumb">
                                                    <?php
                                                    refined_magazine_post_formats(get_the_ID());
                                                    ?>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php
                                                        if ($refined_magazine_site_layout == 'boxed') {
                                                            ?>
                                                            <img src="<?php echo esc_url(get_template_directory_uri()).'/candidthemes/assets/images/refined-mag-carousel.jpg' ?>" alt="<?php the_title(); ?>">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="<?php echo esc_url(get_template_directory_uri()).'/candidthemes/assets/images/refined-mag-carousel-large.jpg' ?>" alt="<?php the_title(); ?>">
                                                            <?php
                                                        }
                                                        ?>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                        ?>

                                        <div class="featured-section-details post-content">
                                            <div class="post-meta">
                                                <?php
                                                refined_magazine_featured_list_category(get_the_ID());
                                                ?>
                                            </div>
                                            <h3 class="post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <div class="post-meta">
                                                <?php
                                                if ($refined_magazine_enable_date) {
                                                    refined_magazine_widget_posted_on();
                                                }
                                                refined_magazine_read_time_slider(get_the_ID());
                                                if ($refined_magazine_enable_author) {
                                                    refined_magazine_widget_posted_by();
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div> <!-- .featured-section-inner -->
                                </div><!--.refined-magazine-col-->
                                <?php
                                $i++;

                            endwhile;
                            wp_reset_postdata()
                            ?>

                        </div>
                    </div><!--.refined-magazine-col-->
                <?php
                endif;
                ?>

            </div><!-- .refined-magazine-ct-row-->
            <?php


        }//is_front_page
    }
}


/**
 * Add class in post list
 *
 * @since 1.0.0
 *
 */
add_filter('post_class', 'recent_news_post_column_class');
function recent_news_post_column_class($classes)
{
    global $refined_magazine_theme_options;
    if (!is_singular()) {
        $classes[] = esc_attr($refined_magazine_theme_options['refined-magazine-blog-col-options']);
    }
    return $classes;
}



if (!function_exists('refined_magazine_footer_siteinfo')) {
    /**
     * Add footer site info block
     *
     * @param none
     * @return void
     * @since 1.0.0
     *
     */
    function refined_magazine_footer_siteinfo()
    {
        ?>

        <div class="site-info" <?php refined_magazine_do_microdata('footer'); ?>>
            <div class="container-inner">
                <?php
                global $refined_magazine_theme_options;
                $refined_magazine_copyright = wp_kses_post($refined_magazine_theme_options['refined-magazine-footer-copyright']);
                if (!empty($refined_magazine_copyright)):
                    ?>
                    <span class="copy-right-text"><?php echo $refined_magazine_copyright; ?></span><br>
                <?php
                endif; //$refined_magazine_copyright
                ?>
            </div> <!-- .container-inner -->
        </div><!-- .site-info -->
        <?php
    }
}


// Post Carousel from Customizer
if (!function_exists('recent_news_post_carousel_customizer')) {
    /**
     * Post Carousel from Customizer
     *
     * @since 1.0.0
     */
    function recent_news_post_carousel_customizer()
    {
        global $refined_magazine_theme_options;
        $cat_id = absint($refined_magazine_theme_options['refined-magazine-post-carousel-below-slider-cat']);
        $section_title = esc_html($refined_magazine_theme_options['refined-magazine-enable-post-carousel-below-slider-title']);
        $hide_read_time = $refined_magazine_theme_options['refined-magazine-extra-hide-read-time'];

        
		$trendCatIds=array(28,29,2,3,4,5,6,7,8);
        if (count($trendCatIds)) :

            ?>
            <div class="ct-header-carousel-section">
                <div class="container-inner">
                    <?php
                    if ($section_title) {
                        ?>
                        <h2 class="widget-title"> <?php echo $section_title; ?> </h2>
                        <?php
                    }
                    ?>
                    <div class="ct-header-carousel clearfix">
                        <?php
                        
                    
							foreach ( $trendCatIds as $news_cat ) :
							
							$query_args = array(
							'post_type' => 'post',
							'ignore_sticky_posts' => true,
							'posts_per_page' => 1,
							'cat' => $news_cat
							);

						$query = new WP_Query($query_args);
                        while ($query->have_posts()) :
                            $query->the_post();
                            ?>
                            <div class="ct-carousel-single ct-post-overlay">
                                <?php
                                if (has_post_thumbnail()) {
                                    ?>
                                    <div class="post-thumb">
                                        <?php
                                        refined_magazine_post_formats(get_the_ID());
                                        ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('refined-magazine-carousel-img'); ?>
                                        </a>
                                    </div>
                                    <?php
                                } else {
                                    ?>

                                    <div class="post-thumb">
                                        <?php
                                        refined_magazine_post_formats(get_the_ID());
                                        ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url (get_template_directory_uri()) . '/candidthemes/assets/images/refined-mag-carousel.jpg' ?>"
                                                 alt="<?php the_title(); ?>">

                                        </a>
                                    </div>

                                    <?php
                                }
                                ?>
                                <div class="featured-section-details post-content">
                                    <div class="post-meta">
                                        <?php
                                        refined_magazine_list_category(get_the_ID());
                                        ?>
                                    </div>
                                    <h3 class="post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="post-meta">
                                        <?php
                                        refined_magazine_posted_on();
                                        if ($hide_read_time != 1) {
                                            refined_magazine_read_time_words_count(get_the_ID());
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        <?php
                        endwhile;
                        endforeach;
                        //wp_reset_postdata();
                        ?>
                    </div>
                </div> <!-- .container-inner -->
            </div> <!-- .ct-header-carousel-section -->
        <?php
        endif;
    }
}
add_action('recent_news_post_carousel_customizer', 'recent_news_post_carousel_customizer', 10);


if (!function_exists('refined_magazine_front_page')) :

    function refined_magazine_front_page()
    {

        if (is_active_sidebar('refined-magazine-home-widget-area')) {
            dynamic_sidebar('refined-magazine-home-widget-area');
        }
        global $refined_magazine_theme_options;
        $refined_magazine_front_page_content = $refined_magazine_theme_options['refined-magazine-front-page-content'];

        if (false == $refined_magazine_front_page_content) {
            if ('posts' == get_option('show_on_front')) {
                if (have_posts()) :
                    /* Start the Loop */
                    echo "<div class='recent-news-article-wrapper'>";
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part('template-parts/content', get_post_format());
                    endwhile;
                    echo "</div>";
                    /**
                     * refined_magazine_post_navigation hook
                     * @since Refined Magazine 1.0.0
                     *
                     * @hooked refined_magazine_posts_navigation -  10
                     */
                    do_action('refined_magazine_action_navigation');

                else :
                    get_template_part('template-parts/content', 'none');
                endif;
            } else {
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                endwhile; // End of the loop.
            }
        }
    }

endif;


if (!function_exists('refined_magazine_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function refined_magazine_posted_on()
    {
        global $refined_magazine_theme_options;
        $recent_news_show_date = $refined_magazine_theme_options['refined-magazine-post-published-date'];
        $post_date_class = '';
        if($recent_news_show_date == 'post-updated'){
            $post_date_class = 'ct-show-updated';
        }
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s" ' . refined_magazine_get_microdata('date-published') . '>%2$s</time><time class="updated" datetime="%3$s" ' . refined_magazine_get_microdata('date-modified') . '>%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            '%s',
            '<i class="fa fa-calendar"></i><a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        global $refined_magazine_theme_options;
        if (is_singular()) {
            $show_posted_date = $refined_magazine_theme_options['refined-magazine-enable-single-date'];

        } else {
            $show_posted_date = $refined_magazine_theme_options['refined-magazine-enable-blog-date'];
        }
        if ($show_posted_date == 1) {
            echo '<span class="posted-on '. $post_date_class.'">' . $posted_on . '</span>'; // WPCS: XSS OK.
        }

    }
endif;
