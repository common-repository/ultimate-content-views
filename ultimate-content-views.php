<?php
/*
 * Plugin Name: Display Posts As List, Grid, Thumbs
 * Plugin URI: https://wordpress.org/plugins/ultimate-content-views/
 * Description: The plugin (Display Posts As List, Grid, Thumbs) for WordPress gives you an easy-to-use plugin to make lists of posts, using this plugin you will be able to list posts by category in a post or page using the short-code.
 * Author: wp-buy
 * Text Domain: ultimate-content-views
 * Version: 4.4
 * Author URI: https://www.wp-buy.com
 * License: GPL2
 */

define( 'WPUCV_MAIN_FILE', __FILE__ );
define( 'WPUCV_MAIN_DIR', dirname(__FILE__) );
define( 'WPUCV_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );


if (!function_exists('WPLCPPRO_deactivate_pro_plugin')) {
    function WPLCPPRO_deactivate_pro_plugin(){
        if ( is_plugin_active( 'advanced-content-viewer-pro/advanced-content-viewer.php' ) )
        {
            deactivate_plugins('advanced-content-viewer-pro/advanced-content-viewer.php');
        }
    }
    register_activation_hook(__FILE__, 'WPLCPPRO_deactivate_pro_plugin');
}

require_once( WPUCV_MAIN_DIR . '/inc/WPUCV_Core.php' );
require_once( WPUCV_MAIN_DIR . '/inc/WPUCV_Admin_Panel.php' );
require_once( WPUCV_MAIN_DIR . '/inc/WPUCV_List_Renderer.php' );

WPUCV_Core::init();