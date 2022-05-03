<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftComponentCheck.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftGetListsAndNumbers.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftSaveUploadDelete.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftPostValues.class.php';
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftTables.class.php';

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
    // Define shortcode variables
        private $shortId                =   '';
        private $shortName              =   '';
        private $shortDesc              =   '';
    // Define author variables      
        private $authId                 =   '';
        private $authName               =   '';
        private $authMail               =   '';
        private $authSite               =   '';
    //Define update log
        private $uid                    =   '';
        private $uvers                  =   '';
        private $udesc                  =   '';
        private $ulist                  =   '';
        private $ufdesc                 =   '';
    // Define choice
        private $cid                    =   '';
        private $choice                 =   '';
        private $choiceVar              =   '';
    // Define listings
        private $listingId              =   '';
        private $listingProject         =   '';
        private $listingName            =   '';
        private $listingEmail           =   '';
        private $listingDescription     =   '';
        private $listingMintDate        =   '';
        private $listingPreSaleDate     =   '';
        private $listingNetwork         =   '';
        private $listingMinPrice        =   '';
        private $listingSupply          =   '';
        private $listingTwitter         =   '';
        private $listingDiscord         =   '';
        private $listingWebsite         =   '';
        private $listingImage           =   '';
        private $listingFeatured        =   '';
    // Define classes
        private $nftCheck               = null;
        private $nftListsAndNumbers     = null;
        private $nftSaveUploadDelete    = null;

    public function __construct(){
        $this->nftTables            = new NftTables();
        $this->nftPostValues        = new NftPostValues();
        $this->nftCheck             = new NftComponentCheck();
        $this->nftListsAndNumbers   = new NftgetListsAndNumbers();
        $this->nftSaveUploadDelete  = new NftSaveUploadDelete();
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

    /* #region NftPostValues */
        public function getPostValues(){return $this->nftPostValues->getPostValues();}
    /* #endregion */
    /* #region NftSaveUploadDelete */
        public function save($input_array,$target_file){return $this->nftSaveUploadDelete->save($input_array,$target_file);}
        public function update($input_array){return $this->nftSaveUploadDelete->update($input_array);}
        public function delete($input_array){return $this->nftSaveUploadDelete->delete($input_array);}
        public function archive($input_array){return $this->nftSaveUploadDelete->archive($input_array);}
        public function publish($input_array){return $this->nftSaveUploadDelete->publish($input_array);}
        public function ImageUpload(){return $this->nftSaveUploadDelete->ImageUpload();}
        public function ImageUploadUpdate($input_array){return $this->nftSaveUploadDelete->ImageUploadUpdate($input_array);}
        public function create_page($input_array){return $this->nftSaveUploadDelete->create_page($input_array);}
        public function delete_page($input_array){return $this->nftSaveUploadDelete->delete_page($input_array);}
        public function getGetValues(){return $this->nftSaveUploadDelete->getGetValues();}
        public function handleGetAction( $get_array ){return $this->nftSaveUploadDelete->handleGetAction( $get_array );}
    /* #endregion */
    /* #region NftCheckComponents  */
        public function checkNetworkName($input_array){return $this->nftCheck->checkNetworkName($input_array);}
        public function checkProjectName($input_array){return $this->nftCheck->checkProjectName($input_array);}
    /* #endregion */
    /* #region NftGetListsAndNumbers  */
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
        public function getNftShortcodes(){return $this->nftListsAndNumbers->getNftShortcodes();}
        public function getNftAuthor(){return $this->nftListsAndNumbers->getNftAuthor();}
        public function getNftUpdateLog(){return $this->nftListsAndNumbers->getNftUpdateLog();}
        public function getNftChangeLog(){return $this->nftListsAndNumbers->getNftChangeLog();}
        public function getChoiceList(){return $this->nftListsAndNumbers->getChoiceList();}
        public function getNrOfListings(){return $this->nftListsAndNumbers->getNrOfListings();}
        public function getListings(){return $this->nftListsAndNumbers->getListings();}
        public function getChoiceById($id){return $this->nftListsAndNumbers->getChoiceById($id);}
    /* #endregion */
    /* #region Get Network */
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
    /* #endregion */
    /* #region Set Network */
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

        public function setNetworkDescription ($networkDesc){
            if ( is_string($networkDesc)){
                $this->networkDesc = trim($networkDesc);
            }
        }
    /* #endregion */
    /* #region Set Shortcodes */
        public function setShortcodeId( $shortId ){
            if ( is_int(intval($shortId) )){
                $this->shortId = trim($shortId);
            }
        }
        public function setShortcodeName( $shortName ){
            if ( is_string( $shortName )){
                $this->shortName = trim($shortName);
            }
        }
        public function setShortcodeDesc( $shortDesc ){
            if ( is_string( $shortDesc )){
                $this->shortDesc = trim($shortDesc);
            }
        }
    /* #endregion */
    /* #region Get Shortcodes */
        public function getShortId(){
            return $this->shortId;
        }
        public function getShortName(){
            return $this->shortName;
        }
        public function getShortDesc(){
            return $this->shortDesc;
        }
    /* #region Set Author */
        public function setAuthorId( $authId ){
            if ( is_int(intval( $authId ))){
                $this->authId = trim($authId);
            }
        }
        public function setAuthorName( $authName ){
            if ( is_string( $authName )){
                $this->authName = trim($authName);
            }
        }
        public function setAuthorMail( $authMail ){
            if ( is_string( $authMail )){
                $this->authMail = trim($authMail);
            }
        }
        public function setAuthorSite( $authSite ){
            if ( is_string( $authSite )){
                $this->authSite = trim($authSite);
            }
        }
    /* #endregion */
    /* #region Get Author */
        public function GetAuthorId(){
            return $this->authId;
        }
        public function getAuthorName(){
            return $this->authName;
        }
        public function getAuthorMail(){
            return $this->authMail;
        }
        public function getAuthorSite(){
            return $this->authSite;
        }
    /* #endregion */
    /* #region Set Collection */
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
    /* #endregion */
    /* #region Get Collection */
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
    /* #region Set update log */
        public function setUpdateId( $uid ){
            if ( is_int(intval( $uid ))){
                $this->uid = trim($uid);
            }
        }
        public function setUpdateVersion( $uvers ){
            if ( is_string( $uvers )){
                $this->uvers = trim($uvers);
            }
        }
        public function setUpdateDesc( $udesc ){
            if ( is_string( $udesc )){
                $this->udesc = trim($udesc);
            }
        }
        public function setUpdateList( $ulist ){
            if ( is_string( $ulist )){
                $this->ulist = trim($ulist);
            }
        }
        public function setUpdateFdesc( $ufdesc ){
            if ( is_string( $ufdesc )){
                $this->ufdesc = trim($ufdesc);
            }
        }
    /* #endregion */
    /* #region get update log */
        public function getUpdateId(){
            return $this->uid;
        }
        public function getUpdateVersion(){
            return $this->uvers;
        }
        public function getUpdateDesc(){
            return $this->udesc;
        }
        public function getUpdateList(){
            return $this->ulist;
        }
        public function getUpdateFdesc(){
            return $this->ufdesc;
        }
    /* #endregion */
    /*#region set choice */
    public function setChoiceId( $cid ){
        if ( is_int(intval( $cid ))){
            $this->cid = trim($cid);
        }
    }
    public function setChoice( $choice ){
        if ( is_string( $choice )){
            $this->choice = trim($choice);
        }
    }
    public function setChoiceVar( $choiceVar ){
        if ( is_string( $choiceVar )){
            $this->choiceVar = trim($choiceVar);
        }
    }
    /* #endregion*/
    /*#region get choice */
    public function getChoiceId(){
        return $this->cid;
    }
    public function getChoice(){
        return $this->choice;
    }
    public function getChoiceVar(){
        return $this->choiceVar;
    }
    /* #endregion*/
     /*#region set listings */
     public function setListingId( $listingId ){
        if ( is_int(intval( $listingId ))){
            $this->listingId = trim($listingId);
        }
    }
    public function setListingProject( $listingProject ){
        if ( is_string( $listingProject )){
            $this->listingProject = trim($listingProject);
        }
    }
    public function setListingName( $listingName ){
        if ( is_string( $listingName )){
            $this->listingName = trim($listingName);
        }
    }
    public function setListingEmail( $listingEmail ){
        if ( is_string( $listingEmail )){
            $this->listingEmail = trim($listingEmail);
        }
    }
    public function setListingDescription( $listingDescription ){
        if ( is_string( $listingDescription )){
            $this->listingDescription = trim($listingDescription);
        }
    }
    public function setListingMintDate( $listingMintDate ){
        if ( is_string( $listingMintDate )){
            $this->listingMintDate = trim($listingMintDate);
        }
    }
    public function setListingPreSale( $listingPreSaleDate ){
        if ( is_string( $listingPreSaleDate )){
            $this->listingPreSaleDate = trim($listingPreSaleDate);
        }
    }
    public function setListingMinPrice( $listingMinPrice ){
        if ( is_string( $listingMinPrice )){
            $this->listingMinPrice = trim($listingMinPrice);
        }
    }
    public function setListingNetwork( $listingNetwork ){
        if ( is_string( $listingNetwork )){
            $this->listingNetwork = trim($listingNetwork);
        }
    }
    public function setListingSupply( $listingSupply ){
        if ( is_string( $listingSupply )){
            $this->listingSupply = trim($listingSupply);
        }
    }
    public function setListingTwitter( $listingTwitter ){
        if ( is_string( $listingTwitter )){
            $this->listingTwitter = trim($listingTwitter);
        }
    }
    public function setListingDiscord( $listingDiscord ){
        if ( is_string( $listingDiscord )){
            $this->listingDiscord = trim($listingDiscord);
        }
    }
    public function setListingWebsite( $listingWebsite ){
        if ( is_string( $listingWebsite )){
            $this->listingWebsite = trim($listingWebsite);
        }
    }
    public function setListingImage( $listingImage ){
        if ( is_string( $listingImage )){
            $this->listingImage = trim($listingImage);
        }
    }
    public function setListingFeatured( $listingFeatured ){
        if ( is_string( $listingFeatured )){
            $this->listingFeatured = trim($listingFeatured);
        }
    }
    /* #endregion*/
     /*#region get choice */
     public function getListingId(){
        return $this->listingId;
    }
    public function getListingProject(){
        return $this->listingProject;
    }
    public function getListingName(){
        return $this->listingName;
    }
    public function getListingEmail(){
        return $this->listingEmail;
    }
    public function getListingDescription(){
        return $this->listingDescription;
    }
    public function getListingMintDate(){
        return $this->listingMintDate;
    }
    public function getListingPreSale(){
        return $this->listingPreSaleDate;
    }
    public function getListingNetwork(){
        return $this->listingNetwork;
    }
    public function getListingMinPrice(){
        return $this->listingMinPrice;
    }
    public function getListingSupply(){
        return $this->listingSupply;
    }
    public function getListingTwitter(){
        return $this->listingTwitter;
    }
    public function getListingDiscord(){
        return $this->listingDiscord;
    }
    public function getListingWebsite(){
        return $this->listingWebsite;
    }
    public function getListingImage(){
        return $this->listingImage;
    }
    public function getListingFeatured(){
        return $this->listingFeatured;
    }
    /* #endregion*/
}
?>