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
    $result = $NftPromoModel->delete($post_array);
    if ($result) {
        // Save was succesfull
        $del = TRUE;
    } else {
        // Indicate error
        $del = FALSE;
    }
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
    <table class="table table-light table-hover" id="collectionsDiv">
        <thead>
        <tr>
            <th width="200">Project</th>
            <th width="200">Name</th>
            <th width="200">Email</th>
            <th width="500">Description</th>
            <th width="200">Mintdate</th>
            <th width="200">Presale</th>
            <th width="200">Network</th>
            <th width="200">Price</th>
            <th width="200">Supply</th>
            <th width="200">Twitter</th>
            <th width="200">Discord</th>
            <th width="200">Website</th>
            <th width="200">Image</th>
            <th width="200">Featured</th>
            <th width="100" colspan="2">Actions</th>
        </tr>
        </thead>
        <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
        <?php
        //*
        if ($NftPromoModel->getNrOfListings() < 1) {
            ?>
        <p class='alert alert-warning'>There are no listings yet!</p>
        <?php } else {
            $col_list = $NftPromoModel->getListings();
            //** Show all event types in the tabel
            foreach ($col_list as $NftCol_obj) {

                // Create update link
                $params = array('action' => 'update', 'id' => $NftCol_obj->getListingId());
                $upd_link = add_query_arg($params, $base_url);
                
                // Create archive link
                $params = array('action' => 'publish', 'id' => $NftCol_obj->getListingId());
                $pub_link = add_query_arg($params, $base_url);

                // Create delete link
                $params = array('action' => 'delete', 'id' => $NftCol_obj->getListingId());
                $del_link = add_query_arg($params, $base_url);
                ?>
                <tr>
                        <td width="200"><?= $NftCol_obj->getListingProject(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingName(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingEmail(); ?></td>
                        <td width="500"><?= mb_strimwidth($NftCol_obj->getListingDescription(), 0, 150, '...'); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingMintDate(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingPreSale(); ?></td>
                        <td width="200"><?php 
                            $id = $NftCol_obj->getListingNetwork();
                            if(($NftCol_obj->getNetworkById($id)) == '') {
                            }else {
                                echo($NftCol_obj->getNetworkById($id));
                            } ?></td>
                        <td width="200"><?= $NftCol_obj->getListingMinPrice(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingSupply(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingTwitter(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingDiscord(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingWebsite(); ?></td>
                        <td width="200"><?= $NftCol_obj->getListingImage(); ?></td>
                        <td width="200"><?php 
                            $id = $NftCol_obj->getListingFeatured();
                            if(($NftCol_obj->getChoiceById($id)) == '') {
                            }else {
                                echo($NftCol_obj->getChoiceById($id));
                            } ?></td>
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