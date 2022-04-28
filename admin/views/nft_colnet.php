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
$page = basename(__FILE__, ".php");
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

// Collect Errors
$error = FALSE;
// Check the POST data
if (!empty($post_array['add'])) {

    // Check the add form:
    $add = FALSE;
    // Save event types
    if($NftPromoModel->checkNetworkName($post_array) == 'TRUE'){
        $checkNetName = TRUE;
        $result = $NftPromoModel->save($post_array);
        if ($result) {
            // Save was succesfull
            $NftPromoModel->create_page($post_array);
            $add = TRUE;
        } else {
            // Indicate error
            $error = TRUE;
        }
    }else{
        $checkNetName = FALSE;
    }
}

if (!empty($post_array['update'])) {

    // Check the add form:
    $update = FALSE;
    // Save event types
    $result = $NftPromoModel->update($post_array);
    if ($result) {
        // Save was succesfull
        $update = TRUE;
    } else {
        // Indicate error
        $update = FALSE;
    }
}

if (!empty($get_array['action'] == 'delete')) {

    // Check the add form:
    $del = FALSE;
    // Save event types
    $NftPromoModel->delete_page($post_array);
    $result = $NftPromoModel->delete($post_array);
    if ($result) {
        // Save was succesfull
        $del = TRUE;
    } else {
        // Indicate error
        $del = FALSE;
    }
}

if (!empty($get_array['action'] == 'archive')) {

    // Check the add form:
    $archive = FALSE;
    // Save event types
    $result = $NftPromoModel->archive($post_array);
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
        <button class="btn btn-primary" id="displayForm">Display Form</button>
        <button class="btn btn-primary" id="displayNetworkTable">Display Network table</button>
    </div>

    <?php
    if (isset($checkNetName)) {
        echo($add ? "" : "<p class='mt-5 alert alert-warning'>Network name ".$_POST['CollectionName']." already exists in our database, please add a new one.</p>");
    }
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
        echo($archive ? "<p class='mt-5 alert alert-success'>Network ".$_POST['CollectionName']." has been archived.</p>" : "<p class='mt-5 alert alert-danger'>Network could not be archived.</p>");
    }

        /** Finally add the new entry line only if no update action **/
        if ($action !== 'update') {
            ?>
            <div class="row mb-5 collapse" id="formDiv">
                <form class="row g-3 needs-validation" method="post" action="<?=$base_url;?>" validate>
                    <div class="col-md-12 position-relative">
                        <input type="hidden" name="archive" value="false">
                        <input type="hidden" name="p" value="<?=$page;?>">
                        <label for="validationCustom01" class="form-label">Network name:</label>
                        <input type="text" class="form-control" name="CollectionName" id="validationCustom01" placeholder="BNB" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-12 position-relative">
                        <label for="validationCustom05" class="form-label">Network description:</label>
                        <textarea id="validationCustom05" class="form-control" rows="10" name="CollectionDescription" placeholder="BNB Coin is a cryptocurrency that is used primarily to pay transaction and trading fees on the Binance exchange."></textarea>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid description.
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
            <?php
        } // if action !== update

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
            $type_list = $NftPromoModel->getCollectionNetworkList();

            //** Show all event types in the tabel
            foreach ($type_list as $NftPromoModel_obj) {

                // Create update link
                $params = array('action' => 'update', 'id' => $NftPromoModel_obj->getNetworkId());
                $upd_link = add_query_arg($params, $base_url);
                
                // Create archive link
                $params = array('action' => 'archive', 'id' => $NftPromoModel_obj->getNetworkId(), 'p' => $page);
                $arc_link = add_query_arg($params, $base_url);

                // Create delete link
                $params = array('action' => 'delete', 'id' => $NftPromoModel_obj->getNetworkId(), 'p' => $page, 'colnetName' => $NftPromoModel_obj->getNetworkName().'-drops');
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                    <?php
                    // If update and id match show update form
                    // Add hidden field id for id transfer
                    if (($action == 'update') && ($NftPromoModel_obj->getNetworkId() == $get_array['id'])) {
                        ?>
                <div class="row">
                <div class="col-md-12 position-relative">
                    <label for="validationCustom01" class="form-label">Network name:</label>
                    <input type="hidden" name="id" value="<?=$NftPromoModel_obj->getNetworkId();?>">
                    <input type="hidden" name="p" value="<?=$page;?>">
                    <input type="hidden" name="archive" value="false">
                    <input type="text" class="form-control" name="CollectionName" id="validationCustom01" placeholder="BNB" required value="<?= $NftPromoModel_obj->getNetworkName(); ?>">
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                    <div class="invalid-feedback">
                    Please provide a valid network name.
                    </div>
                </div>
                <div class="col-md-12 position-relative">
                    <label for="validationCustom05" class="form-label">Network description:</label>
                    <textarea id="validationCustom05" class="form-control" rows="10" name="CollectionDescription" placeholder="BNB Coin is a cryptocurrency that is used primarily to pay transaction and trading fees on the Binance exchange."><?= $NftPromoModel_obj->getNetworkDescription(); ?></textarea>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                    <div class="invalid-feedback">
                    Please provide a valid description.
                    </div>
                </div>
                <div class="col-12 mt-4 mb-4">
                    <input type="submit" name="update" class="btn btn-success" value="Update">
                </div>
                    </div>
                    <?php } else { ?>
                        <td width="180"><?= $NftPromoModel_obj->getNetworkName(); ?></td>
                        <td width="200"><?= $NftPromoModel_obj->getNetworkDescription(); ?></td>
                        <?php if ($action !== 'update') {
                            // If action is update don’t show the action button
                            ?>
                            <td><a href="<?= $upd_link; ?>"><div class="nftIconAdminCheck" data-toggle="tooltip" data-placement="bottom" title="Edit"></div></a></td>
                            <td><a href="<?= $arc_link; ?>" onclick="return confirm('Are you sure you want to archive this network, by doing so this network will be deleted from the public usage and moved to archived records.?');"><div class="nftIconAdminArchive" data-toggle="tooltip" data-placement="bottom" title="Archive"></div></a></td>
                            <!-- <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this network?');"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td> -->
                            <?php
                        } // if action !== update
                        ?>
                    <?php } // if acton !== update ?>
                </tr>
                <?php
            }
            ?>
        <?php }
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
    $("#displayForm").click(function(){
        $('#formDiv').toggleClass('show');
    });
    $("#displayNetworkTable").click(function(){
        $('#networkDiv').toggleClass('show');
    });
});
</script>