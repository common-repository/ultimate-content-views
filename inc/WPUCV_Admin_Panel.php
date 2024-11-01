<?php
if( ! class_exists( 'WPUCV_Admin_Panel' ) ) {

class WPUCV_Admin_Panel{

	private static $validation_rules = array();
	private static $fields_values = array();
	private static $fields_relations = array();


	/**
	 * Register meta boxes for list post type
	 *
	 * @uses add_meta_box()
	 * @uses remove_meta_box()
	 * @return void
	 */
	public static function register_meta_boxes() {
		remove_meta_box('submitdiv', NULL, 'side');
		remove_meta_box('slugdiv', NULL, 'normal');

		add_meta_box( 'starter_box', esc_html__( 'Loading...', 'ultimate-content-views' ), array(__CLASS__, 'build_starter_box'), 'wpucv_list', 'normal', 'high' );
	}

	/**
	 * Render the starter meta boxes
	 *
	 * @uses get_current_screen()
	 * @return void
	 */
	public static function build_starter_box( $post ) {
		$screen = get_current_screen();
		$new_post = ( $screen->action == 'add' );
		?>
		<div class="loading" id="loading_spiner">&#8230;</div>
		<input type="hidden" id="wpucv_post_id" value="<?php echo esc_attr($post->ID); ?>">
		<input type="hidden" id="wpucv_new_post" value="<?php echo ( esc_attr($new_post) )? '1' : '0'; ?>">

		<script>
			jQuery(function(){
				"use strict";
				wpucv_list_edit_page();
			});
		</script>
		<?php
	}

	public static function list_edit_page() {
		$post_id = ( array_key_exists( 'post_id', $_POST ) )? wpucv_sanitizing($_POST['post_id'],'int') : NULL;
		$new_post = ( array_key_exists( 'new_post', $_POST ) && '1' == wpucv_sanitizing($_POST['new_post'], 'int') );

		if( empty( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id, OBJECT );
		?>
		<div class="loading hidden" id="loading_spiner">&#8230;</div>
		<input type="hidden" id="wpucv_post_id" value="<?php echo esc_attr($post_id); ?>">
		<input type="hidden" id="wpucv_new_post" value="<?php echo (esc_attr($new_post))? '1' : '0'; ?>">

		<div class="wpucv">
			<div class="wpucv-modal-overly hidden" id="wpucv_modal_overly"></div>
			<div class="wpucv-modal-wrapper hidden" id="wpucv_preview_modal">
				<div class="wpucv-modal clearfix">
					<div class="wpucv-modal-header clearfix">
						<a class="wpucv-modal-close" id="wpucv_preview_modal_close" href="javascript:void(0);"><i class="fa fa-angle-double-down"></i></a>

						<div class="wpucv-preview-screen-sizes">
							<a href="javascript:void(0);" id="wpucv_mobile_screen" class="wpucv-hidden-xs"><img src="<?php echo esc_url(plugins_url( 'images/mobile.png', WPUCV_MAIN_FILE )); ?>"></a>
							<a href="javascript:void(0);" id="wpucv_tablet_screen" class="wpucv-hidden-xs"><img src="<?php echo esc_url(plugins_url( 'images/tablet.png', WPUCV_MAIN_FILE )); ?>"></a>
							<a href="javascript:void(0);" id="wpucv_labtop_screen" class="wpucv-hidden-xs wpucv-hidden-sm"><img src="<?php echo esc_url(plugins_url( 'images/labtop.png', WPUCV_MAIN_FILE )); ?>"></a>
							<a href="javascript:void(0);" id="wpucv_desktop_screen" class="wpucv-hidden-xs wpucv-hidden-sm wpucv-hidden-md"><img src="<?php echo esc_url(plugins_url( 'images/desktop.png', WPUCV_MAIN_FILE )); ?>"></a>
						</div>
					</div>
					<div class="wpucv-modal-body clearfix" id="wpucv_preview_modal_body">
						<iframe marginwidth="auto" id="iframe_dummy_preview"></iframe>
						<iframe class="hidden" marginwidth="auto" id="iframe_real_preview"></iframe>
					</div>
					<header class="bootstrap-wrapper">
						<button type="button" class="btn btn-primary" id="wpucv_for_dummy_preview"><?php echo esc_html__(  'Dummy Data', 'ultimate-content-views' ); ?></button>
						<button type="button" class="btn btn-primary" id="wpucv_for_real_preview"><?php echo esc_html__(  'Real Data', 'ultimate-content-views' ); ?></button>

						<div class="alert alert-warning" role="alert"><?php echo esc_html__(  'Note, In case of having content before activating this plugin, you need to regenerate your thumbnails. We recommend you to use the Regenerate Thumbnails plugin', 'ultimate-content-views' ); ?> <a target="_blank" href="https://wordpress.org/plugins/regenerate-thumbnails/"><?php echo esc_html__('[Download it]', 'ultimate-content-views')?></a></div>
					</header>
				</div>
			</div>
		</div>

		<div class="bootstrap-wrapper meta-box-wrapper">
			<div class="row">
				<div class="col-xs-12">
				<?php static::build_general_options_box( $post, $new_post ); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
				<?php static::build_list_structure_box( $post, $new_post ); ?>

				<?php static::build_exclusion_options_box( $post, $new_post ); ?>

				<center>
				<br /><br />
				<a href="https://www.wp-buy.com/product/advanced-content-viewer/" target="_blank">
				<img title="<?php echo esc_html__(  'UPGRADE To PRO Version NOW', 'ultimate-content-views' ); ?>" src="<?php echo esc_url(plugins_url( 'images/upgradenow.png', WPUCV_MAIN_FILE )); ?>" />
				</a>
				</button>
				</center>



				</div>

				<div class="col-md-6">
				<?php static::build_pagination_box( $post, $new_post ); ?>

				<?php static::build_searching_options_box( $post, $new_post ); ?>

				<?php static::build_special_sorting_box( $post, $new_post ); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 actions-wrapper p-t-20">
					<button type="reset" class="btn button button-default" onclick="wpucv_reset_list_options()"><?php echo esc_html__(  'Reset', 'ultimate-content-views' ); ?></button>

					<button type="submit" class="btn button button-green" id="save_content_data" name="publish"><?php echo esc_html__(  'Save Settings', 'ultimate-content-views' ); ?></button>
				</div>
			</div>
		</div>

		<?php
		static::render_validation();
		exit;
	}

	/**
	 * Renders general options meta box
	 *
	 * @param $post WP_Post object
	 * @return void
	 */
	public static function build_general_options_box( $post, $new_post ) {
		$_wpucv_list_name = NULL;
		$_wpucv_slug = NULL;
		$_wpucv_notfound_text = 'No posts found';
		$_wpucv_template = 'template01';
		$_wpucv_show_list_title = false;
		$_wpucv_list_title_tag = 'h3';
		$_wpucv_list_title_color = '#000000';
		$_wpucv_shortcode = NULL;
		$_wpucv_funct_call = NULL;

		if( !$new_post ) {

			$_wpucv_list_name = get_post_meta( (int) $post->ID, '_wpucv_list_name', true);
			$_wpucv_slug = get_post_meta( (int) $post->ID, '_wpucv_slug', true);
			$_wpucv_notfound_text = get_post_meta( (int) $post->ID, '_wpucv_notfound_text', true);
			$_wpucv_template = get_post_meta( (int) $post->ID, '_wpucv_template', true);
			$_wpucv_show_list_title = get_post_meta( (int) $post->ID, '_wpucv_show_list_title', true);
			$_wpucv_list_title_tag = get_post_meta( (int) $post->ID, '_wpucv_list_title_tag', true);
			$_wpucv_list_title_color = get_post_meta( (int) $post->ID, '_wpucv_list_title_color', true);
			$_wpucv_shortcode = '[wpucv_list id=&quot;' . (int) $post->ID . '&quot; title=&quot;' . $_wpucv_slug . '&quot;]';
			$_wpucv_funct_call = '<?php echo wpucv_list(' . (int) $post->ID . '); ?>';
		}

		static::set_validation_rules( '_wpucv_list_name', array('required'   => true) );

		include( WPUCV_MAIN_DIR . '/inc/options/general.php' );
	}

	/**
	 * Renders searching options meta box
	 *
	 * @param $post WP_Post object
	 * @return void
	 */
	public static function build_searching_options_box( $post, $new_post ) {
		$_wpucv_post_types = array('post');
		if( !$new_post ) {
			$_wpucv_post_types = get_post_meta( (int) $post->ID, '_wpucv_post_types', true);
		}

		$post_types = static::get_post_types();

		$searching_fields = array();
		$post_type_relations = array();
		foreach( $post_types as $key => $value ) {
			$taxonomies = get_object_taxonomies( $key, 'objects' );

			if( 'post' == $key ) {
				if( array_key_exists( 'post_format', $taxonomies ) ) {
					unset( $taxonomies['post_format'] );
				}
			}

			foreach( $taxonomies as $taxonomy ) {

				$searching_fields[] = array(
					'id'                 => '_wpucv_' . $key . '_' . $taxonomy->name,
					'name'               => '_wpucv_' . $key . '[' . $taxonomy->name . ']',
					'label'              => $taxonomy->label,
					'type'               => 'term',
					'empty_option'       => false,
					'multiple'           =>  true,
					'selection_limit'    => ($taxonomy->name == 'category' ) ? 1 : 3,
					'select2'            => true,
					'size'               => 1,
					'taxonomy'           => $taxonomy->name,
					'show_option_all'    => false,
					'attributes'         => ( !in_array( $key, $_wpucv_post_types ) )? array('disabled' => 'disabled') : array(),
					'wrapper_attributes' => ( !in_array( $key, $_wpucv_post_types ) )? array('style' => 'display: none;') : array(),
				);

				$post_type_relations[] = '{name: \'_wpucv_' . $key . '[' . $taxonomy->name . ']\', id: \'_wpucv_' . $key . '_' . $taxonomy->name . '\', value: \'' . $key . '\', multiple: true}';
				$post_type_relations[] = '{name: \'_wpucv_exclude_' . $key . '[' . $taxonomy->name . ']\', id: \'_wpucv_exclude_' . $key . '_' . $taxonomy->name . '\', value: \'' . $key . '\', multiple: true}';
			}
		}


		$_wpucv_post_types = array('post');
		$_wpucv_authors = NULL;
		$_wpucv_date_from = NULL;
		$_wpucv_date_to = NULL;
		$_wpucv_post_status = array('publish');
		$_wpucv_has_password = 'null';
		$_wpucv_comments_count_oprt = '=';
		$_wpucv_comments_count = NULL;
		$_wpucv_ignore_sticky_posts = true;

		$searching_fields_values = array();
		foreach( $searching_fields as $field ){
			$searching_fields_values[ $field['id'] ] = NULL;
		}

		if( !$new_post ) {
			$_wpucv_post_types = get_post_meta( (int) $post->ID, '_wpucv_post_types', true);
			$_wpucv_authors = get_post_meta( (int) $post->ID, '_wpucv_authors', true);
			$_wpucv_date_from = get_post_meta( (int) $post->ID, '_wpucv_date_from', true);
			$_wpucv_date_to = get_post_meta( (int) $post->ID, '_wpucv_date_to', true);
			$_wpucv_post_status = get_post_meta( (int) $post->ID, '_wpucv_post_status', true);
			$_wpucv_has_password = get_post_meta( (int) $post->ID, '_wpucv_has_password', true);
			$_wpucv_comments_count_oprt = get_post_meta( (int) $post->ID, '_wpucv_comments_count_oprt', true);
			$_wpucv_comments_count = get_post_meta( (int) $post->ID, '_wpucv_comments_count', true);
			$_wpucv_ignore_sticky_posts = get_post_meta( (int) $post->ID, '_wpucv_ignore_sticky_posts', true);

			foreach( $searching_fields_values as $field_id => $val ){
				$searching_fields_values[ $field_id ] = get_post_meta( (int) $post->ID, $field_id, true );
			}
		}

		static::set_validation_rules( '_wpucv_post_types[]', array('required'   => true) );

		include( WPUCV_MAIN_DIR . '/inc/options/searching.php' );
	}

	/**
	 * Renders special sorting meta box
	 *
	 * @param $post WP_Post object
	 * @return void
	 */
	public static function build_special_sorting_box( $post, $new_post ) {
		$_wpucv_order_by = NULL;
		$_wpucv_order_type = NUll;

		if( !$new_post ) {
			$_wpucv_order_by = get_post_meta( (int) $post->ID, '_wpucv_order_by', true);
			$_wpucv_order_type = get_post_meta( (int) $post->ID, '_wpucv_order_type', true);
		}

		include( WPUCV_MAIN_DIR . '/inc/options/sorting.php' );
	}

	/**
	 * Renders exclusion options meta box
	 *
	 * @param $post WP_Post object
	 * @return void
	 */
	public static function build_exclusion_options_box( $post, $new_post ) {
		$_wpucv_post_types = array('post');
		if( !$new_post ) {
			$_wpucv_post_types = get_post_meta( (int) $post->ID, '_wpucv_post_types', true);
		}

		$post_types = static::get_post_types();

		$excluding_fields = array();
		foreach( $post_types as $key => $value ) {
			$taxonomies = get_object_taxonomies( $key, 'objects' );

			if( 'post' == $key ) {
				if( array_key_exists( 'post_format', $taxonomies ) ) {
					unset( $taxonomies['post_format'] );
				}
			}

			foreach( $taxonomies as $taxonomy ) {
				$excluding_fields[] = array(
					'id'                 => '_wpucv_exclude_' . $key . '_' . $taxonomy->name,
					'name'               => '_wpucv_exclude_' . $key . '[' . $taxonomy->name . ']',
					'label'              => $taxonomy->label,
					'type'               => 'pro',
					'empty_option'       => false,
					'multiple'           => true,
					'select2'            => true,
					'size'               => 3,
					'taxonomy'           => $taxonomy->name,
					'show_option_all'    => false,
					'attributes'         => ( !in_array( $key, $_wpucv_post_types ) )? array('disabled' => 'disabled') : array(),
					'wrapper_attributes' => ( !in_array( $key, $_wpucv_post_types ) )? array('style' => 'display: none;') : array(),
				);
			}
		}

		$_wpucv_exclude_authors = NULL;

		$exclude_fields_values = array();
		foreach( $excluding_fields as $field ){
			$exclude_fields_values[ $field['id'] ] = NULL;
		}

		if( !$new_post ) {
			$_wpucv_exclude_authors = get_post_meta( (int) $post->ID, '_wpucv_exclude_authors', true);

			foreach( $exclude_fields_values as $field_id => $val ){
				$exclude_fields_values[ $field_id ] = get_post_meta( (int) $post->ID, $field_id, true);
			}
		}

		include( WPUCV_MAIN_DIR . '/inc/options/exclusion.php' );
	}

	/**
	 * Renders list structure meta box
	 *
	 * @param $post WP_Post object
	 * @return void
	 */
	public static function build_list_structure_box( $post, $new_post ) {
		$_wpucv_show_author = true;
		$_wpucv_show_date = true;
		$_wpucv_title_size = '20';
		$_wpucv_title_lineheight = '26';
		$_wpucv_title_weight = 700;
		$_wpucv_title_color = '#232323';
		$_wpucv_title_h_color = '#232323';
		$_wpucv_meta_color = '#888888';
		$_wpucv_meta_size = '12';
		$_wpucv_meta_lineheight = '16';
		$_wpucv_meta_weight = 400;
		$_wpucv_show_excerpt = true;
		$_wpucv_excerpt_length = 20;
		$_wpucv_excerpt_size = '13';
		$_wpucv_excerpt_lineheight = '17';
		$_wpucv_excerpt_weight = 400;
		$_wpucv_excerpt_color = '#333333';
		$_wpucv_show_read_more = false;
		$_wpucv_read_more_text = esc_html__( 'Read more', 'ultimate-content-views' );
		$_wpucv_read_more_type = 'button';
		$_wpucv_read_more_color = '#FFFFFF';
		$_wpucv_read_more_h_color = '#FFFFFF';
		$_wpucv_read_more_bg_color = '#5e5e5e';
		$_wpucv_read_more_h_bg_color = '#5e5e5e';
		$_wpucv_read_more_size = '14';
		$_wpucv_read_more_lineheight = '14';
		$_wpucv_read_more_weight = 400;
		$_wpucv_feat_show_author = true;
		$_wpucv_feat_show_date = true;
		$_wpucv_feat_title_size = '20';
		$_wpucv_feat_title_lineheight = '26';
		$_wpucv_feat_title_weight = 700;
		$_wpucv_feat_title_color = '#232323';
		$_wpucv_feat_title_h_color = '#232323';
		$_wpucv_feat_meta_size = '12';
		$_wpucv_feat_meta_lineheight = '16';
		$_wpucv_feat_meta_weight = 400;
		$_wpucv_feat_meta_color = '#888888';
		$_wpucv_feat_show_excerpt = true;
		$_wpucv_feat_excerpt_length = 20;
		$_wpucv_feat_excerpt_size = '13';
		$_wpucv_feat_excerpt_lineheight = '17';
		$_wpucv_feat_excerpt_weight = 400;
		$_wpucv_bottom_border = true;
		$_wpucv_bottom_border_color = '';
		$_wpucv_feat_excerpt_color = '#333333';
		$_wpucv_feat_show_read_more = false;
		$_wpucv_feat_read_more_text = 'text';
		$_wpucv_feat_read_more_type = 'Button';
		$_wpucv_feat_read_more_color = '#FFFFFF';
		$_wpucv_feat_read_more_h_c = '#FFFFFF';
		$_wpucv_feat_read_more_bg_c = '#5e5e5e';
		$_wpucv_feat_read_more_h_bgc = '#5e5e5e';
		$_wpucv_feat_read_more_size = '14';
		$_wpucv_feat_read_more_lineheight = '14';
		$_wpucv_feat_read_more_weight = 400;
		$_wpucv_carousel_dots = true;
		$_wpucv_carousel_dots_color = '';
		$_wpucv_carousel_dots_h_color = '';
		$_wpucv_carousel_text_align = 'center';
		$_wpucv_thumbnail_shape = 'rectangle';
		$_wpucv_grid_columns_num = 3;
		$_wpucv_grid_columns_spacing = 10;
		$_wpucv_grid_rows_spacing = 10;
		$_wpucv_gallary_row_items = 7;
		$_wpucv_gallary_item_spacing = 5;

		if( !$new_post ) {
			$_wpucv_show_author = get_post_meta( (int) $post->ID, '_wpucv_show_author', true);
			$_wpucv_show_date = get_post_meta( (int) $post->ID, '_wpucv_show_date', true);
			$_wpucv_title_size = get_post_meta( (int) $post->ID, '_wpucv_title_size', true);
			$_wpucv_title_lineheight = get_post_meta( (int) $post->ID, '_wpucv_title_lineheight', true);
			$_wpucv_title_weight = get_post_meta( (int) $post->ID, '_wpucv_title_weight', true);
			$_wpucv_title_color = get_post_meta( (int) $post->ID, '_wpucv_title_color', true);
			$_wpucv_title_h_color = get_post_meta( (int) $post->ID, '_wpucv_title_h_color', true);
			$_wpucv_meta_color = get_post_meta( (int) $post->ID, '_wpucv_meta_color', true);
			$_wpucv_meta_size = get_post_meta( (int) $post->ID, '_wpucv_meta_size', true);
			$_wpucv_meta_lineheight = get_post_meta( (int) $post->ID, '_wpucv_meta_lineheight', true);
			$_wpucv_meta_weight = get_post_meta( (int) $post->ID, '_wpucv_meta_weight', true);
			$_wpucv_show_excerpt = get_post_meta( (int) $post->ID, '_wpucv_show_excerpt', true);
			$_wpucv_excerpt_length = get_post_meta( (int) $post->ID, '_wpucv_excerpt_length', true);
			$_wpucv_excerpt_size = get_post_meta( (int) $post->ID, '_wpucv_excerpt_size', true);
			$_wpucv_excerpt_lineheight = get_post_meta( (int) $post->ID, '_wpucv_excerpt_lineheight', true);
			$_wpucv_excerpt_weight = get_post_meta( (int) $post->ID, '_wpucv_excerpt_weight', true);
			$_wpucv_excerpt_color = get_post_meta( (int) $post->ID, '_wpucv_excerpt_color', true);
			$_wpucv_show_read_more = get_post_meta( (int) $post->ID, '_wpucv_show_read_more', true);
			$_wpucv_read_more_text = get_post_meta( (int) $post->ID, '_wpucv_read_more_text', true);
			$_wpucv_read_more_type = get_post_meta( (int) $post->ID, '_wpucv_read_more_type', true);
			$_wpucv_read_more_color = get_post_meta( (int) $post->ID, '_wpucv_read_more_color', true);
			$_wpucv_read_more_h_color = get_post_meta( (int) $post->ID, '_wpucv_read_more_h_color', true);
			$_wpucv_read_more_bg_color = get_post_meta( (int) $post->ID, '_wpucv_read_more_bg_color', true);
			$_wpucv_read_more_h_bg_color = get_post_meta( (int) $post->ID, '_wpucv_read_more_h_bg_color', true);
			$_wpucv_read_more_size = get_post_meta( (int) $post->ID, '_wpucv_read_more_size', true);
			$_wpucv_read_more_lineheight = get_post_meta( (int) $post->ID, '_wpucv_read_more_lineheight', true);
			$_wpucv_read_more_weight = get_post_meta( (int) $post->ID, '_wpucv_read_more_weight', true);
			$_wpucv_feat_show_author = get_post_meta( (int) $post->ID, '_wpucv_feat_show_author', true);
			$_wpucv_feat_show_date = get_post_meta( (int) $post->ID, '_wpucv_feat_show_date', true);
			$_wpucv_feat_title_size = get_post_meta( (int) $post->ID, '_wpucv_feat_title_size', true);
			$_wpucv_feat_title_lineheight = get_post_meta( (int) $post->ID, '_wpucv_feat_title_lineheight', true);
			$_wpucv_feat_title_weight = get_post_meta( (int) $post->ID, '_wpucv_feat_title_weight', true);
			$_wpucv_feat_title_color = get_post_meta( (int) $post->ID, '_wpucv_feat_title_color', true);
			$_wpucv_feat_title_h_color = get_post_meta( (int) $post->ID, '_wpucv_feat_title_h_color', true);
			$_wpucv_feat_meta_size = get_post_meta( (int) $post->ID, '_wpucv_feat_meta_size', true);
			$_wpucv_feat_meta_lineheight = get_post_meta( (int) $post->ID, '_wpucv_feat_meta_lineheight', true);
			$_wpucv_feat_meta_weight = get_post_meta( (int) $post->ID, '_wpucv_feat_meta_weight', true);
			$_wpucv_feat_meta_color = get_post_meta( (int) $post->ID, '_wpucv_feat_meta_color', true);
			$_wpucv_feat_show_excerpt = get_post_meta( (int) $post->ID, '_wpucv_feat_show_excerpt', true);
			$_wpucv_feat_excerpt_length = get_post_meta( (int) $post->ID, '_wpucv_feat_excerpt_length', true);
			$_wpucv_feat_excerpt_size = get_post_meta( (int) $post->ID, '_wpucv_feat_excerpt_size', true);
			$_wpucv_feat_excerpt_lineheight = get_post_meta( (int) $post->ID, '_wpucv_feat_excerpt_lineheight', true);
			$_wpucv_feat_excerpt_weight = get_post_meta( (int) $post->ID, '_wpucv_feat_excerpt_weight', true);
			$_wpucv_bottom_border = get_post_meta( (int) $post->ID, '_wpucv_bottom_border', true);
			$_wpucv_bottom_border_color = get_post_meta( (int) $post->ID, '_wpucv_bottom_border_color', true);
			$_wpucv_feat_excerpt_color = get_post_meta( (int) $post->ID, '_wpucv_feat_excerpt_color', true);
			$_wpucv_feat_show_read_more = get_post_meta( (int) $post->ID, '_wpucv_feat_show_read_more', true);
			$_wpucv_feat_read_more_text = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_text', true);
			$_wpucv_feat_read_more_type = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_type', true);
			$_wpucv_feat_read_more_color = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_color', true);
			$_wpucv_feat_read_more_h_c = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_h_c', true);
			$_wpucv_feat_read_more_bg_c = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_bg_c', true);
			$_wpucv_feat_read_more_h_bgc = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_h_bgc', true);
			$_wpucv_feat_read_more_size = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_size', true);
			$_wpucv_feat_read_more_lineheight = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_lineheight', true);
			$_wpucv_feat_read_more_weight = get_post_meta( (int) $post->ID, '_wpucv_feat_read_more_weight', true);
			$_wpucv_carousel_dots = get_post_meta( (int) $post->ID, '_wpucv_carousel_dots', true);
			$_wpucv_carousel_dots_color = get_post_meta( (int) $post->ID, '_wpucv_carousel_dots_color', true);
			$_wpucv_carousel_dots_h_color = get_post_meta( (int) $post->ID, '_wpucv_carousel_dots_h_color', true);
			$_wpucv_carousel_text_align = get_post_meta( (int) $post->ID, '_wpucv_carousel_text_align', true);
			$_wpucv_thumbnail_shape = get_post_meta( (int) $post->ID, '_wpucv_thumbnail_shape', true);
			$_wpucv_grid_columns_num = get_post_meta( (int) $post->ID, '_wpucv_grid_columns_num', true);
			$_wpucv_grid_columns_spacing = get_post_meta( (int) $post->ID, '_wpucv_grid_columns_spacing', true);
			$_wpucv_grid_rows_spacing = get_post_meta( (int) $post->ID, '_wpucv_grid_rows_spacing', true);
			$_wpucv_gallary_row_items = get_post_meta( (int) $post->ID, '_wpucv_gallary_row_items', true);
			$_wpucv_gallary_item_spacing = get_post_meta( (int) $post->ID, '_wpucv_gallary_item_spacing', true);
		}

		include( WPUCV_MAIN_DIR . '/inc/options/list_structure.php' );
	}

	/**
	 * Renders pagination meta box
	 *
	 * @param $post WP_Post object
	 * @uses get_current_screen()
	 * @return void
	 */
	public static function build_pagination_box( $post, $new_post ) {
		$_wpucv_posts_number = 6;
		$_wpucv_show_pagination = true;
		$_wpucv_posts_per_page = 18;
		$_wpucv_pagination_type = 'square';
		$_wpucv_pagination_c = '#FFFFFF';
		$_wpucv_pagination_h_c = '#FFFFFF';
		$_wpucv_pagination_bg_c = '#4584ED';
		$_wpucv_pagination_bg_h_c = '#adadad';
		$_wpucv_show_next_previous = true;
		$_wpucv_next_previous_type = 'icon';
		$_wpucv_next_text = '>>';
		$_wpucv_previous_text = '<<';
		$_wpucv_first_text = esc_html__( 'First', 'ultimate-content-views' );
		$_wpucv_last_text = esc_html__( 'Last', 'ultimate-content-views' );

		if( !$new_post ) {
			$_wpucv_posts_number = intval(get_post_meta( (int) $post->ID, '_wpucv_posts_number', true));
			$_wpucv_show_pagination = get_post_meta( (int) $post->ID, '_wpucv_show_pagination', true);
			$_wpucv_posts_per_page = get_post_meta( (int) $post->ID, '_wpucv_posts_per_page', true);
			$_wpucv_pagination_type = get_post_meta( (int) $post->ID, '_wpucv_pagination_type', true);
			$_wpucv_pagination_c = get_post_meta( (int) $post->ID, '_wpucv_pagination_c', true);
			$_wpucv_pagination_h_c = get_post_meta( (int) $post->ID, '_wpucv_pagination_h_c', true);
			$_wpucv_pagination_bg_c = get_post_meta( (int) $post->ID, '_wpucv_pagination_bg_c', true);
			$_wpucv_pagination_bg_h_c = get_post_meta( (int) $post->ID, '_wpucv_pagination_bg_h_c', true);
			$_wpucv_show_next_previous = get_post_meta( (int) $post->ID, '_wpucv_show_next_previous', true);
			$_wpucv_next_previous_type = get_post_meta( (int) $post->ID, '_wpucv_next_previous_type', true);
			$_wpucv_next_text = get_post_meta( (int) $post->ID, '_wpucv_next_text', true);
			$_wpucv_previous_text = get_post_meta( (int) $post->ID, '_wpucv_previous_text', true);
			$_wpucv_first_text = get_post_meta( (int) $post->ID, '_wpucv_first_text', true);
			$_wpucv_last_text = get_post_meta( (int) $post->ID, '_wpucv_last_text', true);
		}

		include( WPUCV_MAIN_DIR . '/inc/options/pagination.php' );
	}

	public static function save_meta_fields( $post_id, $post, $update ) {



		$list_form_submitted = ( array_key_exists( '_wpucv_list_name', $_POST ) );
		$no_ajax = ( !defined( 'DOING_AJAX' ) || !DOING_AJAX );
		if( $no_ajax && 'wpucv_list' == $post->post_type && $list_form_submitted ) {
			$fields = array(
				'_wpucv_list_name',
				'_wpucv_slug',
				'_wpucv_notfound_text',
				'_wpucv_template',
				'_wpucv_show_list_title',
				'_wpucv_list_title_tag',
				'_wpucv_list_title_color',
				'_wpucv_post_types',
				'_wpucv_authors',
				'_wpucv_date_from',
				'_wpucv_date_to',
				'_wpucv_post_status',
				'_wpucv_has_password',
				'_wpucv_comments_count_oprt',
				'_wpucv_comments_count',
				'_wpucv_ignore_sticky_posts',
				'_wpucv_order_by',
				'_wpucv_order_type',
				'_wpucv_exclude_authors',
				'_wpucv_show_author',
				'_wpucv_show_date',
				'_wpucv_title_size',
				'_wpucv_title_lineheight',
				'_wpucv_title_weight',
				'_wpucv_title_color',
				'_wpucv_title_h_color',
				'_wpucv_meta_color',
				'_wpucv_meta_size',
				'_wpucv_meta_lineheight',
				'_wpucv_meta_weight',
				'_wpucv_show_excerpt',
				'_wpucv_excerpt_length',
				'_wpucv_excerpt_size',
				'_wpucv_excerpt_lineheight',
				'_wpucv_excerpt_weight',
				'_wpucv_excerpt_color',
				'_wpucv_show_read_more',
				'_wpucv_read_more_text',
				'_wpucv_read_more_type',
				'_wpucv_read_more_color',
				'_wpucv_read_more_h_color',
				'_wpucv_read_more_bg_color',
				'_wpucv_read_more_h_bg_color',
				'_wpucv_read_more_size',
				'_wpucv_read_more_lineheight',
				'_wpucv_read_more_weight',
				'_wpucv_feat_show_author',
				'_wpucv_feat_show_date',
				'_wpucv_feat_title_size',
				'_wpucv_feat_title_lineheight',
				'_wpucv_feat_title_weight',
				'_wpucv_feat_title_color',
				'_wpucv_feat_title_h_color',
				'_wpucv_feat_meta_size',
				'_wpucv_feat_meta_lineheight',
				'_wpucv_feat_meta_weight',
				'_wpucv_feat_meta_color',
				'_wpucv_feat_show_excerpt',
				'_wpucv_feat_excerpt_length',
				'_wpucv_feat_excerpt_size',
				'_wpucv_feat_excerpt_lineheight',
				'_wpucv_feat_excerpt_weight',
				'_wpucv_bottom_border',
				'_wpucv_bottom_border_color',
				'_wpucv_feat_excerpt_color',
				'_wpucv_feat_show_read_more',
				'_wpucv_feat_read_more_text',
				'_wpucv_feat_read_more_type',
				'_wpucv_feat_read_more_color',
				'_wpucv_feat_read_more_h_c',
				'_wpucv_feat_read_more_bg_c',
				'_wpucv_feat_read_more_h_bgc',
				'_wpucv_feat_read_more_size',
				'_wpucv_feat_read_more_lineheight',
				'_wpucv_feat_read_more_weight',
				'_wpucv_carousel_dots',
				'_wpucv_carousel_dots_color',
				'_wpucv_carousel_dots_h_color',
				'_wpucv_carousel_text_align',
				'_wpucv_posts_number',
				'_wpucv_show_pagination',
				'_wpucv_posts_per_page',
				'_wpucv_pagination_type',
				'_wpucv_pagination_c',
				'_wpucv_pagination_h_c',
				'_wpucv_pagination_bg_c',
				'_wpucv_pagination_bg_h_c',
				'_wpucv_show_next_previous',
				'_wpucv_next_previous_type',
				'_wpucv_next_text',
				'_wpucv_previous_text',
				'_wpucv_first_text',
				'_wpucv_last_text',
				'_wpucv_thumbnail_shape',
				'_wpucv_grid_columns_num',
				'_wpucv_grid_columns_spacing',
				'_wpucv_grid_rows_spacing',
				'_wpucv_gallary_row_items',
				'_wpucv_gallary_item_spacing',
			);

			foreach( $fields as $field ) {
				if( array_key_exists( $field, $_POST ) )
				{
					if(is_array($_POST[$field]))
					{
						update_post_meta( $post_id, $field, array_map("strip_tags", $_POST[$field]));
					}else{
						update_post_meta( $post_id, $field, wpucv_sanitizing($_POST[$field]));
					}
				}
				elseif( $update ){
					delete_post_meta( $post_id, $field );
				}
			}


			$post_types = static::get_post_types();

			$post_types_fields = array();
			foreach( $post_types as $key => $value ) {
				$taxonomies = get_object_taxonomies( $key, 'objects' );

				if( 'post' == $key ) {
					if( array_key_exists( 'post_format', $taxonomies ) ) {
						unset( $taxonomies['post_format'] );
					}
				}

				foreach( $taxonomies as $taxonomy ) {
					$post_types_fields[ '_wpucv_' . $key . '_' . $taxonomy->name ] = '_wpucv_' . $key . '_' . $taxonomy->name;
					$post_types_fields[ '_wpucv_exclude_' . $key . '_' . $taxonomy->name ] = '_wpucv_exclude_' . $key . '_' . $taxonomy->name;
				}
			}

			foreach($post_types as $type => $tax){
				$terms = ( array_key_exists( '_wpucv_' . $type, $_POST ) )? ($_POST['_wpucv_' . $type]) : array();
				$exclude_terms = ( array_key_exists( '_wpucv_exclude_' . $type, $_POST ) )? ($_POST['_wpucv_exclude_' . $type]) : array();

				foreach( $terms as $key => $value ) {
					update_post_meta( $post_id, '_wpucv_' . $type . '_' . $key, ($value) );
					if( array_key_exists( '_wpucv_' . $type . '_' . $key, $post_types_fields ) ) {
						unset( $post_types_fields[ '_wpucv_' . $type . '_' . $key ] );
					}
				}

				foreach( $exclude_terms as $key => $value ) {
					update_post_meta( $post_id, '_wpucv_exclude_' . $type . '_' . $key, ($value) );
					if( array_key_exists( '_wpucv_exclude_' . $type . '_' . $key, $post_types_fields ) ) {
						unset( $post_types_fields[ '_wpucv_exclude_' . $type . '_' . $key ] );
					}
				}
			}

			foreach( $post_types_fields as $dfield ) {
				delete_post_meta( $post_id, $dfield );
			}

			remove_action( 'save_post', array(__CLASS__, 'save_meta_fields'), 5 );
			remove_action( 'save_post', array(__CLASS__, 'save_post_title'), 7 );

			wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'publish','post_title'   => sanitize_text_field($_POST['_wpucv_list_name']) ) );

			add_action( 'save_post', array(__CLASS__, 'save_meta_fields'), 5, 3 );
			add_action( 'save_post', array(__CLASS__, 'save_post_title'), 7, 3 );



			$_wpucv_list_parameters = WPUCV_List_Renderer::get_list_parameters( $post_id );
            $_wpucv_list_parameters['fields'] = 'ids';

			update_post_meta( $post_id, '_wpucv_list_parameters', $_wpucv_list_parameters );


            $the_query = new WP_Query( $_wpucv_list_parameters );

            if ( $the_query->have_posts() ):
                while ( $the_query->have_posts() ) : $the_query->the_post();
                    $image_id = get_post_thumbnail_id(get_the_ID());
                    $fullsizepath = get_attached_file( $image_id );
                    $get_if_generate_img = get_post_meta( $post_id, 'generate_attachment_img', true );

                    if ( false === $fullsizepath || !file_exists($fullsizepath) ){
                        continue;
                    }

                    wp_update_attachment_metadata( $image_id, wp_generate_attachment_metadata( $image_id, $fullsizepath ) ) ;


                endwhile;
            endif;

            wp_reset_query();
		}
	}

	private static function set_fields_props( $post, $children, $new_post ) {
		foreach($children as $child){
			switch($child['element']){
				case 'tabs':
				case 'tab':
				case 'fieldset':
				case 'row':
				static::set_fields_props( $post, $child['children'], $new_post );
				break;

				case 'field':
				if( 'spacing' == $child['type'] || 'label' == $child['type'] ) {
					$value = NULL;
				}
				elseif( $new_post ) {
					$value = array_key_exists( 'default', $child )? $child['default'] : NULL;
				} else {
					$value = get_post_meta( (int) $post->ID, $child['name'], true );
				}
				static::set_field_props( $child, $value );
				break;
			}
		}
	}


	public static function render_field( $field, $value = NULL, $repeatable = false ) {
		$defaults = array(
			'id'                 => '',
			'name'               => '',
			'label'              => '',
			'type'               => 'text',
			'default'            => NULL,
			'class'              => NULL,
			'attributes'         => array(),
			'options'            => array(),
			'empty_option'       => true,
			'multiple'           => false,
			'select2'            => false,
			'size'               => NULL,
			'desc'               => '',
			'no_save'            => false,
			'required'           => false,
			'validation'         => array(),
			'taxonomy'           => '',
			'columns'            => 4,
			'show_option_all'    => true,
			'date_format'        => 'dd/mm/yy',
			'repeated'           => false,
			'mode'               => '',
			'underlined_label'   => false,
			'label_note'         => '',
		);

		$field = wp_parse_args( $field, $defaults );

		foreach($defaults as $k=>$v)
		{
			if(is_array($field[$k]))
			{
				$field[$k] = array_map("strip_tags", $field[$k]);
			}else{

			$field[$k] = wpucv_esc($field[$k]);
			}


		}


		$html = '';
		if( !$repeatable ) {
			$wrapper_attributes = '';
			if( array_key_exists( 'wrapper_attributes', $field ) ) {
				foreach( $field['wrapper_attributes'] as $key => $val ) {
					$wrapper_attributes .= ' ' . $key . '="' . esc_attr($val) . '"';
				}
			}
			$html = '<div class="field-wrapper clearfix" id="' . esc_attr($field['id']) . '_wrapper" ' . $wrapper_attributes . '>';
		}

		$attributes = ' autocomplete="off"';
		if( array_key_exists( 'attributes', $field ) ) {
			foreach( $field['attributes'] as $key => $val ) {
				$attributes .= ' ' . $key . '="' . esc_attr($val) . '"';
			}
		}

		if( !$repeatable && in_array( $field['type'], array('text', 'number', 'textarea', 'code', 'select', 'category', 'term', 'author', 'image_select', 'image', 'datepicker') ) ) {
			$html .= '<label class="control-label ' . ( ( esc_attr($field['required']) )? 'required' : '' ) . ' ' . ( ( esc_attr($field['underlined_label']) )? 'underlined' : '' ) . '">' .
					$field['label'] . ( !empty( $field['label_note'] )? ' <span class="label-note">(' . esc_attr($field['label_note']) . ')<span>' : '' ). '</label>';
		}

		switch( $field['type'] ) {
			case 'text':
			$html .= '<input type="text" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" class="form-control ' . esc_attr($field['class']) . '" ' . $attributes . ' />';
			break;

			case 'number':
			$html .= '<input type="number" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" class="form-control ' . esc_attr($field['class']) . '" ' . $attributes . ' />';
			break;

			case 'hidden':
			$html .= '<input type="hidden" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" ' . $attributes . ' />';
			break;

			case 'textarea':
			$html .= '<textarea name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']). '" class="form-control ' . esc_attr($field['class']) . '" ' . $attributes . '>' . esc_textarea( $value ) . '</textarea>';
			break;

			case 'code':
			if( $repeatable ) { break; }
			$uniqid = uniqid();
			$html .= '<textarea name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '">' . esc_textarea( $value ) . '</textarea>';
			$html .= '<script>
				"use strict";
				jQuery(function(){
					
					var tab_' . esc_js($uniqid) . ' = jQuery("#' . esc_js($field['id']) . '").parents(".tab-pane");
					if(tab_' . esc_js($uniqid) . '.length > 0){
						if(tab_' . esc_js($uniqid) . '.hasClass("active")){
							func_' . esc_js($uniqid) . '();
						} else{
							jQuery("[href=\'#" + tab_' . esc_js($uniqid) . '.first().prop("id") + "\']").bind("click", function(){
								"use strict";
								jQuery(this).unbind("click");
								setTimeout(function(){
									"use strict";
									func_' . esc_js($uniqid) . '();
								}, 500);
							});
						}
					} else{
						func_' . esc_js($uniqid). '();
					}
				});
				function func_' . esc_js($uniqid) . '(){
					"use strict";
					CodeMirror.fromTextArea(document.getElementById("' . esc_js($field['id']) . '"), {
						' . ( !empty( $field['mode'] )? 'mode: "' . esc_js($field['mode']) . '",' : '' ) . '
						lineNumbers: true,
						styleActiveLine: true,
						matchBrackets: true
					});
				}
			</script>';
			break;

			case 'select':
			$multiple = ( array_key_exists( 'multiple', $field ) && $field['multiple'] );
			$value = ( !is_array( $value ) )? array($value) : ($value);
			$field['class'] .= ( $field['select2'] )? ' select2' : '';
			$html .= '<select name="' . esc_attr($field['name']) . ( ( $multiple )? '[]' : '' ) . '" id="' . esc_attr($field['id']) . '" class="form-control ' . esc_attr($field['class']) . '" ' . $attributes . ' ' .
					( ( $multiple )? ' multiple="multiple"' : '' ) . ' ' . ( !empty( $field['size'] )? 'size="' . esc_attr($field['size']) . '"' : '' ) . '>';
			$html .= ( $field['empty_option'] )? '<option value="">...</option>' : '';
			foreach( $field['options'] as $key => $val ) {
				if(strpos(esc_attr($key), '_disabled') !== false)
				{
					$disabled = "disabled=disabled";
				}else{
					$disabled = "";
				}
				$html .= '<option '.$disabled.' value="' . esc_attr($key) . '" ' . ( ( in_array( $key, ($value) ) )? 'selected="selected"' : '' ) . '>' . wpucv_esc($val) . '</option>';
			}
			$html .= '</select>';
			if( $field['select2'] ) {
				$html .= '<script>
							jQuery(document).ready(function() {
								"use strict";
								jQuery("#' . esc_js($field['id']) . '").select2();
								
								jQuery("#' . esc_js($field['id']) . '").on("select2:select", function(e){
									"use strict";
									if("0" == e.params.data.id){
										jQuery("#' . esc_js($field['id']) . '").select2("val", "0");
									}
									else{
										var vals = jQuery("#' . esc_js($field['id']) . '").select2("val");
										if("0" == vals[0]){
											vals.shift();
											jQuery("#' . esc_js($field['id']) . '").select2("val", vals);
										}
									}
								});
							});
						</script>';
			}
			break;

			case 'category':
			$multiple = ( array_key_exists( 'multiple', $field ) && $field['multiple'] );
			$args = array(
				'show_option_all'    => ( array_key_exists( 'show_option_all', $field ) && $field['show_option_all'] )? esc_html__( 'All categories', 'ultimate-content-views' ) : NULL,
				'hide_empty'         => ( $field['empty_option'] )? 0 : 1,
				'selected'           => ( $multiple && is_array( $value ) )? NULL : esc_attr( $value ),
				'hierarchical'       => 1,
				'name'               => $field['name'] . ( ( $multiple )? '[]' : '' ),
				'id'                 => $field['id'],
				'class'              => 'form-control ' . $field['class'] . (($field['class'])? ' select2' : ''),
				'echo'               => 0,
			);

			$dropdown = wp_dropdown_categories( $args );

			if( !empty( $field['size'] ) ) {
				$dropdown = str_replace( '<select', '<select size="' . esc_attr($field['size']) . '"', $dropdown );
			}

			if( $multiple ) {
				$dropdown = str_replace( '<select', '<select multiple', $dropdown );
				if( is_array( $value ) ) {
					foreach( $value as $v ) {
						$dropdown = str_replace( 'value="' . esc_attr($v) . '"', 'value="' . esc_attr($v) . '" selected="selected"', $dropdown );
						$dropdown = str_replace( "value='" . esc_attr($v) . "'", "value='" . esc_attr($v) . "' selected='selected'", $dropdown );
					}
				}
			}

			$dropdown = str_replace( '<select', '<select ' . $attributes, $dropdown );
			$html .= $dropdown;

			if( $field['select2'] ) {
				$html .= '<script>
				"use strict";
							jQuery(document).ready(function() {
								
								jQuery("#' . esc_js($field['id']) . '").select2();
								
								jQuery("#' . esc_js($field['id']) . '").on("select2:select", function(e){
									"use strict";
									if("0" == e.params.data.id){
										jQuery("#' . esc_js($field['id']) . '").select2("val", "0");
									}
									else{
										var vals = jQuery("#' . esc_js($field['id']) . '").select2("val");
										if("0" == vals[0]){
											vals.shift();
											jQuery("#' . esc_js($field['id']) . '").select2("val", vals);
										}
									}
								});
							});
						</script>';
			}
			break;

			case 'term':
			$multiple = ( array_key_exists( 'multiple', $field ) && $field['multiple'] );
			$args = array(
				'show_option_all'    => ( array_key_exists( 'show_option_all', $field ) && $field['show_option_all'] )? esc_html__( 'Select all', 'ultimate-content-views' ) : NULL,
				'hide_empty'         => ( $field['empty_option'] )? 0 : 1,
				'selected'           => ( $multiple && is_array( $value ) )? NULL : wpucv_esc( $value ),
				'hierarchical'       => 1,
				'name'               => $field['name'] . ( ( $multiple )? '[]' : '' ),
				'id'                 => $field['id'],
				'class'              => 'form-control ' . $field['class'] . (($field['class'])? ' select2' : ''),
				'echo'               => 0,
				'taxonomy'           => $field['taxonomy'],
			);

			$dropdown = wp_dropdown_categories( $args );

			if( !empty( $field['size'] ) ) {
				$dropdown = str_replace( '<select', '<select size="' . esc_attr($field['size']) . '"', $dropdown );
			}

			if( $multiple ) {
				$dropdown = str_replace( '<select', '<select multiple', $dropdown );
				if( is_array( $value ) ) {
					foreach( $value as $v ) {
						$dropdown = str_replace( 'value="' . esc_attr($v) . '"', 'value="' . esc_attr($v). '" selected="selected"', $dropdown );
						$dropdown = str_replace( "value='" . esc_attr($v) . "'", "value='" . esc_attr($v) . "' selected='selected'", $dropdown );
					}
				}
			}

			$dropdown = str_replace( '<select', '<select ' . $attributes, $dropdown );
			$html .= $dropdown;

			if( $field['select2'] ) {
				$selection_limit =  ($field['selection_limit'] > 0) ? $field['selection_limit']: '999';

				$html .= '<script>
				"use strict";
							jQuery(document).ready(function() {
								"use strict";
								jQuery("#' . esc_js($field['id']) . '").select2({
								maximumSelectionLength: '.$selection_limit.',
								language: {
									// You can find all of the options in the language files provided in the
									// build. They all must be functions that return the string that should be
									// displayed.
									maximumSelected: function (e) {
										var t = "You can only select " + e.maximum + " item";
										e.maximum != 1 && (t += "s");
										return t + \' - Upgrade Now and Select More\';
										
									}
								}
							});
								
								jQuery("#' . esc_js($field['id']) . '").on("select2:select", function(e){
									"use strict";
									if("0" == e.params.data.id){
										jQuery("#' . esc_js($field['id']) . '").select2("val", "0");
									}
									else{
										var vals = jQuery("#' . esc_js($field['id']) . '").select2("val");
										if("0" == vals[0]){
											vals.shift();
											jQuery("#' . esc_js($field['id']) . '").select2("val", vals);
										}
									}
								});
							});
							
							
							
						</script>';
			}
			break;

			case 'author':
			$multiple = ( array_key_exists( 'multiple', $field ) && $field['multiple'] );
			$args = array(
				'show_option_all'    => ( array_key_exists( 'show_option_all', $field ) && $field['show_option_all'] )? esc_html__( 'Select all', 'ultimate-content-views' ) : NULL,
				'echo'               => 0,
				'selected'           => ( $multiple && is_array( $value ) )? NULL : esc_attr( $value ),
				'name'               => $field['name'] . ( ( $multiple )? '[]' : '' ),
				'id'                 => $field['id'],
				'class'              => 'form-control ' . $field['class'] . (($field['class'])? ' select2' : ''),
				'blog_id'            => $GLOBALS['blog_id'],
			);

			$dropdown = wp_dropdown_users( $args );

			if( !empty( $field['size'] ) ) {
				$dropdown = str_replace( '<select', '<select size="' . esc_attr($field['size']) . '"', $dropdown );
			}

			if( $multiple ) {
				$dropdown = str_replace( '<select', '<select multiple', $dropdown );
				if( is_array( $value ) ) {
					foreach( $value as $v ) {
						$dropdown = str_replace( 'value="' . esc_attr($v) . '"', 'value="' . esc_attr($v) . '" selected="selected"', $dropdown );
						$dropdown = str_replace( "value='" . esc_attr($v) . "'", "value='" . esc_attr($v) . "' selected='selected'", $dropdown );
					}
				}
			}

			$dropdown = str_replace( '<select', '<select ' . $attributes, $dropdown );
			$html .= $dropdown;

			if( $field['select2'] ) {
				$html .= '<script>
							jQuery(document).ready(function() {
								"use strict";
								jQuery("#' . esc_js($field['id']) . '").select2();
								
								jQuery("#' . esc_js($field['id']) . '").on("select2:select", function(e){
									"use strict";
									if("0" == e.params.data.id){
										jQuery("#' . esc_js($field['id']) . '").select2("val", "0");
									}
									else{
										var vals = jQuery("#' . esc_js($field['id']) . '").select2("val");
										if("0" == vals[0]){
											vals.shift();
											jQuery("#' . esc_js($field['id']) . '").select2("val", vals);
										}
									}
								});
							});
						</script>';
			}
			break;

			case 'image_select':
			$html .= '<ul class="wpucv-image-select clearfix">';
			$index = 0;
			foreach( $field['options'] as $val => $img ) {
				$html .= '<li ' . ( ( $val == $value )? 'class="wpucv-selected"' : '' ) . ' onclick="wpucv_image_select_changed(this)">
							<img src="' . esc_url($img) . '" />
							<input type="radio" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '_' . esc_attr($index) . '" ' .
							checked( wpucv_esc($val), wpucv_esc($value), false ) . ' value="' . esc_attr($val) . '" ' . $attributes . ' />
						</li>';
				$index++;
			}
			$html .= '</ul>';
			break;

			case 'checkbox':
			$html .= ( !$repeatable )? '<label class="control-label inline-label checkbox-label">' . wpucv_esc($field['label']) . '</label>' : '';
			$html .= '<input type="checkbox" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['name']) . '" class="checkbox-control ' . esc_attr($field['class']) . '" ' . checked( 1, esc_attr($value), false ) . ' value="1" ' . $attributes . ' />';
			$html .= '<script>
						"use strict";
							jQuery(function(){
								
								jQuery("#' . esc_js($field['id']) . '").checkboxpicker();
							});
						</script>';
			break;

			case 'checkbox_group':
			$value = ( is_array( $value ) )? $value : array( $value );
			$html .= '<fieldset ' . ( ( $field['required'] )? 'class="required"' : '' ) . '>';
			$html .= ( !$repeatable )? '<legend>' . wpucv_esc($field['label']) . '</legend>' : '';
			$index = 0;
			foreach( $field['options'] as $key => $val ) {
				$html .= '<input id="' . esc_attr($field['id']) . $index . '" name="' . esc_attr($field['name']) . '[]" value="' . esc_attr($key) . '" type="checkbox" ' . checked( true, ( in_array( $key, $value ) ), false ) . ' ' . $attributes . '><label for="' . esc_attr($field['id']) . esc_attr($index) . '">' . wpucv_esc($val) . '</label>&nbsp;';
				$index++;
			}
			$html .= '</fieldset>';
			break;

			case 'radio_group':
			$html .= '<fieldset>';
			$html .= ( !$repeatable )? '<legend ' . ( ( $field['required'] )? 'class="required"' : '' ) . '>' . wpucv_esc($field['label']) . '</legend>' : '';
			$index = 0;
			foreach( $field['options'] as $key => $val ) {
				$html .= '<input id="' . esc_attr($field['id']) . $index . '" name="' . esc_attr($field['name']) . '[]" value="' . esc_attr($key) . '" type="radio" ' . checked( $key, $value, false ) . ' ' . $attributes . '><label for="' . esc_attr($field['id']) . esc_attr($index) . '">' . wpucv_esc($val) . '</label>&nbsp;';
				$index++;
			}
			$html .= '</fieldset>';
			break;

			case 'color':
			$valu = esc_js($value);
			$html .= ( !$repeatable )? '<label class="control-label inline-label color-label">' . wpucv_esc($field['label']) . '</label>' : '';
			$html .= '<input type="text" class="color-control ' . esc_attr($field['class']) . '" id="' . esc_attr($field['id']) . '_colpick" />
				<input type="hidden" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['name']) . '" ' . $attributes . ' value="' . esc_attr( $value ) . '" />
				<script>
				jQuery(function(){
					"use strict";
					jQuery("#' . esc_js($field['id']) . '_colpick").spectrum({
						' . ( !empty( $valu )? 'color: "' . esc_js( $value ) . '",' : '') . '
						showInput: true,
						allowEmpty: true,
						showAlpha: false,
						preferredFormat: "Hex",
						showButtons: false,
						change: function(color){
							"use strict";
							var val = (!wpucv_is_empty(color))? color.toHexString() : "";
							jQuery("#' . esc_js($field['id']) . '").val(val);
							jQuery("#' . esc_js($field['id']). '").trigger("change");
						}
					});
				});
				</script>';
			break;

			case 'image':
			$html .= '<div class="wpucv-thumb-container" id="' . esc_attr($field['id']) . '_thumb"></div>
						<input type="hidden" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['name']) . '" />
						<button type="button" class="btn btn-sm btn-default" onclick="wpucv_select_media(\'wpucv_img_id_from_url\', [\'' . esc_js($field['id']) . '\', \'' . esc_js($field['id']) . '_thumb\']);">' . esc_html__( 'Upload', 'ultimate-content-views' ) . '</button>
						<button type="button" class="btn btn-sm btn-default" onclick="wpucv_remove_image(\'' . esc_js($field['id']) . '\', \'' . esc_js($field['id']) . '_thumb\');"><span style="color: #FF0000;">' . esc_html__( 'Delete', 'ultimate-content-views' ) . '</span></button>';
			break;

			case 'datepicker':
			$date_format = ( array_key_exists( 'date_format', $field ) ) ? $field['date_format'] : 'dd/mm/yy';
			$html .= '<input type="text" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" class="form-control ' . esc_attr($field['class']) . '" ' . $attributes . ' />
					<script>
						jQuery(document).ready(function($) {
							"use strict";
							$("#' . esc_js($field['id']) . '").datepicker({
								dateFormat: "' . esc_js($date_format) . '",
								changeMonth: true,
								changeYear: true
							});
						});
					</script>';
			break;

			case 'onoffswitch':
			$html .= '<label class="control-label">' . wpucv_esc($field['label']) . '</label>
					<div class="onoffswitch">
						<input type="checkbox" class="onoffswitch-checkbox ' .esc_attr($field['class']) . '" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['name']) . '" ' . checked( 1, esc_attr($value), false ) . ' value="1" ' . $attributes . '>
						<label class="onoffswitch-label" for="' . esc_attr($field['id']) . '">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>';
			break;


			case 'label':
			$html .= '<label class="control-label group-label ' . ( ( esc_attr($field['underlined_label']) )? 'underlined' : '' ) . '">' . wpucv_esc($field['label']) .
					( !empty( $field['label_note'] )? ' <span class="label-note">(' . wpucv_esc($field['label_note']) . ')<span>' : '' ). '</label>';
			break;

			case 'spacing':
			$html .= '<br />';
			break;

			case 'note':
			$html .= '<div class="note">' . wpucv_esc($field['label']) . '</div>';
			break;


			case 'pro':
			$html .= '<label class="control-label  ">' . wpucv_esc($field['label']) . '</label><div class="upgrade_note"><span class="upgrade_pro">PRO</span><i>'.esc_html__(' Please upgrade to Pro version to unlock this feature', 'ultimate-content-views').'</i></div>';
			break;
		}

		$html .= ( array_key_exists( 'desc', $field ) && !empty( $field['desc'] ) )? '<span class="wpucv-desc">' . wpucv_esc($field['desc']) . '</span>' : '';

		if( !$repeatable ) {
			$html .= '</div>';
		}

		return $html;
	}


	private static function set_validation_rules( $field_name, $rules ) {
		static::$validation_rules[] = array(
			'name' => $field_name,
			'rules' => $rules,
		);
	}

	private static function render_validation() {
		$rules = array();
		foreach( static::$validation_rules as $field ) {
			$name = str_replace( '[', '\[', $field['name'] );
			$name = str_replace( ']', '\]', $name );
			$rules[] = '"' . $name . '":' . json_encode( (object) $field['rules'] );
		}


		?>
		<script>
		jQuery(function(){
			"use strict";
			jQuery("#post").validate({

				focusCleanup: true,
				ignore: '',
				rules: <?php echo '{' . implode( ',', $rules ) . '}'; ?>, // already escaped in the array variable
				errorPlacement: function(error, element){
					if(element.hasClass('select2')){
						error.html('<?php echo esc_html__(  'This field is required', 'ultimate-content-views' ); ?>');
					}
					element.parent('div').addClass('has-error');
				},
				highlight: function ( element, errorClass, validClass ) {
					jQuery(element).parent('div').addClass('has-error');
				},
				unhighlight: function ( element, errorClass, validClass ) {
					jQuery(element).parent('div').removeClass('has-error');
				}
			});
		});
		</script>
		<?php
	}

	private static function set_field_props( $field, $value ) {
		if( 'repeatable' == $field['type'] ) {
			return;
		}

		static::$fields_values[ $field['name'] ] = $value;
		if( array_key_exists( 'relation', $field ) ) {
			$relation = $field['relation'];
			$relation['child'] = $field['name'];
			$relation['multiple'] = ( array_key_exists( 'multiple', $field ) )? $field['multiple'] : false;
			static::$fields_relations[ $field['relation']['name'] ][] = $relation;
		}
	}

	private static function get_field_value( $name ) {
		return ( array_key_exists( $name, static::$fields_values ) )? static::$fields_values[ $name ] : NULL;
	}

	public static function get_meta_keys( $post_types ) {
		global $wpdb;
		if( empty( $post_types ) ) {
			return array();
		}

		$sql = "SELECT DISTINCT meta_key FROM " . $wpdb->postmeta .
				" WHERE post_id IN (SELECT ID FROM " . $wpdb->posts .
				" WHERE post_type IN ( " . implode( ',', array_fill( 0, count( $post_types ), "'%s'" ) ) . "))";
		$results = $wpdb->get_results( $wpdb->prepare( $sql, $post_types ), OBJECT );
		$keys = array();
		for( $j = 0; $j < count( $results ); $j++ ) {
			if( !is_protected_meta( $results[ $j ]->meta_key ) ) {
				$keys[ $results[ $j ]->meta_key ] = $results[ $j ]->meta_key;
			}
		}

		return $keys;
	}



	public static function save_post_title( $post_id, $post, $update ){
		$list_form_submitted = ( array_key_exists( '_wpucv_list_name', $_POST ) );
		$no_ajax = ( !defined( 'DOING_AJAX' ) || !DOING_AJAX );
		if( $no_ajax && 'wpucv_list' == $post->post_type && $list_form_submitted ) {
			$post_title = ( array_key_exists( '_wpucv_list_name', $_POST ) )? wpucv_sanitizing($_POST['_wpucv_list_name'], 'text') : '';
			$template = ( array_key_exists( '_wpucv_template', $_POST ) )? wpucv_sanitizing($_POST['_wpucv_template']) : '';

			$old_slug = get_post_meta( $post_id, '_wpucv_slug', true );

			$slug = '';
			switch( $template ) {
				case 'template01':
				$slug = 'Classic list with thumbs';
				break;

				case 'template02':
				$slug = 'Classic grid with thumbs';
				break;

				case 'template03':
				$slug = 'Classic list & Top featured post';
				break;

				case 'template04':
				$slug = 'Classic list & Side featured post';
				break;

				case 'template05':
				$slug = 'Grid of small thumbs';
				break;

				case 'template06':
				$slug = 'Modern slider with thumbs';
				break;

				case 'template07':
				$slug = 'Classic simple list';
				break;
			}

			if( empty( $old_slug ) || strpos( $old_slug, $slug ) === false ) {
				$slug = static::generate_list_slug( $slug );
				update_post_meta( $post_id, '_wpucv_funct_call', 'echo wpucv_list(' . $post_id . ');' );
				update_post_meta( $post_id, '_wpucv_slug', $slug );
			}

			remove_action( 'save_post', array(__CLASS__, 'save_meta_fields'), 5 );
			remove_action( 'save_post', array(__CLASS__, 'save_post_title'), 7 );

			$post_data = array(
				'ID'           => $post_id,
				'post_title'   => $post_title,
			);

			$_wpucv_list_parameters = WPUCV_List_Renderer::get_list_parameters( $post_id );
			//print_r($_wpucv_list_parameters);
			//exit();
			update_post_meta( $post_id, '_wpucv_list_parameters', $_wpucv_list_parameters );

			wp_update_post( $post_data );

			add_action( 'save_post', array(__CLASS__, 'save_meta_fields'), 5, 3 );
			add_action( 'save_post', array(__CLASS__, 'save_post_title'), 7, 3 );
		}
	}

	public static function has_empty_val( $arr ){
		foreach( $arr as $key => $val ) {
			if( empty( $val ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Add more images sizes available to administrator media library
	 *
	 * @param array $sizes
	 * @return array
	 */
	public static function image_sizes_dropdown( $sizes ) {
		return array_merge( $sizes, array(
			'wpucv-grid-three'         => '360px by 240px',
			'wpucv-grid-two'           => '600px by 400px',
			'wpucv-grid-one'           => '800px by 533px',
			'wpucv-classic'            => '320px by 170px',
			'wpucv-classic-small'      => '150px by 110px',
			'wpucv-galary'             => '400px by 400px',
		) );
	}

	/**
	 * Generates a unique slug
	 *
	 * @param string $slug
	 * @return string
	 */
	public static function generate_list_slug( $slug ) {
		global $wpdb;

		$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wpucv_slug' AND meta_value REGEXP '^{$slug} [1-9][0-9]*$'";
		$results = $wpdb->get_col( $sql );

		if( count( $results ) > 0 ) {
			$numbers = array();
			foreach( $results as $s ) {
				$numbers[] = str_replace($slug, '', $s );
			}
			asort( $numbers );
			$max = array_pop( $numbers ) + 1;
			return $slug . ' ' . $max;
		}

		return $slug . ' 1';
	}

	public static function set_columns_header( $columns ) {
		$columns['template'] = esc_html__( 'Template', 'ultimate-content-views' );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'ultimate-content-views' );

		return $columns;
	}

	public static function set_columns_values( $column, $post_id ) {
		if( 'template' == $column ) {
			$_wpucv_template = get_post_meta( intval($post_id), '_wpucv_template', true );
			switch( $_wpucv_template ) {
				case 'template01':
				$img = 'temp01.png';
				break;
				case 'template02':
				$img = 'temp02.png';
				break;
				case 'template03':
				$img = 'temp03.png';
				break;
				case 'template04':
				$img = 'temp04.png';
				break;
				case 'template05':
				$img = 'temp05.png';
				break;
				case 'template06':
				$img = 'temp06.png';
				break;
				case 'template07':
				$img = 'temp07.png';
				break;

				default:
				$img = '';
			}


			echo ( $img != '' )? '<img src="' . esc_url(plugins_url( 'images/templates/' . $img, WPUCV_MAIN_FILE )) . '" width="80px" height="53px">' : '';

		}
		elseif( 'shortcode' == $column ) {
			$_wpucv_slug = get_post_meta( $post_id, '_wpucv_slug', true);
			$_wpucv_shortcode = '[wpucv_list id=&quot;' . intval($post_id) . '&quot; title=&quot;' . wpucv_esc($_wpucv_slug) . '&quot;]';

			echo '<span style="background-color: #F1F1F1; padding: 5px 10px;">' . wpucv_esc($_wpucv_shortcode) . '</span>';
		}
	}

	public static function check_list_title( $title, $id ) {
		$post = get_post( $id );
		if( '' == $post->post_title ) {
			return get_post_meta( $id, '_wpucv_slug', true );
		}

		return $title;
	}

	public static function get_post_types() {
		$types = get_post_types( array('public' => true, 'publicly_queryable' => true, 'exclude_from_search' => false), 'objects', 'and' );
		unset( $types['attachment'] );

		$post_types = array();
		foreach( $types as $key => $type ) {
			$post_types[ $key ] = $type->label;
		}

		return $post_types;
	}

	public static function add_action_links( $links ) {
		return array_merge( $links, array('<a href="' . esc_url(admin_url( 'edit.php?post_type=wpucv_list' )) . '">' . esc_html__( 'Manage', 'ultimate-content-views' ) . '</a>') );
	}
}
}