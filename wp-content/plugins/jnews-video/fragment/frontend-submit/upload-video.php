<?php

use JNEWS_VIDEO\Frontend\Frontend_Video_Details;
use JNEWS_VIDEO\Frontend\Frontend_Video_Endpoint;

get_header();
$video_page_title  = esc_html( 'Upload New Video', 'jnews-video' );
$video_submit_text = esc_attr( 'Submit Video', 'jnews-video' );
$template          = Frontend_Video_Endpoint::getInstance();
$categories        = $template->get_category();
$post_tags         = $template->get_tag();
$template_page     = 'upload-video';
if ( $template->is_edit_page() ) {
	$video_page_title  = esc_html( 'Edit Video', 'jnews-video' );
	$video_submit_text = esc_attr( 'Edit Video', 'jnews-video' );
	$template_page     = 'edit-video';
	$post_id           = $template->get_post_id();
	$instance          = new Frontend_Video_Details( $post_id );
	$post_data         = $instance->post_data();
}
?>

<div class="jeg_main jeg_post_editor">
	<div class="jeg_container">
		<div class="jeg_content">
			<div class="jeg_section">
				<div class="container">
					<div class="jeg_archive_header">
						<h1 class='jeg_archive_title'><?php echo $video_page_title; ?></h1>
						<?php echo apply_filters( 'jnews_get_message', '' ); ?>
					</div>
					<div class="jeg_cat_content">
						<form method="post" action="">
							<!-- video format -->
							<div class="video-format-field form-group">
								<ul class="jeg-tablist video-format-nav">
									<li>
										<a data-type="embed-video"
										   href="#"
										   class="active"><?php esc_html_e( 'Embed Video', 'jnews-video' ); ?></a>
									</li>
									<li>
										<a data-type="video"
										   href="#"><?php esc_html_e( 'Browse File', 'jnews-video' ); ?></a>
									</li>
								</ul>
								<div class="form-input-wrapper">
									<!-- video format -->
									<input type="hidden" name="video-format" value="embed-video">

									<div class="form-video-format">
										<!-- video format -->
										<div class="choose-video">
											<?php
											jeg_locate_template(
												jnews_video_get_template_path( 'fragment/frontend-submit/upload-form.php', false, false ),
												true,
												array(
													'id'   => 'choose-video',
													'class' => '',
													'name' => 'video',
													'source' => null,
													'button' => 'btn-single-video',
													'multi' => false,
													'maxsize' => apply_filters( 'jnews_maxsize_upload_featured_image', '2mb' ),
													'type' => array( 'video' ),
												)
											);
											?>
										</div>

										<!-- embed video format -->
										<input id="embed-video" name="embed-video"
											   placeholder="<?php esc_attr_e( 'Insert video url or embed code', 'jnews-video' ); ?>"
											   type="text" class="form-control active"
											   value="<?php echo isset( $post_data['video'] ) ? $post_data['video'] : ''; ?>">
									</div>
									<a href="#" class="jeg_fetch_button button" data-action="embed-video"
									   data-nonce="<?php echo esc_attr( wp_create_nonce( 'jnews-video-frontend-nonce' ) ); ?>"><?php esc_attr_e( 'Embed Video', 'jnews-video' ); ?></a>
									<div class="jeg_embed_info">
										<p class="jeg_url_example">
											<span><?php esc_html_e( 'e.g.: https://www.youtube.com/watch?v=SAID1iaq0KI', 'jnews-video' ); ?></span>
										</p>
										<p class="jeg_supported_provider">
											<span><?php esc_html_e( 'Supported Video:', 'jnews-video' ); ?></span>
											<span class="jeg_supported_provider_list">
												<span><i class="fa fa-youtube-play"></i></span>
												<span><i class="fa fa-vimeo-square"></i></span>
												<span><i class="fa fa-file"></i></span>
											</span>
										</p>
									</div>
								</div>
							</div>
							<div class="video-field form-group has-video">
								<div class="jeg_video_section">
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-md-8">
									<!-- post title -->
									<div class="title-field form-group">
										<input id="title" name="title"
											   placeholder="<?php esc_attr_e( 'Enter title here', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['title'] ) ? $post_data['title'] : ''; ?>">
									</div>

									<!-- post subtitle -->
									<div class="subtitle-field form-group">
										<input id="subtitle" name="subtitle"
											   placeholder="<?php esc_attr_e( 'Enter subtitle here', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['subtitle'] ) ? $post_data['subtitle'] : ''; ?>">
									</div>

									<!-- post content -->
									<div class="content-field form-group">
										<label
											for="content"><?php esc_html_e( 'Post Content', 'jnews-video' ); ?></label>
										<br>
										<?php

										echo apply_filters( 'jnews_frontend_submit_enable_add_media_msg', '' );

										wp_editor(
											isset( $post_data['content'] ) ? $post_data['content'] : '',
											'content',
											array(
												'textarea_name' => 'content',
												'drag_drop_upload' => false,
												'media_buttons' => get_theme_mod( 'jnews_frontend_submit_enable_add_media', true ),
												'textarea_rows' => 25,
												'teeny' => true,
												'quicktags' => false,
											)
										);
										?>
									</div>

									<!-- Source -->
									<div class="source-field form-group">
										<label for="source_name"><?php esc_html_e( 'Source', 'jnews-video' ); ?></label>
										<input name="source_name"
											   placeholder="<?php esc_html_e( 'Source name', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['source_name'] ) ? $post_data['source_name'] : ''; ?>">
										<input name="source_url"
											   placeholder="<?php esc_html_e( 'Insert source url link', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['source_url'] ) ? $post_data['source_url'] : ''; ?>">
									</div>

									<!-- Via -->
									<div class="via-field form-group">
										<label for="via_name"><?php esc_html_e( 'Via', 'jnews-video' ); ?></label>
										<input name="via_name"
											   placeholder="<?php esc_html_e( 'Via name', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['via_name'] ) ? $post_data['via_name'] : ''; ?>">
										<input name="via_url"
											   placeholder="<?php esc_html_e( 'Insert via url link', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['via_url'] ) ? $post_data['via_url'] : ''; ?>">
									</div>

								</div>

								<div class="col-md-4 jeg_sidebar jeg_sticky_sidebar">

									<!-- image format -->
									<div class="image-format-field form-group">
										<label
											for="image-format"><?php esc_html_e( 'Featured Image', 'jnews-video' ); ?></label>
										<ul class="jeg-tablist image-format-nav">
											<li>
												<a data-type="image" href="#"
												   class="active"><?php esc_html_e( 'Browse File', 'jnews-video' ); ?></a>
											</li>
											<li>
												<a data-type="image-url"
												   href="#"><?php esc_html_e( 'Get From URL', 'jnews-video' ); ?></a>
											</li>
										</ul>
										<div class="form-input-wrapper">
											<!-- image format -->
											<input type="hidden" name="image-format" value="image">

											<!-- image format -->
											<?php
											jeg_locate_template(
												locate_template( 'fragment/upload/upload-form.php', false, false ),
												true,
												array(
													'id'   => 'featured-image',
													'class' => 'active',
													'name' => 'image',
													'source' => isset( $post_data['image'] ) ? array( $post_data['image'] ) : null,
													'button' => 'btn-single-image',
													'multi' => false,
													'maxsize' => apply_filters( 'jnews_maxsize_upload_featured_image', '2mb' ),
													'type' => array( 'image' ),
												)
											);
											?>

											<!-- image url format -->
											<div class="jeg_insert_url_wrapper">
												<div class="preview-image">
													<img class="image-url-preview"
														 src="<?php echo get_parent_theme_file_uri( 'assets/img/jeg-empty.png' ); ?>">
													<div class='remove'></div>
												</div>
												<input id="image_url" name="image-url"
													   placeholder="<?php esc_attr_e( 'Insert image url', 'jnews-video' ); ?>"
													   type="text" class="form-control" value="">
											</div>
										</div>
									</div>

									<!-- video preview format -->
									<div class="video-preview-format-field form-group">
										<label
											for="video-preview-format"><?php esc_html_e( '3 Second Video Preview', 'jnews-video' ); ?></label>
										<ul class="jeg-tablist video-preview-format-nav">
											<li>
												<a data-type="video-preview" href="#"
												   class="active"><?php esc_html_e( 'Browse File', 'jnews-video' ); ?></a>
											</li>
											<li>
												<a data-type="video-preview-url"
												   href="#"><?php esc_html_e( 'Get From URL', 'jnews-video' ); ?></a>
											</li>
										</ul>
										<div class="form-input-wrapper">
											<!-- video preview format -->
											<input type="hidden" name="video-preview-format" value="video-preview">

											<!-- video preview format -->
											<?php
											jeg_locate_template(
												locate_template( 'fragment/upload/upload-form.php', false, false ),
												true,
												array(
													'id'   => 'video-preview',
													'class' => 'active',
													'name' => 'video-preview',
													'source' => isset( $post_data['video_preview'] ) ? array( $post_data['video_preview'] ) : null,
													'button' => 'btn-single-video-preview',
													'multi' => false,
													'maxsize' => apply_filters( 'jnews_maxsize_upload_featured_image', '2mb' ),
													'type' => array( 'image/webp' ),
													'wrapper' => 'upload_image_preview_container',
												)
											);
											?>

											<!-- image url format -->
											<div class="jeg_insert_url_wrapper">
												<div class="preview-video-preview">
													<img class="video-preview-url-preview"
														 src="<?php echo get_parent_theme_file_uri( 'assets/img/jeg-empty.png' ); ?>">
													<div class='remove'></div>
												</div>
												<input id="video-preview-url" name="video-preview-url"
													   placeholder="<?php esc_attr_e( 'Insert image url', 'jnews-video' ); ?>"
													   type="text" class="form-control" value="">
											</div>
										</div>
									</div>

									<!-- video duration -->
									<div class="duration-field form-group">
										<label for="duration"><?php esc_html_e( 'Duration', 'jnews-video' ); ?></label>
										<input name="duration"
											   placeholder="<?php esc_html_e( 'Human-read time value, ex. mm:ss.', 'jnews-video' ); ?>"
											   type="text" class="form-control"
											   value="<?php echo isset( $post_data['duration'] ) ? $post_data['duration'] : ''; ?>">
									</div>

									<!-- post category -->
									<div class="category-field form-group">
										<label
											for="category"><?php esc_html_e( 'Categories', 'jnews-video' ); ?></label>

										<?php
										$data       = array();
										$ajax_class = '';

										if ( empty( $categories ) ) {
											$ajax_class = 'jeg-ajax-load';
										} else {
											foreach ( $categories as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<?php
										$data       = array();
										$value      = isset( $post_data['category'] ) ? $post_data['category'] : '';
										$ajax_class = '';

										if ( empty( $categories ) ) {
											$ajax_class = 'jeg-ajax-load';
											if ( ! empty( $value ) ) {
												$values = explode( ',', $value );
												foreach ( $values as $val ) {
													if ( ! empty( $val ) ) {
														$term   = get_term( $val, 'category' );
														$data[] = array(
															'value' => $val,
															'text'  => $term->name,
														);
													}
												}
											}
										} else {
											foreach ( $categories as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<input name="category"
											   placeholder="<?php esc_attr_e( 'Type a category', 'jnews-video' ); ?>"
											   type="text"
											   class="multicategory-field form-control <?php esc_attr_e( $ajax_class ); ?>"
											   value="<?php esc_attr_e( $value ); ?>">
										<div class="data-option" style="display: none;">
											<?php echo esc_html( $data ); ?>
										</div>
									</div>

									<!-- post primary category -->
									<div class="primary-category-field form-group">
										<label
											for="primary-category"><?php esc_html_e( 'Primary Category', 'jnews-video' ); ?></label>

										<?php
										$data       = array();
										$ajax_class = '';

										if ( empty( $categories ) ) {
											$ajax_class = 'jeg-ajax-load';
										} else {
											foreach ( $categories as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<?php
										$data       = array();
										$value      = isset( $post_data['primary-category'] ) ? $post_data['primary-category'] : '';
										$ajax_class = '';

										if ( empty( $categories ) ) {
											$ajax_class = 'jeg-ajax-load';
											if ( ! empty( $value ) ) {
												$values = explode( ',', $value );
												foreach ( $values as $val ) {
													if ( ! empty( $val ) ) {
														$term   = get_term( $val, 'category' );
														$data[] = array(
															'value' => $val,
															'text'  => $term->name,
														);
													}
												}
											}
										} else {
											foreach ( $categories as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<input name="primary-category"
											   placeholder="<?php esc_attr_e( 'Choose primary category', 'jnews-video' ); ?>"
											   type="text"
											   class="singlecategory-field form-control <?php esc_attr_e( $ajax_class ); ?>"
											   value="<?php esc_attr_e( $value ); ?>">
										<div class="data-option" style="display: none;">
											<?php echo esc_html( $data ); ?>
										</div>
									</div>

									<!-- post tag -->
									<div class="tags-field form-group">
										<label for="tags"><?php esc_html_e( 'Tags', 'jnews-video' ); ?></label>

										<?php
										$data       = array();
										$ajax_class = '';

										if ( empty( $post_tags ) ) {
											$ajax_class = 'jeg-ajax-load';
										} else {
											foreach ( $post_tags as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<?php
										$data       = array();
										$value      = isset( $post_data['tag'] ) ? $post_data['tag'] : '';
										$ajax_class = '';

										if ( empty( $post_tags ) ) {
											$ajax_class = 'jeg-ajax-load';
											if ( ! empty( $value ) ) {
												$values = explode( ',', $value );
												foreach ( $values as $val ) {
													if ( ! empty( $val ) ) {
														$term   = get_term( $val, 'post_tag' );
														$data[] = array(
															'value' => $val,
															'text'  => $term->name,
														);
													}
												}
											}
										} else {
											foreach ( $post_tags as $key => $label ) {
												$data[] = array(
													'value' => $key,
													'text' => $label,
												);
											}
										}

										$data = wp_json_encode( $data );
										?>

										<input name="tag"
											   placeholder="<?php esc_attr_e( 'Type a tag', 'jnews-video' ); ?>"
											   type="text"
											   class="multitag-field form-control <?php esc_attr_e( $ajax_class ); ?>"
											   value="<?php esc_attr_e( $value ); ?>">
										<div class="data-option" style="display: none;">
											<?php echo esc_html( $data ); ?>
										</div>
									</div>

									<!-- submit button -->
									<div class="submit-field form-group">

										<?php if ( ! apply_filters( 'jnews_disable_frontend_submit_post', false ) ) : ?>
											<?php if ( $template->is_edit_page() ) : ?>
												<input type="hidden" name="post-id"
													   value="<?php echo esc_attr( $post_data['id'] ); ?>"/>
											<?php endif ?>
											<input type="hidden" name="jnews-action"
												   value="<?php echo esc_attr( $template_page ); ?>"/>
											<input type="hidden" name="jnews-editor-nonce"
												   value="<?php echo esc_attr( wp_create_nonce( 'jnews-editor' ) ); ?>"/>
											<input type="submit"
												   value="<?php echo $video_submit_text; ?>"/>
										<?php else : ?>
											<?php echo apply_filters( 'jnews_disable_frontend_submit_post_msg', '' ); ?>
										<?php endif ?>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php do_action( 'jnews_after_main' ); ?>
	</div>
</div>

<?php get_footer(); ?>
