<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class NftComponentCheck{

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
    public function checkNetworkName($input_array){
        global $wpdb;
        $colName = $input_array['CollectionName'];
        if(null === $wpdb->get_row("SELECT * FROM `".$this->getCollectionNetworkTable()."` WHERE `colnet_name` ='$colName'")){
            return TRUE;
        }
    }
}
?>