<?php

defined( 'ABSPATH' ) OR exit;

/**
 * Plugin Name: PromoNft
 * Plugin URI: <>
 * Description: TODO:: ADD TEKST
 * Version: 1.0.0
 * Author: Kevin Schuit
 * Author URI: https://kevinschuit.com
 * Text Domain: PromoNft
 * Domain Path: /lang/
 */

 //Define the plugin name:
 //Activeren en deactiveren
 define ( 'PROMO_NFT_PLUGIN', __FILE__ );

 //Inculde the general defenition file:
 require_once plugin_dir_path ( __FILE__ ) . 'includes/defs.php';
 // Plugin update script
 require_once( PROMO_NFT_PLUGIN_MODEL_DIR . '/BFIGitHubPluginUploader.php' );

/* Register the hooks */
    register_activation_hook( __FILE__, array( 'PromoNft', 'on_activation' ) );
    register_deactivation_hook( __FILE__, array( 'PromoNft', 'on_deactivation' ) );
 
 class PromoNft
 {
     public function __construct()
     {

         //Fire a hook before the class is setup.
         do_action('PROMO_NFT_pre_init');

         //Load the plugin
         add_action('init', array($this, 'init'), 1);
     }

     public static function on_activation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "activate-plugin_{$plugin}" );

         // Add the theme capabilities
         PromoNft::createDb();
     }
     public static function on_deactivation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "deactivate-plugin_{$plugin}" );

     }

     /**
      * Loads the plugin into Wordpress
      *
      * @since 1.0.0
      */
     public function init()
     {

        // Toon extra links in de plug-in description.
        add_filter( 'plugin_row_meta', [$this, 'custom_plugin_row_meta'], 10, 2 );
         // Run hook once Plugin has been initialized
         do_action('PROMO_NFT_init');

         // Load admin only components.
         if (is_admin()) {

             //Load all admin specific includes
             $this->requireAdmin();

             //Setup admin page
             $this->createAdmin();
             // Load backend scripts
             
             new BFIGitHubPluginUpdater( __FILE__, 'MrXenon', "promo-nft" );
         } else {
             // Load front-end scripts
            wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
            wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.esm.js');
            wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.js');
            wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');
            wp_enqueue_script('functions', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/functions.js');
            wp_enqueue_script('jquery', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/jquery.js');

            wp_enqueue_style('bootstrap5', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap.css');
            wp_enqueue_style('bootstrap6', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
            wp_enqueue_style('bootstrap7', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap-grid.css');
            wp_enqueue_style('css', plugin_dir_url(__FILE__).'css/style.css');
         }

         // Load the view shortcodes
         $this->loadViews();
     }

     public function custom_plugin_row_meta( $links, $file ) 
    {
        if ( strpos( $file, 'promo-nft.php' ) !== false ) {
	    $new_links = array(
            '<a href="mailto:info@kevinschuit.com" target="_blank">Support</a>',
               '<a href="'.admin_url().'admin.php?page=changelog">Changelog</a>'
			);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
    }
     public function requireAdmin()
     {

         //Admin controller file
         require_once PROMO_NFT_PLUGIN_ADMIN_DIR . '/PromoNft_AdminController.php';
     }

     public function createAdmin()
     {
         PromoNft_AdminController::prepare();
     }

     public function loadViews()
     {
         include PROMO_NFT_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
     }

     public static function createDb()
     {

         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

         global $wpdb;

         $charset_collate = $wpdb->get_charset_collate();

         $colnet            =    $wpdb->prefix . "nft_colnet";
         $collect           =    $wpdb->prefix . "nft_collect";


         $sql = "CREATE TABLE IF NOT EXISTS $colnet (
            colnet_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            colnet_name VARCHAR(64) NOT NULL,
            colnet_desc VARCHAR(1024) NOT NULL,
            archive BIT(1) NOT NULL,
            PRIMARY KEY  (colnet_id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $sql = "CREATE TABLE IF NOT EXISTS $collect (
            collect_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            collect_title VARCHAR(64) NOT NULL,
            collect_desc VARCHAR(1024) NOT NULL,
            collect_date DATETIME NOT NULL,
            collect_predate DATE NOT NULL,
            fk_colnet_id BIGINT(11) NOT NULL,
            collect_supply INT(11) NOT NULL,
            collect_site VARCHAR(255) NOT NULL,
            collect_twitter VARCHAR(255) NOT NULL,
            collect_discord VARCHAR(255) NOT NULL,
            collect_price VARCHAR(255) NOT NULL,
            collect_featured BIT(1) NOT NULL,
            archive BIT(1) NOT NULL,
            PRIMARY KEY  (collect_id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);
     }

 }

 $promo_nft = new PromoNft();
 ?>
