<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
 class PromoNft_AdminController {

    static function prepare() {

        if ( is_admin() ) :

            // add_action( 'admin_menu', array( 'PromoNft_AdminController', 'addMenus' ) );
            add_action( 'admin_menu', array('PromoNft_AdminController', 'add_my_admin_menus') );
        endif;
    }

     // hook so we can add menus to our admin left-hand menu

             /**
              * Create the administration menus in the left-hand nav and load the JavaScript conditionally only on that page
              */
            static function add_my_admin_menus(){
                $my_page_1 = add_menu_page( __( 'Promo Nft', 'promo-nft'),__( 'Promo Nft', 'promo-nft' ),'','promo-nft-admin',array( 'PromoNft_AdminController', 'adminMenuPage'),'https://www.kevinschuit.com/images/20x20logoWit.png','3');
                $my_page_2 = add_submenu_page ('promo-nft-admin',__( 'Dashboard', 'promo-nft' ),__( 'Dashboard', 'promo-nft'),'manage_options','nft_dashboard', array( 'PromoNft_AdminController', 'nftDashboard'));
                $my_page_3 = add_submenu_page ('promo-nft-admin',__( 'Collection Network', 'promo-nft' ),__( 'Collection Network', 'promo-nft'),'manage_options','nft_colnet', array( 'PromoNft_AdminController', 'nftCollectionNetwork'));
                if(PromoNft_AdminController::getNrOfCollectionNetworks() > 1){
                $my_page_4 = add_submenu_page ('promo-nft-admin',__( 'NFT Collections', 'promo-nft' ), __( 'NFT Collections', 'promo-nft'),'manage_options','nft_collections', array( 'PromoNft_AdminController', 'nftCollections'));
                }
                $my_page_5 = add_submenu_page ('promo-nft-admin',__( 'Archive', 'promo-nft' ),__( 'Archive', 'promo-nft'),'manage_options', 'nft_archive', array( 'PromoNft_AdminController', 'nftCollectionArchive'));
                $my_page_6 = add_submenu_page ('promo-nft-admin',__( 'Support', 'promo-nft' ),__( 'Support', 'promo-nft'),'manage_options', 'nft_support', array( 'PromoNft_AdminController', 'nftSupport'));
                 // Load the JS conditionally
                 add_action( 'load-' . $my_page_1,array('PromoNft_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_2,array('PromoNft_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_3,array('PromoNft_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_4,array('PromoNft_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_5,array('PromoNft_AdminController', 'load_admin_js') );
                 add_action( 'load-' . $my_page_6,array('PromoNft_AdminController', 'load_admin_js') );
             }
         
             // This function is only called when our plugin's page loads!
            static function load_admin_js(){
                 // Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
                 add_action( 'admin_enqueue_scripts',array('PromoNft_AdminController','enqueue_admin_js') );
             }
         
            static function enqueue_admin_js(){
                 // Isn't it nice to use dependencies and the already registered core js files?
                 wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
                 wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.esm.js');
                 wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.js');
                 wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');

                 wp_enqueue_style('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap.css');
                 wp_enqueue_style('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
                 wp_enqueue_style('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-grid.css');
                 wp_enqueue_style('css', plugin_dir_url(__FILE__).'../css/style.css');
             }


    static function getNrOfCollectionNetworks(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $wpdb->prefix ."nft_colnet"."`";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

        /**
        * The main menu page
         */
            static function adminMenuPage() {
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
            }
            static function nftDashboard (){
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/nft_dashboard.php';
            }
            static function nftCollectionNetwork (){
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/nft_colnet.php';
            }
            static function nftCollections (){
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/nft_collections.php';
            }
            static function nftCollectionArchive(){
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/nft_archive.php';
            }
            static function nftSupport(){
                include PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR . '/nft_support.php';
            }
    }
?>