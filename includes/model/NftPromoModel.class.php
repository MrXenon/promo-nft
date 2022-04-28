<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftComponentCheck.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftGetListsAndNumbers.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftSaveUploadDelete.class.php';

class NftPromoModel {
    // Define NetworkCollections variables
    private $networkId              =   '';
    private $networkName            =   '';
    private $networkDesc            =   '';
    private $archive                =   '';
    // Define Collection variables
    private $collectId              =   '';
    private $collectImage           =   '';
    private $collectTitle           =   '';
    private $collectDesc            =   '';
    private $collectDate            =   '';
    private $collectPreDate         =   '';
    private $collectFkColnetId      =   '';
    private $collectSupply          =   '';
    private $collectSite            =   '';
    private $collectTwitter         =   '';
    private $collectDiscord         =   '';
    private $collectFeatured        =   '';
    // Define classes
    private $nftCheck               = null;
    private $nftListsAndNumbers     = null;
    private $nftSaveUploadDelete    = null;

    public function __construct(){
        $this->nftCheck             = new NftComponentCheck();
        $this->nftListsAndNumbers   = new NftgetListsAndNumbers();
        $this->nftSaveUploadDelete  = new NftSaveUploadDelete();
    }   

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

    public function getPostValues(){
        $post_check_array = array (
            'add' => array('filter' => FILTER_SANITIZE_STRING ),
            'update'   => array('filter' =>FILTER_SANITIZE_STRING ),
            /**NFT Collection Network values & NFT Collection values*/
            'CollectionName'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionDescription'   => array('filter' => FILTER_SANITIZE_STRING ),
            'archive'   => array('filter' => FILTER_VALIDATE_INT ),
            'colnetName' => array('filter' => FILTER_SANITIZE_STRING ),
            /**NFT Collection values*/
            'CollectionDate'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionPredate'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionNetId'   => array('filter' => FILTER_VALIDATE_INT ),
            'CollectionSupply'   => array('filter' => FILTER_VALIDATE_INT ),
            'CollectionSite'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionTwitter'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionDiscord'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionFeatured'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionImage'   => array('filter' => FILTER_SANITIZE_STRING ),
            'CollectionPrice' => array('filter' => FILTER_SANITIZE_STRING ),
            /**Pagename */
            'p' => array('filter' => FILTER_SANITIZE_STRING ),
            /**NFT global ID value*/
            'id'    => array( 'filter'    => FILTER_VALIDATE_INT ),
        );
        $inputs = filter_input_array( INPUT_POST, $post_check_array );
        return $inputs;
    }

    public function save($input_array){
        return $this->nftSaveUploadDelete->save($input_array);
    }
    public function update($input_array){
        return $this->nftSaveUploadDelete->update($input_array);
    }
    public function delete($input_array){
        return $this->nftSaveUploadDelete->delete($input_array);
    }
    public function archive($input_array){
        return $this->nftSaveUploadDelete->archive($input_array);
    }
    public function publish($input_array){
        return $this->nftSaveUploadDelete->publish($input_array);
    }
    public function ImageUpload(){
        return $this->nftSaveUploadDelete->ImageUpload();
    }
    public function ImageUploadUpdate($input_array){
        return $this->nftSaveUploadDelete->ImageUploadUpdate($input_array);
    }
    public function create_page($input_array){
        return $this->nftSaveUploadDelete->create_page($input_array);
    }
    public function delete_page($input_array){
        return $this->nftSaveUploadDelete->delete_page($input_array);
    }
    public function getGetValues(){
        return $this->nftSaveUploadDelete->getGetValues();
    }
    public function handleGetAction( $get_array ){
        return $this->nftSaveUploadDelete->handleGetAction( $get_array );
    }
    /**
     * NftCheckComponents region
     */
    public function checkNetworkName($input_array){
        return $this->nftCheck->checkNetworkName($input_array);
    }
    /**
     * NftGetListsAndNumbers region
     */

    public function getNrOfCollectionNetworks(){return $this->nftListsAndNumbers->getNrOfCollectionNetworks();}
    public function getColnetId($page){return $this->nftListsAndNumbers->getColnetId($page);}
    public function getNrOfCollections(){return $this->nftListsAndNumbers->getNrOfCollections();}
    public function getNrOfPageCollections($pageId){return $this->nftListsAndNumbers->getNrOfPageCollections($pageId);}
    public function getNrOfFeaturedCollections(){return $this->nftListsAndNumbers-> getNrOfFeaturedCollections();}
    public function getCollectionNetworkList(){return $this->nftListsAndNumbers->getCollectionNetworkList();}
    public function getCollectionNetworkArchive(){return $this->nftListsAndNumbers->getCollectionNetworkArchive();}
    public function getCollectionList(){return $this->nftListsAndNumbers->getCollectionList();}
    public function getPageCollectionList($pageId){return $this->nftListsAndNumbers->getPageCollectionList($pageId);}
    public function getPageNftCollectionList($nft){return $this->nftListsAndNumbers->getPageNftCollectionList($nft);}
    public function getCollectionFeaturedList(){return $this->nftListsAndNumbers->getCollectionFeaturedList();}
    public function getCollectionArchive(){return $this->nftListsAndNumbers->getCollectionArchive();}
    public function getNetworkById($id) {return $this->nftListsAndNumbers->getNetworkById($id);}
    public function getNrOfArchivedNetworks(){return $this->nftListsAndNumbers->getNrOfArchivedNetworks();}
    public function getNrOfArchivedCollections(){return $this->nftListsAndNumbers->getNrOfArchivedCollections();}


    /**
     * NftPromoModel get & set values for data export/import.
     */

    public function setNetworkId( $networkId ){
        if ( is_int(intval($networkId) ) ){
            $this->networkId = $networkId;
        }
    }
    public function setNetworkName( $networkName ){
        if ( is_string( $networkName )){
            $this->networkName = trim($networkName);
        }
    }
    public function setNetworkArchive ($archive){
        if ( is_string($archive)){
            $this->archive = trim($archive);
        }
    }
    public function getNetworkId(){
        return $this->networkId;
    }
    public function getNetworkName(){
        return $this->networkName;
    }

    public function getNetworkDescription(){
        return $this->networkDesc;
    }
    public function getNetworkArchive(){
        return $this->archive;
    }

    public function setNetworkDescription ($networkDesc){
        if ( is_string($networkDesc)){
            $this->networkDesc = trim($networkDesc);
        }
    }
    public function setCollectionImage( $collectImage ){
        if ( is_string( $collectImage )){
            $this->collectImage = trim($collectImage);
        }
    }
    public function setCollectionId( $collectionId ){
        if ( is_int(intval($collectionId) ) ){
            $this->collectionId = $collectionId;
        }
    }
    public function setCollectionTitle( $collectTitle ){
        if ( is_string( $collectTitle )){
            $this->collectTitle = trim($collectTitle);
        }
    }
    public function setCollectionDescription( $collectDesc ){
        if ( is_string( $collectDesc )){
            $this->collectDesc = trim($collectDesc);
        }
    }
    public function setCollectionDate( $collectDate ){
        if ( is_string( $collectDate )){
            $this->collectDate = trim($collectDate);
        }
    }
    public function setCollectionPreDate( $collectPreDate ){
        if ( is_string( $collectPreDate )){
            $this->collectPreDate = trim($collectPreDate);
        }
    }
    public function setCollectionNetwork( $collectFkColnetId ){
        if ( is_string( $collectFkColnetId )){
            $this->collectFkColnetId = trim($collectFkColnetId);
        }
    }
    public function setCollectionSupply( $collectSupply ){
        if ( is_string( $collectSupply )){
            $this->collectSupply = trim($collectSupply);
        }
    }
    public function setCollectionSite( $collectSite ){
        if ( is_string( $collectSite )){
            $this->collectSite = trim($collectSite);
        }
    }
    public function setCollectionTwitter( $collectTwitter ){
        if ( is_string( $collectTwitter )){
            $this->collectTwitter = trim($collectTwitter);
        }
    }
    public function setCollectionDiscord( $collectDiscord){
        if ( is_string( $collectDiscord )){
            $this->collectDiscord = trim($collectDiscord);
        }
    }
    public function setCollectionPrice( $collectPrice ){
        if ( is_string( $collectPrice )){
            $this->collectPrice = trim($collectPrice);
        }
    }
    public function setCollectionFeatured( $collectFeatured ){
        if ( is_string( $collectFeatured )){
            $this->collectFeatured = trim($collectFeatured);
        }
    }
    public function getCollectionId(){
        return $this->collectionId;
    }
    public function getCollectionImage(){
        return $this->collectImage;
    }
    public function getCollectionTitle(){
        return $this->collectTitle;
    }
    public function getCollectionDescription(){
        return $this->collectDesc;
    }
    public function getCollectionDate(){
        return $this->collectDate;
    }
    public function getCollectionPreDate(){
        return $this->collectPreDate;
    }
    public function getCollectionNetwork(){
        return $this->collectFkColnetId;
    }
    public function getCollectionSupply(){
        return $this->collectSupply;
    }
    public function getCollectionSite(){
        return $this->collectSite;
    }
    public function getCollectionTwitter(){
        return $this->collectTwitter;
    }
    public function getCollectionDiscord(){
        return $this->collectDiscord;
    }
    public function getCollectionPrice(){
        return $this->collectPrice;
    }
    public function getCollectionFeatured(){
        return $this->collectFeatured;
    }
}
?>