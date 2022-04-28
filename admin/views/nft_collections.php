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
    $upload = $NftPromoModel->ImageUpload();
    if ($upload == 1) {
        $result = $NftPromoModel->save($post_array);
        $uploadAdd = TRUE;
        if($result){
            $add = TRUE;
        }else{
            $add = FALSE;
        }
    } else {
            $add = FALSE;
            $uploadAdd = FALSE;
    }
}

if (!empty($post_array['update'])) {

    // Check the add form:
    $update = FALSE;
    // Save event types
    $result = $NftPromoModel->update($post_array);
    $upload = $NftPromoModel->ImageUploadUpdate($post_array);
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
$Network_list = $NftPromoModel->getCollectionNetworkList();
$type_list = $NftPromoModel->getCollectionList();

?>


<div class="container">
    <div class="mt-4">
        <button class="btn btn-primary" id="displayForm">Display Form</button>
        <button class="btn btn-primary" id="displayNetworkTable">Display Network table</button>
    </div>

    <?php
    if (isset($add)) {
        echo($add ? "<p class='mt-5 alert alert-success'>Collection ".$_POST['CollectionName']." has been added.</p>" : "<p class='mt-5 alert alert-danger'>Collection could not be added.</p>");
    }

    if (isset($uploadAdd)) {
        echo($uploadAdd ? "<p class='mt-5 alert alert-success'>Collection ".$_POST['CollectionImage']." has been uploaded.</p>" : "<p class='mt-5 alert alert-danger'>Image could not be uploaded.</p>");
    }


    if (isset($update)) {
        echo($update ? "<p class='mt-5 alert alert-success'>Collection ".$_POST['CollectionName']." has been updated.</p>" : "<p class='mt-5 alert alert-danger'>Collection could not be updated.</p>");
    }

    if (isset($del)) {
        echo($del ? "<p class='mt-5 alert alert-success'>Collection ".$_POST['CollectionName']." has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Collection could not be deleted.</p>");
    }

    if (isset($archive)) {
        echo($archive ? "<p class='mt-5 alert alert-success'>Collection ".$_POST['CollectionName']." has been archived.</p>" : "<p class='mt-5 alert alert-danger'>Collection could not be archived.</p>");
    }

        /** Finally add the new entry line only if no update action **/
        if ($action !== 'update') {
            ?>
            <div class="row mb-5 collapse" id="formDiv">
                <form class="row g-3 needs-validation" method="post" action="<?=$base_url;?>" validate enctype="multipart/form-data">
                    <div class="col-md-4 position-relative">
                        <input type="hidden" name="archive" value="false">
                        <input type="hidden" name="p" value="<?=$page;?>">
                        <label for="validationCustom01" class="form-label">Title:</label>
                        <input type="text" class="form-control" maxlength="64" name="CollectionName" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Date:</label>
                        <input type="datetime-local" class="form-control" name="CollectionDate" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Presale date:</label>
                        <input type="date" class="form-control" name="CollectionPredate" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Collection network:</label>
                        <select name="CollectionNetId" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..."> required>
                            <?php foreach ($Network_list as $Network) { ?>
                                <datalist id="datalistOptions">
                                <option value="<?= $Network->getNetworkId() ?>"> <?= $Network->getNetworkName(); ?> </option>
                            </datalist>
                            <?php } ?>
                        </select>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Supply:</label>
                        <input type="number" min="1" step="1" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only" class="form-control" name="CollectionSupply" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Price:</label>
                        <input type="text" class="form-control" maxlength="255" name="CollectionPrice" id="validationCustom01"  placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Website url:</label>
                        <input type="text" class="form-control" maxlength="255" name="CollectionSite" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Twitter:</label>
                        <input type="text" class="form-control" maxlength="255" name="CollectionTwitter" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label for="validationCustom01" class="form-label">Discord:</label>
                        <input type="text" class="form-control" maxlength="255" name="CollectionDiscord" id="validationCustom01" placeholder="" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-2 position-relative">
                        <label for="validationCustom01" class="form-label">Featured:</label>
                            <input class="form-check-input" name="CollectionFeatured" type="checkbox" id="">
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-6 position-relative">
                        <div class="input-group">
                            <input type="file" name="fileToUpload" class="form-control customLineHeight" id="inputGroupFile02" value=""
                            onchange="document.getElementById('image').value = this.value.split('\\').pop().split('/').pop()">
                            <input type="hidden" class="form-control" readonly id="image" name="CollectionImage" value="">
                            <input type="hidden" class="form-control" readonly id="imageCheck" name="imageCheck" value="">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid network name.
                        </div>
                    </div>
                    <div class="col-md-12 position-relative">
                        <label for="validationCustom05" class="form-label">Description:</label>
                        <textarea id="validationCustom05" maxlength="1024" class="form-control" rows="10" name="CollectionDescription" placeholder="Some text"></textarea>
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
    echo(($action == 'update') ? '<form action="' . $base_url . '" method="post" enctype="multipart/form-data">' : '');
    ?>
<div class="table-responsive">
    <table class="table table-light table-hover collapse" id="networkDiv">
        <thead>
        <tr>
            <th width="200">Title</th>
            <th width="1000">Description</th>
            <th width="200">Date</th>
            <th width="200">Predate</th>
            <th width="200">Network</th>
            <th width="200">Supply</th>
            <th width="200">Links</th>
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

            //** Show all event types in the tabel
            foreach ($type_list as $NftPromoModel_obj) {

                // Create update link
                $params = array('action' => 'update', 'id' => $NftPromoModel_obj->getCollectionId());
                $upd_link = add_query_arg($params, $base_url);
                
                // Create archive link
                $params = array('action' => 'archive', 'id' => $NftPromoModel_obj->getCollectionId(), 'p' => $page);
                $arc_link = add_query_arg($params, $base_url);

                // Create delete link
                $params = array('action' => 'delete', 'id' => $NftPromoModel_obj->getCollectionId(), 'p' => $page);
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                    <?php
                    // If update and id match show update form
                    // Add hidden field id for id transfer
                    if (($action == 'update') && ($NftPromoModel_obj->getCollectionId() == $get_array['id'])) {
                        ?>
                <div class="row">
                    <div class="col-md-4 position-relative">
                            <input type="hidden" name="id" value="<?=$NftPromoModel_obj->getCollectionId();?>">
                            <input type="hidden" name="archive" value="0">
                            <input type="hidden" name="p" value="<?=$page;?>">
                            <label for="validationCustom01" class="form-label">Title:</label>
                            <input type="text" class="form-control" maxlength="64" name="CollectionName" id="validationCustom01" value="<?=$NftPromoModel_obj->getCollectionTitle();?>"required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Date:</label>
                            <?php $date = date("Y-m-d\TH:i:s", strtotime($NftPromoModel_obj->getCollectionDate())); ?>
                            <input type="datetime-local" class="form-control" name="CollectionDate" id="validationCustom01"value="<?=$date;?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Presale date:</label>
                            <input type="date" class="form-control" name="CollectionPredate" id="validationCustom01" value="<?=$NftPromoModel_obj->getCollectionPreDate();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Collection network:</label>
                            <select name="CollectionNetId" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." required>
                                    <datalist id="datalistOptions">
                                    <?php 
                                        foreach ($Network_list as $Network) { 
                                        ?>
                                        <option value="<?= $Network->getNetworkId(); ?>"
                                            <?php if ($Network->getNetworkId() == $NftPromoModel_obj->getCollectionNetwork()) {echo 'selected'; } ?>><?= $Network->getNetworkName(); ?>
                                        </option>
                                    <?php }
                                    ?>
                                </datalist>
                            </select>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Supply:</label>
                            <input type="number" min="1" step="1" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only" class="form-control" name="CollectionSupply" id="validationCustom01"value="<?=$NftPromoModel_obj->getCollectionSupply();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Price:</label>
                            <input type="text" class="form-control" maxlength="255" name="CollectionPrice" id="validationCustom01"  value="<?=$NftPromoModel_obj->getCollectionPrice();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Website url:</label>
                            <input type="text" class="form-control" maxlength="255" name="CollectionSite" id="validationCustom01" value="<?=$NftPromoModel_obj->getCollectionSite();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Twitter:</label>
                            <input type="text" class="form-control" maxlength="255" name="CollectionTwitter" id="validationCustom01" value="<?=$NftPromoModel_obj->getCollectionTwitter();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="validationCustom01" class="form-label">Discord:</label>
                            <input type="text" class="form-control" maxlength="255" name="CollectionDiscord" id="validationCustom01" value="<?=$NftPromoModel_obj->getCollectionDiscord();?>" required>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-2 position-relative">
                            <label for="validationCustom01" class="form-label">Featured:</label>
                                <input class="form-check-input" name="CollectionFeatured" type="checkbox" id="" <?php if($NftPromoModel_obj->getCollectionFeatured() == 'on'){echo 'checked';}else {} ?>>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <div class="input-group">
                                <input type="file" name="fileToUpload" class="form-control customLineHeight" id="inputGroupFile02" value=""
                                onchange="document.getElementById('image').value = this.value.split('\\').pop().split('/').pop()">
                                <input type="hidden" class="form-control" readonly id="image" name="CollectionImage" value="<?=$NftPromoModel_obj->getCollectionImage();?>">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid network name.
                            </div>
                        </div>
                        <div class="col-md-12 position-relative">
                            <label for="validationCustom05" class="form-label">Description:</label>
                            <textarea id="validationCustom05" maxlength="1024" class="form-control" rows="10" name="CollectionDescription" placeholder="Some text"><?=$NftPromoModel_obj->getCollectionDescription();?></textarea>
                            <div class="valid-feedback">
                            Looks good!
                            </div>
                            <div class="invalid-feedback">
                            Please provide a valid description.
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="update" class="btn btn-primary" value="Update">
                        </div>
                    </div>
                    <?php } else { ?>
                        <td width="180"><?= $NftPromoModel_obj->getCollectionTitle(); ?></td>
                        <td width="1000"><?= mb_strimwidth($NftPromoModel_obj->getCollectionDescription(), 0, 150, '...'); ?></td>
                        <td width="200"><?= $NftPromoModel_obj->getCollectionDate(); ?></td>
                        <td width="200"><?= $NftPromoModel_obj->getCollectionPreDate(); ?></td>
                        <td width="200">
                        <?php 
                        $id = $NftPromoModel_obj->getCollectionNetwork();
                            if(($NftPromoModel_obj->getNetworkById($id)) == '') {
                            }else {
                                echo($NftPromoModel_obj->getNetworkById($id));
                            }
                        ?>
                        </td>
                        <td width="200"><?= $NftPromoModel_obj->getCollectionSupply(); ?></td>
                        <td width="200"><a href="<?= $NftPromoModel_obj->getCollectionSite(); ?>"><div class="nftIconWebsiteBack"></div></a>
                        <a href="<?= $NftPromoModel_obj->getCollectionTwitter(); ?>"><div class="nftIconTwitterBack"></div></a>
                        <a href="<?= $NftPromoModel_obj->getCollectionDiscord(); ?>"><div class="nftIconDiscordBack"></div></a></td>
                        <td width="200"><?= $NftPromoModel_obj->getCollectionPrice(); ?></td>
                        <td width="200"><?= $NftPromoModel_obj->getCollectionFeatured(); ?></td>
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