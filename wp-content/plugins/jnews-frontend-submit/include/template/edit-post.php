<?php
    get_header();

    $template   = JNews_Frontend_Template::getInstance();
    $post_id    = $template->get_post_id();
    $categories = $template->get_category();
    $instance   = new JNews_Frontend_Post( $post_id );
    $post       = $instance->post_data();
?>

<div class="jeg_main jeg_post_editor">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jeg_section">
                <div class="container">
                    <div class="jeg_archive_header">
                        <h1 class='jeg_archive_title'><?php esc_html_e( 'Edit Post', 'jnews-frontend-submit' ) ?></h1>
                        <hr>
                        <?php echo apply_filters( 'jnews_get_message', '' ); ?>
                    </div>
                    <div class="jeg_cat_content">
                        <form method="post" action="">

                            <div class="row clearfix">
                                <div class="col-md-8">
                                    <!-- post title -->
                                    <div class="title-field form-group">
                                        <input id="title" name="title" placeholder="<?php esc_attr_e('Enter title here', 'jnews-frontend-submit'); ?>"  type="text" class="form-control" value="<?php echo isset($post['title']) ? $post['title'] : ''; ?>">
                                    </div>

                                    <!-- post subtitle -->
                                    <div class="subtitle-field form-group">
                                        <input id="subtitle" name="subtitle" placeholder="<?php esc_attr_e('Enter subtitle here', 'jnews-frontend-submit'); ?>"  type="text" class="form-control" value="<?php echo isset($post['subtitle']) ? $post['subtitle'] : ''; ?>">
                                    </div>

                                    <!-- post content -->
                                    <div class="content-field form-group">
                                        <label for="content"><?php esc_html_e('Post Content', 'jnews-frontend-submit'); ?></label>
                                        <br>
                                        <?php

                                        echo apply_filters( 'jnews_frontend_submit_enable_add_media_msg', '' );

                                        $wp_editor_args = array(
                                            'textarea_name'     => 'content',
                                            'drag_drop_upload'  => false,
                                            'media_buttons'     => get_theme_mod('jnews_frontend_submit_enable_add_media', true),
                                            'textarea_rows'     => 25,
                                            'teeny'             => true,
                                            'quicktags'         => false,
                                            'wpautop'           => true 
                                        );

                                        wp_editor( $post['content'], 'content', apply_filters( 'jnews_frontend_submit_wp_editor_args', $wp_editor_args ) );
                                        ?>
                                    </div>


                                </div>

                                <div class="col-md-4 jeg_sidebar jeg_sticky_sidebar">
                                    <!-- post format -->
                                    <div class="format-field form-group">
                                        <ul class="jeg-tablist format-nav">
                                            <li>
                                                <a data-type="image" href="#" class="<?php echo ( $post['format'] == 'image' ) ? 'active' : ''; ?>"><?php esc_html_e( 'Standard', 'jnews-frontend-submit' ); ?></a>
                                            </li>
                                            <li>
                                                <a data-type="gallery" href="#" class="<?php echo ( $post['format'] == 'gallery' ) ? 'active' : ''; ?>"><?php esc_html_e( 'Gallery', 'jnews-frontend-submit' ); ?></a>
                                            </li>
                                            <li>
                                                <a data-type="video" href="#" class="<?php echo ( $post['format'] == 'video' ) ? 'active' : ''; ?>"><?php esc_html_e( 'Video', 'jnews-frontend-submit' ); ?></a>
                                            </li>
                                        </ul>
                                        <div class="form-input-wrapper">
                                            <!-- post format -->
                                            <input type="hidden" name="format" value="<?php echo isset( $post['format'] ) ? esc_attr( $post['format'] ) : 'image'; ?>">

                                            <!-- image format -->
                                            <?php
                                            jeg_locate_template( locate_template('fragment/upload/upload-form.php', false, false), true, array(
                                                'id' 		=> 'featured_image',
                                                'class'		=> $post['format'] == 'image' ? 'active' : '',
                                                'name' 		=> 'image',
                                                'source' 	=> isset($post['image']) ? array( $post['image'] ) : null,
                                                'button' 	=> 'btn-single-image',
                                                'multi' 	=> false,
                                                'maxsize' 	=> '2mb'
                                            ));
                                            ?>

                                            <!-- video format -->
                                            <input id="video" name="video" placeholder="<?php esc_attr_e( 'Insert video url or embed code', 'jnews-frontend-submit' ); ?>"  type="text" class="form-control <?php echo ( $post['format'] == 'video' ) ? 'active' : ''; ?>" value="<?php echo isset($post['video']) ? $post['video'] : ''; ?>">

                                            <!-- gallery format -->
                                            <?php
                                            jeg_locate_template( locate_template('fragment/upload/upload-form.php', false, false), true, array(
                                                'id' 		=> 'featured_image_gallery',
                                                'class'		=> $post['format'] == 'gallery' ? 'active' : '',
                                                'name' 		=> 'gallery',
                                                'source' 	=> isset($post['gallery']) ? $post['gallery'] : null,
                                                'button' 	=> 'btn-multi-image',
                                                'multi' 	=> true,
                                                'maxsize' 	=> '2mb',
                                                'maxcount' 	=> apply_filters( 'jnews_maxcount_upload_featured_gallery', 8 )
                                            ));
                                            ?>
                                        </div>
                                    </div>

                                    <!-- post category -->
                                    <div class="category-field form-group">
                                        <label for="category"><?php esc_html_e('Categories', 'jnews-frontend-submit'); ?></label>

                                        <?php
                                            $data       = array();
                                            $value      = isset($post['category']) ? $post['category'] : '';
                                            $ajax_class = '';

                                            if ( empty( $categories ) )
                                            {
                                                $values = explode(',', $value);
                                                $ajax_class = 'jeg-ajax-load';

                                                foreach( $values as $val )
                                                {
                                                    if ( ! empty( $val ) )
                                                    {
                                                        $term = get_term( $val, 'category' );
                                                        $data[] = array(
                                                            'value' => $val,
                                                            'text'  => $term->name
                                                        );
                                                    }
                                                }
                                            } else {
                                                foreach( $categories as $key => $label )
                                                {
                                                    $data[] = array(
                                                        'value' => $key,
                                                        'text'  => $label,
                                                    );
                                                }
                                            }

                                            $data = wp_json_encode($data);
                                        ?>

                                        <input name="category" placeholder="<?php esc_attr_e('Choose categories', 'jnews-frontend-submit'); ?>"  type="text" class="multicategory-field form-control <?php esc_attr_e($ajax_class); ?>" value="<?php esc_attr_e($value); ?>">
                                        <div class="data-option" style="display: none;">
                                            <?php echo esc_html($data); ?>
                                        </div>
                                    </div>

                                    <!-- post primary category -->
                                    <div class="primary-category-field form-group">
                                        <label for="primary-category"><?php esc_html_e('Primary Category', 'jnews-frontend-submit'); ?></label>

	                                    <?php
                                            $data       = array();
                                            $value      = isset($post['primary-category']) ? $post['primary-category'] : '';
                                            $ajax_class = '';

                                            if ( empty( $categories ) )
                                            {
                                                $values = explode(',', $value);
                                                $ajax_class = 'jeg-ajax-load';

                                                foreach( $values as $val )
                                                {
                                                    if ( ! empty( $val ) )
                                                    {
                                                        $term = get_term( $val, 'category' );
                                                        $data[] = array(
                                                            'value' => $val,
                                                            'text'  => $term->name
                                                        );
                                                    }
                                                }
                                            } else {
                                                foreach( $categories as $key => $label )
                                                {
                                                    $data[] = array(
                                                        'value' => $key,
                                                        'text'  => $label,
                                                    );
                                                }
                                            }

                                            $data = wp_json_encode($data);
	                                    ?>

                                        <input name="primary-category" placeholder="<?php esc_attr_e('Choose a primary category', 'jnews-frontend-submit'); ?>"  type="text" class="singlecategory-field form-control <?php esc_attr_e($ajax_class); ?>" value="<?php esc_attr_e($value); ?>">
                                        <div class="data-option" style="display: none;">
		                                    <?php echo esc_html($data); ?>
                                        </div>
                                    </div>

                                    <!-- post tag -->
                                    <div class="tags-field form-group">
                                        <label for="tags"><?php esc_html_e('Tags', 'jnews-frontend-submit'); ?></label>

                                        <?php
                                            $data       = array();
                                            $tag        = $template->get_tag();
                                            $value      = isset($post['tag']) ? $post['tag'] : '';
                                            $ajax_class = '';

                                            if ( empty( $categories ) )
                                            {
                                                $values = explode(',', $value);
                                                $ajax_class = 'jeg-ajax-load';

                                                foreach( $values as $val )
                                                {
                                                    if ( ! empty( $val ) )
                                                    {
                                                        $term = get_term( $val, 'post_tag' );
                                                        $data[] = array(
                                                            'value' => $val,
                                                            'text'  => $term->name
                                                        );
                                                    }
                                                }
                                            } else {
                                                foreach( $tag as $key => $label )
                                                {
                                                    $data[] = array(
                                                        'value' => $key,
                                                        'text'  => $label,
                                                    );
                                                }
                                            }

                                            $data = wp_json_encode($data);
                                        ?>
                                        <input name="tag" placeholder="<?php esc_attr_e('Choose tags', 'jnews-frontend-submit'); ?>"  type="text" class="multitag-field form-control <?php echo esc_attr( $ajax_class ); ?>" value="<?php esc_attr_e($value); ?>">
                                        <div class="data-option" style="display: none;">
		                                    <?php echo esc_html($data); ?>
                                        </div>
                                    </div>

                                    <!-- submit button -->
                                    <div class="submit-field form-group">

                                        <?php if ( ! apply_filters( 'jnews_disable_frontend_update_post', false ) ): ?>
                                            <input type="hidden" name="jnews-action" value="edit-post" />
                                            <input type="hidden" name="post-id" value="<?php echo esc_attr( $post['id'] ); ?>" />
                                            <input type="hidden" name="jnews-editor-nonce" value="<?php echo esc_attr( wp_create_nonce('jnews-editor') ); ?>"/>
                                            <input type="submit" value="<?php esc_attr_e('Update Post', 'jnews-frontend-submit'); ?>"/>
                                        <?php else: ?>
                                            <?php echo apply_filters( 'jnews_disable_frontend_update_post_msg', '' ); ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action('jnews_after_main'); ?>
    </div>
</div>

<?php get_footer(); ?>
