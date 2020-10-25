<?php

use JNEWS_VIDEO\Objects\Playlist;
use JNEWS_VIDEO\Playlist\Single_Playlist;

$single   = Single_Playlist::getInstance();
$playlist = Playlist::get_instance();
get_header();
?>
<div class="post-wrapper single-playlist">

	<div class="post-wrap">

		<?php do_action( 'jnews_single_post_begin', $wp_query->post->ID ); ?>

		<div class="jeg_main <?php $single->main_class(); ?> <?php $single->template_class(); ?>">
			<div class="jeg_container">
				<div class="jeg_content jeg_singlepage">
					<div class="container">

						<div class="jeg_ad jeg_article jnews_article_top_ads">
							<?php do_action( 'jnews_article_top_ads' ); ?>
						</div>

						<div class="row">
							<?php
							if ( $playlist->is_default_content() ) {
								jnews_video_get_template_part( '/fragment/playlist/playlist', 'content' );
							} else {
								if ( have_posts() ) :
									the_post();
									jnews_video_get_template_part( '/fragment/playlist/playlist', 'content' );
								endif;
							}
							?>
						</div>

						<div class="jeg_ad jeg_article jnews_article_bottom_ads">
							<?php do_action( 'jnews_article_bottom_ads' ); ?>
						</div>

					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'jnews_single_post_end', $wp_query->post->ID ); ?>

	</div>

	<?php get_template_part( 'fragment/post/post-overlay' ); ?>

</div>
<?php get_footer(); ?>
