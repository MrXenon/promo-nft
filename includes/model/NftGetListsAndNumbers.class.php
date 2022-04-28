<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class NftgetListsAndNumbers{
        // Define tables
        private function getNftPrefix(){
            return $prefix = 'nft_';
        }
        
        private function getCollectionNetworkTable(){
            global $wpdb;
            return $table = $wpdb->prefix .$this->getNftPrefix(). "colnet";
        }
    
        
        private function getCollectionsTable(){
            global $wpdb;
            return $table = $wpdb->prefix .$this->getNftPrefix(). "collect";
        }
/**---------------------------------------------------------------------------------------------------------------------------------------- */

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
}
?>