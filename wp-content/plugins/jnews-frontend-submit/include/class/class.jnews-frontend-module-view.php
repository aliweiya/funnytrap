<?php
/**
 * @author : Jegtheme
 */

Class JNews_Element_Post_Package_View extends \JNews\Module\ModuleViewAbstract
{
	public function render_module($attr, $column_class)
	{
		if ( ! class_exists( 'WooCommerce' ) ) return false;

		$output = $wrapper_class = '';

		$attr['button_package'] = empty( $attr['button_package'] ) ? esc_html__( 'Buy Package', 'jnews-frontend-submit' ) : $attr['button_package'];
		$redirect_checkout      = apply_filters('jnews_frontend_package_redirect_checkout', 1 );

		if ( $attr['list_package'] )
		{
			$items = explode( ',', $attr['list_package'] );

			if ( count($items) <= 5 )
			{
				$wrapper_class = 'col_'. count($items);
			}
			else
			{
				$wrapper_class = 'col_'. apply_filters('jnews_frontend_package_default_column', 1 );
			}

			foreach ( $items as $item )
			{
				$product = wc_get_product( $item );

				if ( $product )
				{
					$featured = $product->is_featured_package() ? 'featured' : '';
					$limit = $product->get_listing_limit() >= 99999999 ? esc_html__('Unlimited', 'jnews-frontend-submit') : $product->get_listing_limit();
					$output  .=
						"<div class='package-item {$featured}'>
                            <div class='package-title'>
                                <h3>" . $product->get_title() . "</h3>
                            </div>
                            <div class='package-price'>
                                <span class='price'>" . $product->get_price_html() . "</span>
                            </div>
                            <div class='package-list'>
                                <ul>
                                    <li>
                                        <strong>" . esc_html( $limit ) . "</strong>
                                        <span>" . esc_html__('post submission', 'jnews-frontend-submit') . "</span>
                                    </li>
                                    <li>
                                        <span>". esc_html__('No expiration date', 'jnews-frontend-submit') . "</span>
                                    </li>
                                    <li>
                                        <span>". esc_html__('Update your post', 'jnews-frontend-submit') . "</span>
                                    </li>
                                </ul>
                            </div>
                            <div class='package-button'>
                                <form method=\"POST\">
                                    <input type=\"hidden\" name=\"redirect_checkout\" value=" . esc_attr( $redirect_checkout ) . ">
                                    <input type=\"hidden\" name=\"package_id\" value=" . esc_attr( $item ) . ">
                                    <input type=\"hidden\" name=\"jeg_action\" value=\"add-post-package\">
                                    <input type=\"hidden\" name=\"jnews-frontend-package-nonce\" value=\"" . esc_attr( wp_create_nonce('jnews-frontend-package-nonce') ) . "\">
                                    <input type=\"submit\" class=\"button\" value=\"" . $attr['button_package'] . "\">
                                </form>
                            </div>
                        </div>";
				}
			}
		} else {
			$no_content = "<div class='jeg_empty_module'>" . jnews_return_translation('No Content Available','jnews', 'no_content_available') . "</div>";
			$output     = apply_filters('jnews_module_no_content', $no_content);
		}

		wp_reset_postdata();

		$message = apply_filters( 'jnews_get_message', '' );
		$output  = $message . $output;

		return "<div class=\" jeg-post-package {$wrapper_class} clearfix\">{$output}</div>";
	}
}