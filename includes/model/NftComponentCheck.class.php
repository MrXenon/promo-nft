<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftTables.class.php';
class NftComponentCheck{
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
/**---------------------------------------------------------------------------------------------------------------------------------------- */
    public function checkNetworkName($input_array){
        global $wpdb;
        $colName = $input_array['CollectionName'];
        if(null === $wpdb->get_row("SELECT * FROM `".$this->getCollectionNetworkTable()."` WHERE `colnet_name` ='$colName'")){
            return TRUE;
        }
    }

    public function checkProjectName($input_array){
        global $wpdb;
        $ProjectName = $input_array['projectProjectName'];
        if(null === $wpdb->get_row("SELECT * FROM `".$this->getListingTable()."` WHERE `listing_project` ='$ProjectName'")){
            if(null === $wpdb->get_row("SELECT * FROM `".$this->getCollectionsTable()."` WHERE `collect_title` ='$ProjectName'")){
                return TRUE;
            } 
        }
    }
}
?>