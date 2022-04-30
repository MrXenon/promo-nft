<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

 class NftTables{
             // Define tables
             public function getNftPrefix(){
                return $prefix = 'nft_';
            }   
            public function getCollectionNetworkTable(){
                global $wpdb;
                return $table = $wpdb->prefix .$this->getNftPrefix(). "colnet";
            } 
            public function getCollectionsTable(){
                global $wpdb;
                return $table = $wpdb->prefix .$this->getNftPrefix(). "collect";
            }
            public function getShortcodesTable(){
                global $wpdb;
                return $table = $wpdb->prefix .$this->getNftPrefix(). "shortcodes";
            }
            public function getAuthorTable(){
                global $wpdb;
                return $table = $wpdb->prefix .$this->getNftPrefix(). "author";
            }
            public function getUpdateLogTable(){
                global $wpdb;
                return $table = $wpdb->prefix .$this->getNftPrefix(). "update";
            }
            public function getChoiceTable(){
                global $wpdb;
                return $table = $wpdb->prefix . $this->getNftPrefix() . "choice";
            }
            public function getListingTable(){
                global $wpdb;
                return $table = $wpdb->prefix . $this->getNftPrefix() . "listings";
            }
 }
?>