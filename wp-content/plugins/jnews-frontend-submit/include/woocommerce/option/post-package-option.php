<div class="options_group show_if_post_package">
    <?php
        woocommerce_wp_text_input(
            array(
                'id' => '_jeg_post_limit',
                'label' => 'Post limit',
                'description' => 'The number of post a user can submit with this package',
                'value' => ( $limit = get_post_meta( $post_id, '_jeg_post_limit', true ) ) ? $limit : '',
                'placeholder' => 'Unlimited',
                'type' => 'number',
                'desc_tip' => true,
                'custom_attributes' => array(
                    'min'   => '',
                    'step' 	=> '1'
                )
            )
        );
        woocommerce_wp_checkbox(
            array(
                'id' => '_jeg_post_featured',
                'label' => 'Feature package',
                'description' => 'Highlight this post package (please choose only 1 package for featured package)',
                'value' => get_post_meta( $post_id, '_jeg_post_featured', true)
            )
        );
    ?>
    <script type="text/javascript">
        jQuery('.pricing').addClass( 'show_if_post_package' );
    </script>
</div>