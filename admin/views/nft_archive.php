<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Include model:
include PROMO_NFT_PLUGIN_MODEL_DIR . "/NftPromoModel.class.php";

// Declare class variable:
$NftPromoModel = new NftPromoModel();

// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
$pageColnet     = 'nft_colnet';
$pageCollect    = 'nft_collections';

// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $NftPromoModel->getGetValues();

// Keep track of current action.
$action = FALSE;
if (!empty($get_array)) {

    // Check actions
    if (isset($get_array['action'])) {
        $action = $NftPromoModel->handleGetAction($get_array);
    }
}

/* Na checken     */
// Get the POST data in filtered array
$post_array = $NftPromoModel->getPostValues();

if (!empty($get_array['action'] == 'delete')) {

    // Check the add form:
    $del = FALSE;
    // Save event types
    $deleted = $NftPromoModel->delete_page($post_array);
    if($deleted){
    $result = $NftPromoModel->delete($post_array);
    if ($result) {
        // Save was succesfull
        $del = TRUE;
    } else {
        // Indicate error
        $del = FALSE;
    }
}else{}
}

if (!empty($get_array['action'] == 'publish')) {

    // Check the add form:
    $archive = FALSE;
    // Save event types
    $result = $NftPromoModel->publish($post_array);
    if ($result) {
        // Save was succesfull
        $archive = TRUE;
    } else {
        // Indicate error
        $archive = FALSE;
    }
}
?>


<div class="container">
    <div class="mt-4">
        <button class="btn btn-primary" id="displayNetworkTable">Display Network table</button>
        <button class="btn btn-primary" id="displayCollectionsTable">Display Collections table</button>
    </div>

    <?php
    if (isset($add)) {
        echo($add ? "<p class='mt-5 alert alert-success'>Network ".$_POST['CollectionName']." has been added.</p>" : "<p class='mt-5 alert alert-danger'>Network could not be added.</p>");
    }

    if (isset($update)) {
        echo($update ? "<p class='mt-5 alert alert-success'>Network ".$_POST['CollectionName']." has been updated.</p>" : "<p class='mt-5 alert alert-danger'>Network could not be updated.</p>");
    }

    if (isset($del)) {
        echo($del ? "<p class='mt-5 alert alert-success'>Network ".$_POST['CollectionName']." has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Network could not be deleted.</p>");
    }

    if (isset($archive)) {
        echo($archive ? "<p class='mt-5 alert alert-success'>Network ".$_POST['CollectionName']." has been published.</p>" : "<p class='mt-5 alert alert-danger'>Network could not be published.</p>");
    }

    // Check if action == update : then start update form
    echo(($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
    ?>
<div class="table-responsive">
    <table class="table table-light table-hover collapse" id="networkDiv">
        <thead>
        <tr>
            <th width="200">Network name</th>
            <th width="1500">Network description</th>
            <th width="100" colspan="2">Actions</th>
        </tr>
        </thead>
        <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
        <?php
        //*
        if ($NftPromoModel->getNrOfCollectionNetworks() < 1) {
            ?>
        <p class='alert alert-warning'>There are no collection network items yet!</p>
        <?php } else {
            $type_list = $NftPromoModel->getCollectionNetworkArchive();

            //** Show all event types in the tabel
            foreach ($type_list as $NftPromoModel_obj) {

                // Create update link
                $params = array('action' => 'update', 'id' => $NftPromoModel_obj->getNetworkId());
                $upd_link = add_query_arg($params, $base_url);
                
                // Create archive link
                $params = array('action' => 'publish', 'id' => $NftPromoModel_obj->getNetworkId(), 'p' => $pageColnet);
                $pub_link = add_query_arg($params, $base_url);

                // Create delete link
                $params = array('action' => 'delete', 'id' => $NftPromoModel_obj->getNetworkId(), 'p' => $pageColnet, 'colnetName' => $NftPromoModel_obj->getNetworkName().'-drops');
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                        <td width="180"><?= $NftPromoModel_obj->getNetworkName(); ?></td>
                        <td width="200"><?= $NftPromoModel_obj->getNetworkDescription(); ?></td>
                        <?php if ($action !== 'update') {
                            // If action is update don’t show the action button
                            ?>
                            <td><a href="<?= $pub_link; ?>" onclick="return confirm('Are you sure you want to publish this network, by doing so this network will be returned to the network records.?');"><div class="nftIconAdminArchive" data-toggle="tooltip" data-placement="bottom" title="Publish"></div></a></td>
                            <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this network?');"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td>
                            <?php
                        } // if action !== update
                        ?>
                    <?php } // if acton !== update ?>
                </tr>
                <?php
            }
            ?>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-light table-hover collapse" id="collectionsDiv">
        <thead>
        <tr>
            <th width="200">Title</th>
            <th width="500">Description</th>
            <th width="200">Date</th>
            <th width="200">Predate</th>
            <th width="200">Network</th>
            <th width="200">Supply</th>
            <th width="200">Site</th>
            <th width="200">Twitter</th>
            <th width="200">Discord</th>
            <th width="200">Price</th>
            <th width="200">Featured</th>
            <th width="100" colspan="2">Actions</th>
        </tr>
        </thead>
        <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
        <?php
        //*
        if ($NftPromoModel->getNrOfCollections() < 1) {
            ?>
        <p class='alert alert-warning'>There are no collection network items yet!</p>
        <?php } else {
            $col_list = $NftPromoModel->getCollectionArchive();
            //** Show all event types in the tabel
            foreach ($col_list as $NftCol_obj) {

                // Create update link
                $params = array('action' => 'update', 'id' => $NftCol_obj->getCollectionId());
                $upd_link = add_query_arg($params, $base_url);
                
                // Create archive link
                $params = array('action' => 'publish', 'id' => $NftCol_obj->getCollectionId(),'p' => $pageCollect);
                $pub_link = add_query_arg($params, $base_url);

                // Create delete link
                $params = array('action' => 'delete', 'id' => $NftCol_obj->getCollectionId(),'p' => $pageCollect);
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                        <td width="180"><?= $NftCol_obj->getCollectionTitle(); ?></td>
                        <td width="200"><?= mb_strimwidth($NftCol_obj->getCollectionDescription(), 0, 150, '...'); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionDate(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionPreDate(); ?></td>
                        <td width="200"><?php 
                            $id = $NftCol_obj->getCollectionNetwork();
                            if(($NftCol_obj->getNetworkById($id)) == '') {
                            }else {
                                echo($NftCol_obj->getNetworkById($id));
                            } ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionSupply(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionSite(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionTwitter(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionDiscord(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionPrice(); ?></td>
                        <td width="200"><?= $NftCol_obj->getCollectionFeatured(); ?></td>
                        <?php if ($action !== 'update') {
                            // If action is update don’t show the action button
                            ?>
                            <td><a href="<?= $pub_link; ?>" onclick="return confirm('Are you sure you want to publish this collection, by doing so this collection will be returned to the collection records.?');"><div class="nftIconAdminArchive" data-toggle="tooltip" data-placement="bottom" title="Publish"></div></a></td>
                            <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this collection?');"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td>
                            <?php
                        } // if action !== update
                        ?>
                    <?php } // if acton !== update ?>
                </tr>
                <?php
            }
            ?>
    </table>
</div>
    <?php
    // Check if action = update : then end update form
    echo(($action == 'update') ? '</form>' : '');
?>
</div>
<script>
$(document).ready(function(){
    $("#displayCollectionsTable").click(function(){
        $('#collectionsDiv').toggleClass('show');
    });
    $("#displayNetworkTable").click(function(){
        $('#networkDiv').toggleClass('show');
    });
});
</script>