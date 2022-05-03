<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class NftPostValues{
    public function getPostValues(){
        $post_check_array = array (
            'add'                   => array('filter' => FILTER_SANITIZE_STRING ),
            'submit'                   => array('filter' => FILTER_SANITIZE_STRING ),
            'update'                => array('filter' => FILTER_SANITIZE_STRING ),
            /**NFT Collection Network values & NFT Collection values*/
            'CollectionName'        => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionDescription' => array('filter' => FILTER_SANITIZE_STRING ),
            'archive'               => array('filter' => FILTER_VALIDATE_INT ),
            'colnetName'            => array('filter' => FILTER_SANITIZE_STRING ),
            /**NFT Collection values*/
            'CollectionDate'        => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionPredate'     => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionNetId'       => array('filter' => FILTER_VALIDATE_INT ),
            'CollectionSupply'      => array('filter' => FILTER_VALIDATE_INT ),
            'CollectionSite'        => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionTwitter'     => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionDiscord'     => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionFeatured'    => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionImage'       => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionPrice'       => array('filter' => FILTER_SANITIZE_STRING ),
            /**NftAddCollection form input */
            'projectProjectName'    => array('filter' => FILTER_SANITIZE_STRING ),
            'projectName'           => array('filter' => FILTER_SANITIZE_STRING ),
            'projectEmail'          => array('filter' => FILTER_SANITIZE_EMAIL  ),
            'projectDescription'    => array('filter' => FILTER_SANITIZE_STRING ),
            'projectMintDate'       => array('filter' => FILTER_SANITIZE_STRING ),
            'projectPreSaleDate'    => array('filter' => FILTER_SANITIZE_STRING ),
            'projectNetwork'        => array('filter' => FILTER_SANITIZE_STRING ),
            'projectMintPrice'      => array('filter' => FILTER_SANITIZE_STRING ),
            'projectSupply'         => array('filter' => FILTER_SANITIZE_STRING ),
            'projectTwitter'        => array('filter' => FILTER_SANITIZE_STRING ),
            'projectDiscord'        => array('filter' => FILTER_SANITIZE_STRING ),
            'projectWebsite'        => array('filter' => FILTER_SANITIZE_STRING ),
            'projectImage'          => array('filter' => FILTER_SANITIZE_STRING ),
            'projectFeatured'       => array('filter' => FILTER_SANITIZE_STRING ),
            /**Pagename */
            'p'                     => array('filter' => FILTER_SANITIZE_STRING ),
            /**Delete file */
            'deleted'               => array('filter' => FILTER_VALIDATE_INT ),
            /**NFT global ID value*/
            'id'                    => array( 'filter'=> FILTER_VALIDATE_INT    ),
        );
        $inputs = filter_input_array( INPUT_POST, $post_check_array );
        return $inputs;
    }
}