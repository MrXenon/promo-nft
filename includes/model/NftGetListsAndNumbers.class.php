<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftTables.class.php';
class NftgetListsAndNumbers{

/**---------------------------------------------------------------------------------------------------------------------------------------- */
    public function __construct(){
        $this->nftTables            = new NftTables();
    }
    // Define tables
    private function getNftPrefix(){return $this->nftTables->getNftPrefix();}
    private function getCollectionNetworkTable(){return $this->nftTables->getCollectionNetworkTable();}
    private function getCollectionsTable(){return $this->nftTables->getCollectionsTable();}
    private function getShortcodesTable(){return $this->nftTables->getShortcodesTable();}
    private function getAuthorTable(){return $this->nftTables->getAuthorTable();}
    private function getUpdateLogTable(){return $this->nftTables->getUpdateLogTable();}
    private function getChoiceTable(){return $this->nftTables->getChoiceTable(); }
    private function getListingTable(){return $this->nftTables->getListingTable();}

    public function getNrOfCollectionNetworks(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionNetworkTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getColnetId($page){

        global $wpdb;
        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionNetworkTable()."` WHERE `colnet_name` = '".$page."'", ARRAY_A );

        foreach ($result_array as $array) {
            $colnetId = $array['colnet_id'];
        }

        return $colnetId;
    }

    public function getNrOfCollections(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionsTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getNrOfListings(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getListingTable()."` WHERE `deleted`=0";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getNrOfArchivedCollections(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionsTable()."` WHERE `archive`=1";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getNrOfArchivedNetworks(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionNetworkTable()."` WHERE `archive`=1";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getNrOfPageCollections($pageId){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionsTable()."` WHERE `fk_colnet_id`=$pageId";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }
    

    public function getNrOfFeaturedCollections(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getCollectionsTable()."` WHERE `collect_featured` ='on'";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getCollectionNetworkList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionNetworkTable() ."` WHERE `archive`=0 ORDER BY `colnet_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setNetworkId($array['colnet_id']);
            $Network->setNetworkName($array['colnet_name']);
            $Network->setNetworkDescription($array['colnet_desc']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getChoiceList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getChoiceTable() ."` ORDER BY `choice_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Choice = new NftPromoModel();
            // Set all info
            $Choice->setChoiceId($array['choice_id']);
            $Choice->setChoice($array['choice_name']);
            $Choice->setChoiceVar($array['choice_var']);

            // Add new object toe return array.
            $return_array[] = $Choice;
        }
        return $return_array;
    }

    public function getCollectionNetworkArchive(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionNetworkTable() ."` WHERE `archive`=1 ORDER BY `colnet_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setNetworkId($array['colnet_id']);
            $Network->setNetworkName($array['colnet_name']);
            $Network->setNetworkDescription($array['colnet_desc']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getCollectionList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionsTable() ."` WHERE `archive`=0 ORDER BY `collect_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setCollectionId($array['collect_id']);
            $Network->setCollectionImage($array['collect_img']);
            $Network->setCollectionTitle($array['collect_title']);
            $Network->setCollectionDescription($array['collect_desc']);
            $Network->setCollectionDate($array['collect_date']);
            $Network->setCollectionPreDate($array['collect_predate']);
            $Network->setCollectionNetwork($array['fk_colnet_id']);
            $Network->setCollectionSupply($array['collect_supply']);
            $Network->setCollectionSite($array['collect_site']);
            $Network->setCollectionTwitter($array['collect_twitter']);
            $Network->setCollectionDiscord($array['collect_discord']);
            $Network->setCollectionPrice($array['collect_price']);
            $Network->setCollectionFeatured($array['collect_featured']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getListings(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getListingTable() ."` WHERE `deleted` = 0 ORDER BY `listing_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Listing = new NftPromoModel();
            // Set all info
            $Listing->setListingId($array['listing_id']);
            $Listing->setListingProject($array['listing_project']);
            $Listing->setListingName($array['listing_name']);
            $Listing->setListingEmail($array['listing_email']);
            $Listing->setListingDescription($array['listing_desc']);
            $Listing->setListingMintDate($array['listing_mintdate']);
            $Listing->setListingPreSale($array['listing_presale']);
            $Listing->setListingNetwork($array['listing_network']);
            $Listing->setListingMinPrice($array['listing_minprice']);
            $Listing->setListingSupply($array['listing_supply']);
            $Listing->setListingTwitter($array['listing_twitter']);
            $Listing->setListingDiscord($array['listing_discord']);
            $Listing->setListingWebsite($array['listing_website']);
            $Listing->setListingImage($array['listing_image']);
            $Listing->setListingFeatured($array['listing_featured']);

            // Add new object toe return array.
            $return_array[] = $Listing;
        }
        return $return_array;
    }

    public function getPageCollectionList($pageId){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionsTable() ."` WHERE `archive`=0 AND `fk_colnet_id`=$pageId ORDER BY `collect_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setCollectionId($array['collect_id']);
            $Network->setCollectionImage($array['collect_img']);
            $Network->setCollectionTitle($array['collect_title']);
            $Network->setCollectionDescription($array['collect_desc']);
            $Network->setCollectionDate($array['collect_date']);
            $Network->setCollectionPreDate($array['collect_predate']);
            $Network->setCollectionNetwork($array['fk_colnet_id']);
            $Network->setCollectionSupply($array['collect_supply']);
            $Network->setCollectionSite($array['collect_site']);
            $Network->setCollectionTwitter($array['collect_twitter']);
            $Network->setCollectionDiscord($array['collect_discord']);
            $Network->setCollectionPrice($array['collect_price']);
            $Network->setCollectionFeatured($array['collect_featured']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getPageNftCollectionList($nft){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionsTable() ."` WHERE `archive`=0 AND `collect_id`=$nft", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setCollectionId($array['collect_id']);
            $Network->setCollectionImage($array['collect_img']);
            $Network->setCollectionTitle($array['collect_title']);
            $Network->setCollectionDescription($array['collect_desc']);
            $Network->setCollectionDate($array['collect_date']);
            $Network->setCollectionPreDate($array['collect_predate']);
            $Network->setCollectionNetwork($array['fk_colnet_id']);
            $Network->setCollectionSupply($array['collect_supply']);
            $Network->setCollectionSite($array['collect_site']);
            $Network->setCollectionTwitter($array['collect_twitter']);
            $Network->setCollectionDiscord($array['collect_discord']);
            $Network->setCollectionPrice($array['collect_price']);
            $Network->setCollectionFeatured($array['collect_featured']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getCollectionFeaturedList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionsTable() ."` WHERE `collect_featured`= 'on' ORDER BY `collect_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setCollectionId($array['collect_id']);
            $Network->setCollectionImage($array['collect_img']);
            $Network->setCollectionTitle($array['collect_title']);
            $Network->setCollectionDescription($array['collect_desc']);
            $Network->setCollectionDate($array['collect_date']);
            $Network->setCollectionPreDate($array['collect_predate']);
            $Network->setCollectionNetwork($array['fk_colnet_id']);
            $Network->setCollectionSupply($array['collect_supply']);
            $Network->setCollectionSite($array['collect_site']);
            $Network->setCollectionTwitter($array['collect_twitter']);
            $Network->setCollectionDiscord($array['collect_discord']);
            $Network->setCollectionPrice($array['collect_price']);
            $Network->setCollectionFeatured($array['collect_featured']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getCollectionArchive(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getCollectionsTable() ."` WHERE `archive`=1 ORDER BY `collect_id`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setCollectionId($array['collect_id']);
            $Network->setCollectionImage($array['collect_img']);
            $Network->setCollectionTitle($array['collect_title']);
            $Network->setCollectionDescription($array['collect_desc']);
            $Network->setCollectionDate($array['collect_date']);
            $Network->setCollectionPreDate($array['collect_predate']);
            $Network->setCollectionNetwork($array['fk_colnet_id']);
            $Network->setCollectionSupply($array['collect_supply']);
            $Network->setCollectionSite($array['collect_site']);
            $Network->setCollectionTwitter($array['collect_twitter']);
            $Network->setCollectionDiscord($array['collect_discord']);
            $Network->setCollectionPrice($array['collect_price']);
            $Network->setCollectionFeatured($array['collect_featured']);
            $Network->setNetworkArchive($array['archive']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getNftShortcodes(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getShortcodesTable() ."`  ORDER BY `sid`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setShortcodeId($array['sid']);
            $Network->setShortcodeName($array['short_name']);
            $Network->setShortcodeDesc($array['short_desc']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getNftAuthor(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getAuthorTable() ."`  ORDER BY `aid`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setAuthorId($array['aid']);
            $Network->setAuthorName($array['author_name']);
            $Network->setAuthorMail($array['author_email']);
            $Network->setAuthorSite($array['author_website']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getNftUpdateLog(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getUpdateLogTable() ."`  ORDER BY `uid`", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setUpdateId($array['uid']);
            $Network->setUpdateVersion($array['update_version']);
            $Network->setUpdateDesc($array['update_desc']);
            $Network->setUpdateList($array['update_list']);
            $Network->setUpdateFdesc($array['future_desc']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getNftChangeLog(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getUpdateLogTable() ."` ORDER BY `uid` DESC LIMIT 1", ARRAY_A);

        // For all database results:
        foreach ( $result_array as $idx => $array){
        // New object
            $Network = new NftPromoModel();
            // Set all info
            $Network->setUpdateId($array['uid']);
            $Network->setUpdateVersion($array['update_version']);
            $Network->setUpdateDesc($array['update_desc']);
            $Network->setUpdateList($array['update_list']);
            $Network->setUpdateFdesc($array['future_desc']);

            // Add new object toe return array.
            $return_array[] = $Network;
        }
        return $return_array;
    }

    public function getNetworkById($id) {
        //Calling wpdb
        global $wpdb;
        //Setting var as an array
        //Database query
        $result_array = $wpdb->get_results( "SELECT * FROM " . $this->getCollectionNetworkTable() . " WHERE  colnet_id = $id", ARRAY_A );
        // Loop through images
        foreach ($result_array as $array) {
            $colnetName = $array['colnet_name'];
        }
        // Return array
        return $colnetName;
    }

    public function getChoiceById($id) {
        //Calling wpdb
        global $wpdb;
        //Setting var as an array
        //Database query
        $result_array = $wpdb->get_results( "SELECT * FROM " . $this->getChoiceTable() . " WHERE  choice_var = $id", ARRAY_A );
        // Loop through images
        foreach ($result_array as $array) {
            $choiceName = $array['choice_name'];
        }
        // Return array
        return $choiceName;
    }
}
?>