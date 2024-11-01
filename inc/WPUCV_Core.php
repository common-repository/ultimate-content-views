<?php
if( ! class_exists( 'WPUCV_Core' ) ) {
class WPUCV_Core{
	
	/**
	 * Initializing and linking to hooks
	 *
	 * @uses add_action()
	 * @return void
	 */
	public static function init() {
		register_activation_hook( WPUCV_MAIN_FILE, array('WPUCV_Core', 'activation') );
		add_action( 'init', array(__CLASS__, 'register_list') );
		add_action( 'admin_enqueue_scripts', array(__CLASS__, 'admin_scripts') );
		add_action( 'wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'), 99999 );
		add_action( 'wp_ajax_wpucv_img_id_from_url', array(__CLASS__, 'attachment_id_from_url') );
		add_action( 'wp_ajax_wpucv_get_list_page', 'wpucv_get_list_page' );
		add_action( 'wp_ajax_nopriv_wpucv_get_list_page', 'wpucv_get_list_page' );
		add_action( 'wp_ajax_wpucv_prepare_for_preview', array('WPUCV_List_Renderer', 'prepare_for_preview') );
		add_action( 'wp_ajax_wpucv_destroy_preview_session', array('WPUCV_List_Renderer', 'destroy_preview_session') );
		add_action( 'save_post', array('WPUCV_Admin_Panel', 'save_meta_fields'), 5, 3 );
		add_action( 'save_post', array('WPUCV_Admin_Panel', 'save_post_title'), 7, 3 );
		add_action( 'after_setup_theme', array(__CLASS__, 'support_thumbnail'), 8 );
		add_action( 'admin_head', array(__CLASS__, 'admin_head'), 6 );
		add_action( 'wp_head', array(__CLASS__, 'wp_head'), 8 );
		add_filter( 'image_size_names_choose', array('WPUCV_Admin_Panel', 'image_sizes_dropdown') );
		add_shortcode( 'wpucv_list', array('WPUCV_List_Renderer', 'do_list_shortcode') );
		add_filter( 'manage_wpucv_list_posts_columns', array('WPUCV_Admin_Panel', 'set_columns_header'), 5, 1 );
		add_action( 'manage_wpucv_list_posts_custom_column' , array('WPUCV_Admin_Panel', 'set_columns_values'), 5, 2 );
		add_action( 'admin_head-edit.php', array(__CLASS__, 'customize_title_column') );
		add_action( 'wp_ajax_wpucv_list_edit_page', array('WPUCV_Admin_Panel', 'list_edit_page') );
		add_action( 'template_redirect', 'wpucv_handle_preview_request' );
		add_filter( 'plugin_action_links_' . WPUCV_PLUGIN_BASENAME, array('WPUCV_Admin_Panel', 'add_action_links'), 7, 1 );
		add_filter( 'plugin_row_meta', 'wpucv_row_meta', 10, 4 );
	}
	
	/**
	 * Adding thumbnail support
	 *
	 * @uses add_theme_support()
	 * @uses add_image_size()
	 * @return void
	 */
	public static function support_thumbnail() {
		if( !current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		
		
		$sizes = array(
			'wpucv-grid-three'          => array('width' => 360, 'height' => 240, 'crop' => true),
			'wpucv-grid-two'            => array('width' => 600, 'height' => 400, 'crop' => true),
			'wpucv-grid-one'            => array('width' => 800, 'height' => 533, 'crop' => true),
			'wpucv-classic'             => array('width' => 320, 'height' => 170, 'crop' => true),
			'wpucv-classic-small'       => array('width' => 150, 'height' => 110, 'crop' => true),
			'wpucv-galary'              => array('width' => 400, 'height' => 400, 'crop' => true),
		);
		
		foreach( $sizes as $name => $vals ) {
			add_image_size( $name, $vals['width'], $vals['height'], $vals['crop'] );
		}
	}
	
	/**
	 * Register list post type
	 *
	 * @uses post_type_exists()
	 * @uses register_post_type()
	 * @return void
	 */
	public static function register_list() {
		if( !post_type_exists( 'wpucv_list' ) ) {
			$labels = array(
				'name' => esc_html__( 'Posts Lists', 'ultimate-content-views' ),
				'singular_name' => esc_html__( 'Content Views', 'ultimate-content-views' ),
				'add_new' => esc_html__( 'Add New', 'ultimate-content-views' ),
				'add_new_item' => esc_html__( 'Add New List', 'ultimate-content-views' ),
				'edit_item' => esc_html__( 'Edit List', 'ultimate-content-views' ),
				'new_item' => esc_html__( 'New List', 'ultimate-content-views' ),
				'all_items' => esc_html__( 'All Lists', 'ultimate-content-views' ),
				'view_item' => esc_html__( 'View Lists', 'ultimate-content-views' ),
				'search_items' => esc_html__( 'Search Lists', 'ultimate-content-views' ),
				'not_found' => esc_html__( 'No lists found', 'ultimate-content-views' ),
				'not_found_in_trash' => esc_html__( 'No lists found in Trash', 'ultimate-content-views' ),
				'parent_item_colon' => '',
				'menu_name' => esc_html__( 'Display Posts As', 'ultimate-content-views' ),
			);
			
			$args = array(
				'labels' => $labels,
				'description' => "",
				'public' => false,
				'exclude_from_search' => true,
				'publicly_queryable' => false,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_in_admin_bar' => true,
				'menu_position' => 33.335975,
				'menu_icon' => 'dashicons-list-view',
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => false,
				'query_var' => false,
				'rewrite' => false,
				'can_export' => false,
				'register_meta_box_cb' => array('WPUCV_Admin_Panel', 'register_meta_boxes'),
			);
			register_post_type( 'wpucv_list', $args );
		}
	}
	
	/**
	 * Enqueue admin scripts & styles
	 *
	 * @uses wp_enqueue_style()
	 * @uses wp_enqueue_script()
	 * @uses plugins_url()
	 * @return void
	 */
	public static function admin_scripts() {
		if( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if( $screen instanceof WP_Screen && $screen->id == 'wpucv_list' ) {
				wp_enqueue_style( 'bootstrap-wrapper', plugins_url( 'css/bootstrap-wrapper.css', WPUCV_MAIN_FILE ) );
				wp_enqueue_style( 'bootstrap-theme-wrapper', plugins_url( 'css/bootstrap-theme-wrapper.css', WPUCV_MAIN_FILE ) );
				wp_enqueue_style( 'wpucv-admin-style', plugins_url( 'css/admin-style.css', WPUCV_MAIN_FILE ) );
				wp_enqueue_style( 'jquery-ui', plugins_url( 'css/jquery-ui.min.css', WPUCV_MAIN_FILE ) );
				wp_enqueue_style( 'select2', plugins_url( 'css/select2.min.css', WPUCV_MAIN_FILE ) );
				wp_enqueue_style( 'spectrum', plugins_url( 'css/spectrum.css', WPUCV_MAIN_FILE ) );
				
				wp_enqueue_style( 'font-awesome', plugins_url( 'fonts/font-awesome/css/font-awesome.min.css', WPUCV_MAIN_FILE ), array(), '4.7.0' );
				
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'bootstrap', plugins_url( 'js/bootstrap.min.js', WPUCV_MAIN_FILE ), array('jquery'), '3.3.5', true );
				wp_enqueue_script( 'bootstrap-checkbox', plugins_url( 'js/bootstrap-checkbox.min.js', WPUCV_MAIN_FILE ) , array('jquery'), false, true );
				wp_enqueue_script( 'jquery-validation', plugins_url( 'js/jquery.validate.min.js', WPUCV_MAIN_FILE ) , array('jquery'), false, true );
				wp_enqueue_script( 'wpucv-admin-script', plugins_url( 'js/admin-js.js', WPUCV_MAIN_FILE ) , array('jquery'), false, true );
				wp_enqueue_script( 'select2', plugins_url( 'js/select2.min.js', WPUCV_MAIN_FILE ) , array(), false, true );
				wp_enqueue_script( 'spectrum', plugins_url( 'js/spectrum.js', WPUCV_MAIN_FILE ) , array('jquery'), false, true );
				
				$lang = explode( '_', get_locale() );
				if( !empty( $lang[0] ) && file_exists( WPUCV_MAIN_DIR . '/js/select2-i18n/' . $lang[0] . '.js' ) ) {
					wp_enqueue_script( 'select2-lang', plugins_url( 'js/select2-i18n/' . $lang[0] . '.js', WPUCV_MAIN_FILE ) , array(), false, true );
				}
			}
		}
	}
	
	/**
	 * Enqueue scripts & styles
	 *
	 * @uses wp_enqueue_style()
	 * @uses wp_enqueue_script()
	 * @uses plugins_url()
	 * @return void
	 */
	public static function enqueue_scripts() {
		wp_enqueue_style( 'codepress-foundation', plugins_url( 'css/foundation.css', WPUCV_MAIN_FILE ) );
		
		if( is_rtl() ) {
			wp_enqueue_style( 'wpucv-style', plugins_url( 'css/rtl.css', WPUCV_MAIN_FILE ) );
		} else {
			wp_enqueue_style( 'wpucv-style', plugins_url( 'css/style.css', WPUCV_MAIN_FILE ), array(), '1.1' );
			
		}
		
		wp_enqueue_style( 'owl-carousel', plugins_url( 'css/owl.carousel.min.css', WPUCV_MAIN_FILE ) );
		wp_enqueue_style( 'owl-carousel-theme', plugins_url( 'css/owl.theme.default.min.css', WPUCV_MAIN_FILE ) );
		wp_enqueue_style( 'font-awesome', plugins_url( 'fonts/font-awesome/css/font-awesome.min.css', WPUCV_MAIN_FILE ), array(), '4.7.0' );
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'owl-carousel', plugins_url( 'js/owl.carousel.min.js', WPUCV_MAIN_FILE ), array('jquery'), '2.3.4' );
		//wp_enqueue_script( 'owl-carousel', plugins_url( 'js/owl.carousel.min.js', WPUCV_MAIN_FILE ), array('jquery'), '2.3.4', true );
		wp_enqueue_script( 'wpucv-js', plugins_url( 'js/js.js', WPUCV_MAIN_FILE ), array('jquery') );
	}
	
	/**
	 * 
	 *
	 * @return void
	 */
	public static function activation() {
		$upload_dir = wp_upload_dir();
		$dest_dir = $upload_dir['basedir'] . '/wpucv-preview';
		$preview_images_url = $upload_dir['baseurl'] . '/wpucv-preview';
		if( !file_exists( $dest_dir ) ) {
			mkdir( $dest_dir, '0755' );
		}
		
		$demo_posts = file_get_contents( WPUCV_MAIN_DIR . '/inc/preview/dummy-data.json' );
		$demo_posts = json_decode( $demo_posts, true );
		foreach( $demo_posts as $p ) {
			foreach( $p['images'] as $img ) {
				if( !file_exists( $dest_dir . '/' . $img ) ) {
					copy( WPUCV_MAIN_DIR . '/inc/preview/images/' . $img, $dest_dir . '/' . $img );
				}
			}
		}
		
		update_option( 'wpucv_preview_images_url', $preview_images_url );
	}
	
	/**
	 * render attachment id for ajax call
	 *
	 * @return void
	 */
	public static function attachment_id_from_url() {
		$url = ( array_key_exists( 'url', $_POST ) )? wpucv_sanitizing($_POST['url'], 'url') : NULL;
		if( !empty( $url ) ) {
			$id = static::get_attachment_id_from_url( $url );
			echo json_encode( array('id' => $id) );
		}
		exit;
	}
	
	public static function admin_head() {
		?>
		<script>
			"use strict";
			var wpucv_admin_url = '<?php echo esc_js(admin_url( 'admin-ajax.php' )); ?>';
			var wpucv_home_url = '<?php echo esc_js(home_url()); ?>';
		</script>
		<?php
		
		if( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if( $screen instanceof WP_Screen && $screen->id == 'wpucv_list' ) {
			?>
			<?php
			}
		}
	}
	
	public static function wp_head() {
		?>
		<script>
		"use strict";
			var wpucv_admin_url = '<?php echo esc_js(admin_url( 'admin-ajax.php' )); ?>';
		</script>
		<?php
	}
	
	public static function customize_title_column() {
		add_filter( 'the_title', array('WPUCV_Admin_Panel', 'check_list_title'), 159, 2 );
	}
}
}

if (!function_exists('wpucv_sanitizing')) {
function wpucv_sanitizing($unsafe_val,$type='text')
{
    
   	
	 switch ($type) {
	   case 'text': return sanitize_text_field($unsafe_val);
	   break;
	   
	   case 'int': return intval($unsafe_val);
	   break;
	   
	   case 'email': return sanitize_email($unsafe_val);
	   break;
	   
	   case 'filename': return sanitize_file_name($unsafe_val);
	   break;
	   
	   case 'title': return sanitize_title($unsafe_val);
	   break; 
       
       case 'url': return esc_url($unsafe_val);
	   break;
	      
	   default:
        return sanitize_text_field($unsafe_val);
	   
	   }
}
}

if (!function_exists('wpucv_row_meta')) {
function wpucv_row_meta( $meta_fields, $file ) {

      if ( strpos($file,'ultimate-content-views.php') == false) {

        return $meta_fields;
      }

      echo "<style>.pluginrows-rate-stars { display: inline-block; color: #ffb900; position: relative; top: 3px; }.pluginrows-rate-stars svg{ fill:#ffb900; } .pluginrows-rate-stars svg:hover{ fill:#ffb900 } .pluginrows-rate-stars svg:hover ~ svg{ fill:none; } </style>";

      $plugin_rate   = "https://wordpress.org/support/plugin/ultimate-content-views/reviews/?rate=5#new-post";
      $plugin_filter = "https://wordpress.org/support/plugin/ultimate-content-views/reviews/?filter=5";
      $svg_xmlns     = "https://www.w3.org/2000/svg";
      $svg_icon      = '';

      for ( $i = 0; $i < 5; $i++ ) {
        $svg_icon .= "<svg xmlns='" . esc_url( $svg_xmlns ) . "' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>";
      }

      $meta_fields[] = '<a href="' . esc_url( $plugin_filter ) . '" target="_blank"><span class="dashicons dashicons-thumbs-up"></span>' . __( 'Vote!', 'pluginrows' ) . '</a>';
      $meta_fields[] = "<a href='" . esc_url( $plugin_rate ) . "' target='_blank' title='" . esc_html__( 'Rate', 'pluginrows' ) . "'><i class='pluginrows-rate-stars'>" . $svg_icon . "</i></a>";

      return $meta_fields;
    }
}	
if (!function_exists('wpucv_esc')) {	
function wpucv_esc($unsafe_val,$type='html')
{
   	
	 switch ($type) {
	   case 'html': return esc_html($unsafe_val);
	   break;
	   
	   default:
        return esc_html($unsafe_val);
	   
	   }
}
}