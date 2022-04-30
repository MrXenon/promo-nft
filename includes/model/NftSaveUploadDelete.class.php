<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once PROMO_NFT_PLUGIN_MODEL_DIR  . '/NftTables.class.php';
class NftSaveUploadDelete{
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

    public function save($input_array){
        if($input_array['p'] == 'nft_colnet'){
            try {
                $array_fields = array( 'CollectionName', 'CollectionDescription','archive');
                $data_array = array();
    
                foreach( $array_fields as $field){
    
                    if (!isset($input_array[$field])){
                        throw new Exception(__("$field is mandatory for update."));
                    }
                    $data_array[] = $input_array[$field];
                }

                global $wpdb;

                // Insert query
                $wpdb->query($wpdb->prepare("INSERT INTO `". $this->getCollectionNetworkTable()
                    ."` ( `colnet_name`, `colnet_desc`,`archive`)".
                    " VALUES ( '%s', '%s','%s');",
                    $input_array['CollectionName'],
                    $input_array['CollectionDescription'],
                    $input_array['archive']) );
                // Error ? It's in there:
                if ( !empty($wpdb->last_error) ){
                    return FALSE;
                }

            } catch (Exception $exc) {
                // @todo: Add error handling
                echo '<p class="alert alert-warning">'. $exc->getMessage() .'</p>';
            }
        return TRUE;
        }elseif($input_array['p'] == 'add-your-collection'){
            try {
                $array_fields = array( 'projectProjectName', 'projectName','projectEmail','projectPreSaleDate','projectNetwork',
                'projectMintPrice','projectSupply','projectTwitter','projectDiscord','projectWebsite','projectImage','projectFeatured');
                $data_array = array();
    
                foreach( $array_fields as $field){
    
                    if (!isset($input_array[$field])){
                        throw new Exception(__("$field is mandatory."));
                    }
                    $data_array[] = $input_array[$field];
                }

                global $wpdb;

                $wpdb->query($wpdb->prepare("INSERT INTO `". $this->getListingsTable()
                    ."` ( `listing_project`,`listing_name`, `listing_email`,`listing_desc`,`listing_mintdate`,`listing_presale`,`listing_network`,
                    `listing_minprice`,`listing_supply`,`listing_twitter`,`listing_discord`,`listing_website`,`listing_image`,`listing_featured`)".
                    " VALUES ( '%s', '%s','%s','%s','%s','%s','%d','%s','%d','%s','%s','%s','%s','%s');",
                    $input_array['projectProjectName'],
                    $input_array['projectName'],
                    $input_array['projectEmail'],
                    $input_array['projectDescription'],
                    $input_array['projectMintDate'],
                    $input_array['projectPreSaleDate'],
                    $input_array['projectNetwork'],
                    $input_array['projectMintPrice'],
                    $input_array['projectSupply'],
                    $input_array['projectTwitter'],
                    $input_array['projectDiscord'],
                    $input_array['projectWebsite'],
                    $input_array['projectImage'],
                    $input_array['projectFeatured']) );
                // Error ? It's in there:
                if ( !empty($wpdb->last_error) ){
                    return FALSE;
                }

            } catch (Exception $exc) {
                // @todo: Add error handling
                echo '<p class="alert alert-warning">'. $exc->getMessage() .'</p>';
            }
        return TRUE;
       }else{
            try {
                $array_fields = array('CollectionImage','CollectionName', 'CollectionDescription', 'CollectionDate','CollectionPredate','CollectionNetId','CollectionSupply',
                'CollectionSite','CollectionTwitter','CollectionDiscord','CollectionFeatured','CollectionPrice','archive');
                $data_array = array();
    
                foreach( $array_fields as $field){
    
                    if (!isset($input_array[$field])){
                        throw new Exception(__("$field is mandatory for save."));
                    }
                    $data_array[] = $input_array[$field];
                }

                global $wpdb;

                // Insert query
                $wpdb->query($wpdb->prepare("INSERT INTO `". $this->getCollectionsTable()
                    ."` ( `collect_img`,`collect_title`, `collect_desc`,`collect_date`,`collect_predate`,`fk_colnet_id`,
                    `collect_supply`,`collect_site`,`collect_twitter`,`collect_discord`,
                    `collect_price`,`collect_featured`,`archive`)".
                    " VALUES ( '%s', '%s','%s','%s', '%s','%d','%d', '%s','%s','%s', '%s','%s','%s');",
                    $input_array['CollectionImage'],
                    $input_array['CollectionName'],
                    $input_array['CollectionDescription'],
                    $input_array['CollectionDate'],
                    $input_array['CollectionPredate'],
                    $input_array['CollectionNetId'],
                    $input_array['CollectionSupply'],
                    $input_array['CollectionSite'],
                    $input_array['CollectionTwitter'],
                    $input_array['CollectionDiscord'],
                    $input_array['CollectionPrice'],
                    $input_array['CollectionFeatured'],
                    $input_array['archive']) );
                // Error ? It's in there:
                if ( !empty($wpdb->last_error) ){
                    return FALSE;
                }
            } catch (Exception $exc) {
                // @todo: Add error handling
                echo '<p class="alert alert-warning">'. $exc->getMessage() .'</p>';
            }
        return TRUE;
        }
    }
    public function update($input_array){
        if($input_array['p'] == 'nft_colnet'){
        try {
            $array_fields = array( 'id','CollectionName', 'CollectionDescription');
            $data_array = array();

            foreach( $array_fields as $field){

                if (!isset($input_array[$field])){
                    throw new Exception(__("$field is mandatory for update."));
                }
                $data_array[] = $input_array[$field];
            }
            global $wpdb;
            // Update query
            //*
            $wpdb->query($wpdb->prepare("UPDATE ".$this->getCollectionNetworkTable()."
            SET `colnet_name` = '%s', `colnet_desc` = '%s', `archive` = '%s' ".
                "WHERE `".$this->getCollectionNetworkTable()."`.`colnet_id` =%d;",
                $input_array['CollectionName'],
                $input_array['CollectionDescription'], 
                $input_array['archive'], 
                $input_array['id']) );

        } catch (Exception $exc) {
            // @todo: Fix error handlin
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return FALSE;
        }
        return TRUE;
    }else{
        try {
            $array_fields = array('id','CollectionImage','CollectionName', 'CollectionDescription', 'CollectionDate','CollectionPredate','CollectionNetId','CollectionSupply',
            'CollectionSite','CollectionTwitter','CollectionDiscord','CollectionFeatured','CollectionPrice','archive');
            $data_array = array();

            foreach( $array_fields as $field){

                if (!isset($input_array[$field])){
                    throw new Exception(__("$field is mandatory for update."));
                }
                $data_array[] = $input_array[$field];
            }
            global $wpdb;
            // Update query
            //*
            $wpdb->query($wpdb->prepare("UPDATE ".$this->getCollectionsTable()."
            SET `collect_img` = '%s', `collect_title` = '%s', `collect_desc` = '%s', `collect_date` = '%s', `collect_predate` = '%s', `fk_colnet_id` = '%d', `collect_supply` = '%d',
            `collect_site` = '%s', `collect_twitter` = '%s', `collect_discord` = '%s', `collect_price` = '%s', `collect_featured` = '%s', `archive` = '%s'".
                "WHERE `".$this->getCollectionsTable()."`.`collect_id` =%d;",
                $input_array['CollectionImage'],
                $input_array['CollectionName'],
                $input_array['CollectionDescription'],
                $input_array['CollectionDate'],
                $input_array['CollectionPredate'],
                $input_array['CollectionNetId'],
                $input_array['CollectionSupply'],
                $input_array['CollectionSite'],
                $input_array['CollectionTwitter'],
                $input_array['CollectionDiscord'],
                $input_array['CollectionPrice'],
                $input_array['CollectionFeatured'],
                $input_array['archive'], 
                $input_array['id']) );

        } catch (Exception $exc) {
            // @todo: Fix error handlin
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return FALSE;
        }
        return TRUE;
    }
    }

    public function delete($input_array){
        if($input_array['p'] == 'nft_colnet'){
        try {
            // Check input id
            if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
            global $wpdb;
            // Delete row by provided id (WordPress style)
            $wpdb->delete( $this->getCollectionNetworkTable(),
                array( 'colnet_id' => $input_array['id'] ),
                array( '%d' ) );


            if ( !empty($wpdb->last_error) ){
                throw new Exception( $wpdb->last_error);
            }
        } catch (Exception $exc) {

        return TRUE;
        }
        return FALSE;
    }else{
        try {
            // Check input id
            if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
            global $wpdb;
            // Delete row by provided id (WordPress style)
            $wpdb->delete( $this->getCollectionsTable(),
                array( 'collect_id' => $input_array['id'] ),
                array( '%d' ) );


            if ( !empty($wpdb->last_error) ){
                throw new Exception( $wpdb->last_error);
            }
        } catch (Exception $exc) {

        return TRUE;
        }
        return FALSE;
    }
    }

    public function archive($input_array){
        if($input_array['p'] == 'nft_colnet'){
        try {
            // Check input id
            if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
            global $wpdb;
            // Delete row by provided id (WordPress style)
            $wpdb->query("UPDATE " .$this->getCollectionNetworkTable()." SET `archive` = 1 WHERE colnet_id = ".$input_array['id']."");


            if ( !empty($wpdb->last_error) ){
                throw new Exception( $wpdb->last_error);
            }
        } catch (Exception $exc) {
        return TRUE;
        }
        return FALSE;
    }else{
        try {
            // Check input id
            if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
            global $wpdb;
            // Delete row by provided id (WordPress style)
            $wpdb->query("UPDATE " .$this->getCollectionsTable()." SET `archive` = 1 WHERE collect_id = ".$input_array['id']."");


            if ( !empty($wpdb->last_error) ){
                throw new Exception( $wpdb->last_error);
            }
        } catch (Exception $exc) {
        return TRUE;
        }
        return FALSE;  
    }
}

public function publish($input_array){
    if($input_array['p'] == 'nft_colnet'){
    try {
        // Check input id
        if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
        global $wpdb;
        // Delete row by provided id (WordPress style)
        $wpdb->query("UPDATE " .$this->getCollectionNetworkTable()." SET `archive` = 0 WHERE colnet_id = ".$input_array['id']."");


        if ( !empty($wpdb->last_error) ){
            throw new Exception( $wpdb->last_error);
        }
    } catch (Exception $exc) {
    return TRUE;
    }
    return FALSE;
}else{
    try {
        // Check input id
        if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
        global $wpdb;
        // Delete row by provided id (WordPress style)
        $wpdb->query("UPDATE " .$this->getCollectionsTable()." SET `archive` = 0 WHERE collect_id = ".$input_array['id']."");


        if ( !empty($wpdb->last_error) ){
            throw new Exception( $wpdb->last_error);
        }
    } catch (Exception $exc) {
    return TRUE;
    }
    return FALSE;  
}
}

    public function ImageUpload()
    {

        // $target_dir = plugins_url('my-image-garden') . '/images/';
        $target_dir = './../wp-content/plugins/'.PROMO_NFT_PLUGIN_NAME.'/images/';
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {

                $uploadOk = 1;
            } else {

                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000000) {
            $uploadOk = 2;
        }

        // Check if file already exists
        if (file_exists($target_file)) {

            $uploadOk = 3;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 4;
        }

        // Check if $uploadOk is set to 0 by an error
        if (in_array($uploadOk, array(0, 2, 3, 4))) {

            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            } else {
            }
        }
        return $uploadOk;
    }

    public function ImageUploadUpdate($input_array)
    {

        $target_dir         = "./../wp-content/plugins/".PROMO_NFT_PLUGIN_NAME."/images/";
        $target_file        = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk           = 1;
        $imageFileType      = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image              = $input_array['CollectionImage'];

        // Check if image file is a actual image or fake image
        if($image  != ''){
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {

                $uploadOk = 1;
            } else {

                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadOk = 2;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 4;
        }

        // Check if $uploadOk is set to 0 by an error
        if (in_array($uploadOk, array(0, 2, 4))) {

            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            } else {
            }
        }
        return $uploadOk;
    }
    return $uploadOk;
    
}


public function create_page($input_array)
{
    if (!current_user_can('activate_plugins')) return;

    global $wpdb;

    $pageTitle  = $input_array['CollectionName'];
    $pageName   = strtolower($pageTitle);
    $pattern    = '/ /i';
    $pageSlug    =  preg_replace($pattern, '-', $pageName);

    if (null === $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = '$pageSlug-drops'", 'ARRAY_A')) {

        $current_user = wp_get_current_user();
        $page = array(
            'post_title' => __($pageTitle .' Drops'),
            'post_content' => '[nft_single]',
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type' => 'page',
        );
        wp_insert_post($page);
    }
}

public function generateAddCollectionForm(){
    if (!current_user_can('activate_plugins')) return;
    global $wpdb;

    if (null === $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'add-your-collection'", 'ARRAY_A')) {

        $current_user = wp_get_current_user();
        $page = array(
            'post_title' => __('Add your collection'),
            'post_content' => '[nft_add_collection]',
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type' => 'page',
        );
        wp_insert_post($page);
    }

}

public function delete_page($input_array)
{
    if (!current_user_can('activate_plugins')) return;

    global $wpdb;

    $pageTitle =  $input_array['colnetName'];
    $pageName   = strtolower($pageTitle);
    $pattern    = '/ /i';
    $pageSlug    =  preg_replace($pattern, '-', $pageName);
    $wpdb->query("DELETE FROM `".$wpdb->prefix. "posts` WHERE post_name ='".$pageSlug."'");
    }

    public function getGetValues(){
        //Define the check for params
        $get_check_array = array (
            //Action
            'action' => array('filter' => FILTER_SANITIZE_STRING ),

            'p' => array('filter' => FILTER_SANITIZE_STRING ),

            'colnetName' => array('filter' => FILTER_SANITIZE_STRING ),

            'generateAddCollectionForm' => array('filter' => FILTER_SANITIZE_STRING ),

            //Id of current row
            'id' => array('filter' => FILTER_VALIDATE_INT ));


        //Get filtered input:
        $inputs = filter_input_array( INPUT_GET, $get_check_array );

        // RTS
        return $inputs;

    }

    public function handleGetAction( $get_array ){
        $action = '';

        switch($get_array['action']){
            case 'update':
                // Indicate current action is update if id provided
                if ( !is_null($get_array['id']) ){
                    $action = $get_array['action'];
                }
                break;

            case 'delete':
                // Delete current id if provided
                if ( !is_null($get_array['id']) ){
                    $this->delete_page($get_array);
                    $this->delete($get_array);
                }
                $action = 'delete';
                break;

            case 'archive':
                // Archive current item if provided
                if ( !is_null($get_array['id']) ){
                    $this->archive($get_array);
                }
                $action = 'archive';
                break;    

            case 'publish':
                // Publish current item if provided
                if ( !is_null($get_array['id']) ){
                    $this->publish($get_array);
                }
                $action = 'publish';
                break;

            case 'generateAddCollectionForm':
                $this->generateAddCollectionForm();
               $action = 'generateAddCollectionForm';
               break;

            default:
                // Oops
                    break;
        }
        return $action;
    }
}
?>