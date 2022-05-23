<?php
defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: Promo Nft
 * Plugin URI: <>
 * Description: PromoNFT is a plug-in to serve promo-nft.com and display NFT's, help manage the NFT collections and set some new ones up. Currently the plug-in is still under development and more features will be added.
 * Version: 1.0.4.2
 * Author: Kevin Schuit
 * Author URI: https://kevinschuit.com
 * Text Domain: PromoNft
 * Domain Path: /lang/
 */
 define ( 'PROMO_NFT_PLUGIN', __FILE__ );

 require_once plugin_dir_path ( __FILE__ ) . 'includes/defs.php';
 require_once( 'BFIGitHubPluginUploader.php' );

    register_activation_hook( __FILE__, array( 'PromoNft', 'on_activation' ) );
    register_deactivation_hook( __FILE__, array( 'PromoNft', 'on_deactivation' ) );
 
 class PromoNft
 {
     public function __construct()
     {
         do_action('PROMO_NFT_pre_init');

         add_action('init', array($this, 'init'), 1);
     }

     public static function on_activation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "activate-plugin_{$plugin}" );
         PromoNft::createDb();
         PromoNft::createImageDirectory();
     }
     public static function on_deactivation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "deactivate-plugin_{$plugin}" );

     }

     public static function createImageDirectory(){
        if ( ! is_dir( ABSPATH . 'wp-content/uploads/promo-nft-images' ) ) {
            wp_mkdir_p( ABSPATH . 'wp-content/uploads/promo-nft-images' );
          }
     }

     public function init()
     {
        add_filter( 'plugin_row_meta', [$this, 'custom_plugin_row_meta'], 10, 2 );
         do_action('PROMO_NFT_init');
         if (is_admin()) {
             $this->requireAdmin();
             $this->createAdmin();
             new BFIGitHubPluginUpdater( __FILE__, 'MrXenon', "promo-nft" );
             
         } else {
            wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
            wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.esm.js');
            wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/js/bootstrap.js');
            wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');
            wp_register_script('functions', plugins_url('bootstrap-5.1.3-dist/jquery/functions.js'  , __FILE__ ),'','1.0',true);
            wp_enqueue_script('functions', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/functions.js');
            wp_enqueue_script('jquery', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/jquery/jquery.js');

            wp_enqueue_style('bootstrap5', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap.css');
            wp_enqueue_style('bootstrap6', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
            wp_enqueue_style('bootstrap7', plugin_dir_url(__FILE__).'bootstrap-5.1.3-dist/css/bootstrap-grid.css');
            wp_enqueue_style('css', plugin_dir_url(__FILE__).'css/style.css');
         }
         $this->loadViews();
     }

     public function custom_plugin_row_meta( $links, $file ) 
    {
        if ( strpos( $file, 'promo-nft.php' ) !== false ) {
	    $new_links = array(
            '<a href="'.admin_url().'admin.php?page=nft_support">Support</a>',
               '<a href="'.admin_url().'admin.php?page=nft_dashboard">Dashboard</a>'
			);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
    }
     public function requireAdmin()
     {
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
		 $shortcodes		=	 $wpdb->prefix . "nft_shortcodes";
		 $author			=	 $wpdb->prefix . "nft_author";
		 $updateLog			=	 $wpdb->prefix . "nft_update";
         $listings          =    $wpdb->prefix . "nft_listings";
         $choice            =    $wpdb->prefix . "nft_choice";

         $sql = "CREATE TABLE IF NOT EXISTS $colnet (
            colnet_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            colnet_name VARCHAR(64) NOT NULL,
            colnet_desc VARCHAR(1024) NOT NULL,
            archive BIT(1) NOT NULL,
            PRIMARY KEY  (colnet_id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $wpdb->query("DROP TABLE $shortcodes");

		 $sql = "CREATE TABLE IF NOT EXISTS $shortcodes (
            sid BIGINT(11) NOT NULL AUTO_INCREMENT,
            short_name VARCHAR(64) NOT NULL,
            short_desc VARCHAR(1024) NOT NULL,
            PRIMARY KEY  (sid))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $wpdb->query("DROP TABLE $author");

		 $sql = "CREATE TABLE IF NOT EXISTS $author (
            aid BIGINT(11) NOT NULL AUTO_INCREMENT,
            author_name VARCHAR(64) NOT NULL,
			author_email VARCHAR(64) NOT NULL,
			author_website VARCHAR(64) NOT NULL,
            PRIMARY KEY  (aid))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);


        $wpdb->query("DROP TABLE $updateLog");

        $sql = "CREATE TABLE IF NOT EXISTS $updateLog (
            uid BIGINT(11) NOT NULL AUTO_INCREMENT,
            update_version VARCHAR(64) NOT NULL,
            update_desc VARCHAR(2048) NOT NULL,
            update_list TEXT(2048) NOT NULL,
            future_desc VARCHAR(2048) NOT NULL,
            PRIMARY KEY  (uid))
            ENGINE = InnoDB $charset_collate";
        dbDelta($sql);    

        $wpdb->query("DROP TABLE $choice");

        $sql = "CREATE TABLE IF NOT EXISTS $choice (
            choice_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            choice_name VARCHAR(64) NOT NULL,
            choice_var VARCHAR(1) NOT NULL,
            PRIMARY KEY  (choice_id))
            ENGINE = InnoDB $charset_collate";
        dbDelta($sql);    

        $wpdb->query("DROP TABLE $collect");

         $sql = "CREATE TABLE IF NOT EXISTS $collect (
            collect_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            collect_img VARCHAR(255) NOT NULL,
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
            collect_featured varchar(4) NOT NULL,
            archive BIT(1) NOT NULL,
            PRIMARY KEY  (collect_id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $wpdb->query("DROP TABLE $listings");

         $sql = "CREATE TABLE IF NOT EXISTS $listings (
            listing_id BIGINT(11) NOT NULL AUTO_INCREMENT,
            listing_project VARCHAR(255) NOT NULL,
            listing_name VARCHAR(255) NOT NULL,
            listing_email VARCHAR(255) NOT NULL,
            listing_desc VARCHAR(1024) NOT NULL,
            listing_mintdate DATETIME NOT NULL,
            listing_presale DATE NOT NULL,
            listing_network BIGINT(11) NOT NULL,
            listing_minprice VARCHAR(255) NOT NULL,
            listing_supply INT(11) NOT NULL,
            listing_twitter VARCHAR(255) NOT NULL,
            listing_discord VARCHAR(255) NOT NULL,
            listing_website VARCHAR(255) NOT NULL,
            listing_image VARCHAR(255) NOT NULL,
            listing_featured VARCHAR(1) NOT NULL,
            deleted BIT(1) NOT NULL,
            PRIMARY KEY  (listing_id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

		$sql = "INSERT INTO `$shortcodes` (`sid`, `short_name`,`short_desc`) VALUES
            (1, '[nft_featured_items]','This shortcode displays the featured items. Include this on your page in order to display the featured content.'),
            (2, '[nft_single]','This shortcode displays the single page content, this shortcode is automaticly included on each page, created when adding a new network.'),
            (3, '[nft_add_collection]','This shortcode displays the form in which people can submit their own collection');";
        dbDelta($sql);

        $sql = "INSERT INTO `$choice` (`choice_id`, `choice_name`,`choice_var`) VALUES
            (1, 'Yes','1'),
            (2, 'No','0');";
        dbDelta($sql);
        

		$sql = "INSERT INTO `$author` (`aid`, `author_name`,`author_email`,`author_website`) VALUES
		    (1, 'Kevin Schuit','info@kevinschuit.com','https://kevinschuit.com');";
		dbDelta($sql);

            $sql = "INSERT INTO `$updateLog` (`uid`, `update_version`,`update_desc`,`update_list`,`future_desc`) VALUES
                (1, 'V1.0.1','Base version of the Promo NFT plug-in. This plug-in makes it available for the user to create new NFT networks, create new NFT collection, archive and publish these networks and collections and display them on the front-end by using a shortcode, which is issued by the plug-in itself.',
                '<li>Create a network.</li><li>Create a NFT collection.</li>
                <li>Archive a network.</li>
                <li>Archive a NFT collection.</li>
                <li>Publish a network.</li>
                <li>Publish a NFT collection.</li>
                <li>Update a network.</li>
                <li>Update a NFT collection.</li>
                <li>Delete a network when archived.</li>
                <li>Delete a NFT collection when archived.</li>
                <li>Sorted display on the front-end, between archived items and published items.</li>
                <li>Display featured items.</li>
                <li>Display a NFT collecton on their respective page.</li>', 
                'Next update will add a form for users, in which they can add their own NFT collection, which then has to be verified by the owner.'),

                (2, 'V1.0.2','Updates to the backend of the system, cleaned out some redundant code and initialized data on plug-in installation, which is used throughout the system',
                '<li>Added a support form for the site owner.</li>
                <li>Dynamic loading of plugin name, changelog & author in dashboard.</li>
                <li>Added an icon & banner to the plug-in description.</li>
                <li>Cleaned up code</li>', 
                'Next update will add a form for users, in which they can add their own NFT collection, which then has to be verified by the owner.'),

                (3, 'V1.0.3','Updated front-end generated form, image existence check, listing validation and some script fixes.',
                '<li>Added a Generate collection form button in the dasboard.</li>
                <li>Added the Generate collection form to the front-end add-collection-form page.</li>
                <li>Generate the add-collection-form page on click in dashboard.</li>
                <li>Added NFT Listings to the backend, this displays the current listings.</li>
                <li>Added a choice table to the database in which you can call yes or no values.</li>', 
                'Next update will add the abillity to confirm listings.'),

                (4, 'V1.0.4','Implemented a check on the uploaded image, if exists, it will rename the image and store the new name in the save function. Front-end listings can now be submitted into the existing collections. ',
                '<li>Implemented a check on the uploaded image, if exists, it will rename the image and store the new name in the save function.</li>
                <li>Added the Generate collection form to the front-end add-collection-form page.</li>
                <li>Front-end listings can now be submitted into the existing collections. </li>
                <li>Front-end images also check in the same format as with the same name as the collection form in the database.</li>
                <liMoved the network drop page script to the networks in the archive.</li>
                <li>Updated the update script.</li>
                <li>Added scss for the promo-nft.com styles to accomodate our front-end.</li>
                <li>Wrote some more checks on scripts in order to validate them before accepting their input.</li>
                <li>Moved images folder out of the plug-in, it will be generated in plug-in install in the wp-uploads folder with their own folder.</li>', 
                'Next update will clean up some code.'),

                (5, 'V1.0.4.1','Small price update',
                '<li>Changed price & supply column width on NftSingle</li>', 
                'Next update will clean up some code.'),

                (6, 'V1.0.4.2','Fixed a minor bug with the image update & listings',
                '<li>Set image update to retrieve its actual image name & set it to store with a new name if updated name exists, unless image is not updated</li>
                <li>Gave the listings table a deleted column, deleted column was implemented but not set to be created in the database, which caused the listings to not save.</li>', 
                'Next update depending on test results.'

                
                );";

            dbDelta($sql);
		}
 }
 $promo_nft = new PromoNft();
 ?>