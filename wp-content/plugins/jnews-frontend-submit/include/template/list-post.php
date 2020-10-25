<?php 
    $order = isset( $_GET['order'] ) ? $_GET['order'] : 'desc';
    $args  = array(
        'post_type'           => 'post',
        'author__in'          => get_current_user_id(),
        'orderby'             => 'date',
        'order'               => $order,
        'paged'               => $paged,
        'post_status'         => 'any',
        'ignore_sticky_posts' => 1,
    );

    if ( defined( 'JNEWS_VIDEO' ) ) {
    	$args['tax_query'] = array(
		    array(
			    'taxonomy' => 'post_format',
			    'field'    => 'slug',
			    'terms'    => 'post-format-video',
			    'operator' => 'NOT IN',
		    ),
	    );
    }

    $posts = new WP_Query( $args );

    if ( $posts->have_posts() )
    { 
        $posts_per_page = $posts->query_vars['posts_per_page'];
        $total_post     = $posts->found_posts;

        $fpost = $posts_per_page * ( $paged - 1 );
        $lpost = $posts_per_page * $paged;

        $fpost = ( $fpost <= 0 ) ? 1 : $fpost;
        $lpost = ( $lpost > $total_post ) ? $total_post : $lpost;
        ?>

        <div class="jeg_account_posts">
            <div class="jeg_post_list_meta row clearfix">
                <div class="jeg_post_list_filter col-md-6">
                    <input type="hidden" name="current-page-url" value="<?php echo esc_url( home_url( '/' . $endpoint['account']['slug'] . '/' . $endpoint['my_post']['slug'] ) ); ?>">
                    <select name="post-list-filter">
                        <option <?php echo ( $order === 'desc' ) ? esc_attr( 'selected' ) : ''; ?> value="desc"><?php echo esc_html__( 'Sort by latest', 'jnews-frontend-submit' ) ?></option>
                        <option <?php echo ( $order === 'asc' ) ? esc_attr( 'selected' ) : ''; ?> value="asc"><?php echo esc_html__( 'Sort by older', 'jnews-frontend-submit' ) ?></option>
                    </select>
                </div>
                <div class="jeg_post_list_count col-md-6">
                    <span><?php echo sprintf( esc_html__('Showing %s-%s of %s post results', 'jnews-frontend-submit'), $fpost, $lpost, $total_post ) ?></span>
                </div>
            </div>
        <?php

        while ( $posts->have_posts() ) :
            $posts->the_post();

            $post_id     = get_the_ID();
            $post_status = get_post_status_object( get_post_status( $post_id ))->label;

            do_action('jnews_json_archive_push', $post_id);
        ?>
            <article <?php post_class('jeg_post jeg_pl_sm'); ?>>
                <div class="jeg_thumb">
                    <a href="<?php the_permalink(); ?>"><?php echo apply_filters('jnews_image_thumbnail', $post_id, "jnews-120x86");?></a>
                </div>
                <div class="jeg_postblock_content">
                    <h3 class="jeg_post_title">
                    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="jeg_post_meta">
                        <div class="jeg_post_status <?php echo esc_attr($post_status) ?>"><?php echo esc_html($post_status); ?></div><span>–</span>
                        <div class="jeg_meta_date"><a href="<?php the_permalink(); ?>"><?php echo esc_html( jeg_get_post_date() ); ?></a></div>
                    </div>
                    <div class="jeg_post_control">
                        <a class="jeg_post_action edit" href="<?php echo home_url( '/' . $this->endpoint['editor']['slug'] . '/' . $post_id ); ?>"><?php esc_html_e( 'Edit Post', 'jnews-frontend-submit' ); ?></a> |
                        <a class="jeg_post_action edit" href="<?php the_permalink() ?>"><?php esc_html_e( 'View Post', 'jnews-frontend-submit' ); ?></a>
                    </div>
                </div>
            </article>
        <?php
        endwhile;

        ?>
        </div>
        
        <?php

        // pagination
        echo jnews_paging_navigation(
            array(
                'pagination_mode'      => 'nav_3',
                'pagination_align'     => 'left',
                'pagination_navtext'   => false,
                'pagination_pageinfo'  => true,
        		'current' 			   => $paged,
                'total'                => $posts->max_num_pages,
            )
        );

    } else {
        $no_content = "<div class='jeg_empty_module'>" . jnews_return_translation('No Content Available','jnews', 'no_content_available') . "</div>";
        echo apply_filters('jnews_module_no_content', $no_content);
    }

    wp_reset_postdata();
?>	            