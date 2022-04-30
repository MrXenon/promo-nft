<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

include_once PROMO_NFT_PLUGIN_MODEL_DIR . "/NftPromoModel.class.php";
// Declare class variable:
$NftPromoModel = new NftPromoModel();

global $post;
    $post_slug = $post->post_name;
$base_url = get_page_link();
$page = $post_slug;


$get_array = $NftPromoModel->getGetValues();

$action = FALSE;
if (!empty($get_array)) {

    if (isset($get_array['action'])) {
        $action = $NftPromoModel->handleGetAction($get_array);
    }
}
$post_array = $NftPromoModel->getPostValues();

$error = FALSE;
if (!empty($post_array['submit'])) {
    // Check if the project name exists anywhere in our database.
if($NftPromoModel->checkProjectName($post_array) == 'TRUE'){
    $checkProjName = TRUE;
    $add = FALSE;
    // If the project does not exist, save the project as a listing
        $result = $NftPromoModel->save($post_array);
        //If the project is stored in our database, send an e-mail to the administrator about the listing.
        if ($result) {
            $add = TRUE;
            $upload = $NftPromoModel->ImageUpload();
            //Define project mail parameters
            $projectProjectName             = $post_array['projectProjectName'];
            $projectName                    = $post_array['projectName'];
            $onderwerp                      = 'New NFT collection request';
            $adminEmail                     = get_bloginfo('admin_email');
            $parts                          = explode('@',$adminEmail);
            $noreplyEmail                   = 'no-reply@'.$parts[1];
            $listingUrl                     = '<a href="'.get_admin_url() . 'admin.php?page=nft_listings">View listing</a>';
            // Create mail message
            $message = $projectName . ' has added a new project called'. $projectProjectName. "\r\n" . 
            'Click the link to continue to the listing page and add the collection to the collection listing or decline the listing ' . $listingUrl; 
            // Create mail form
            $to = $adminEmail;
            $subject = $onderwerp;
            $headers = 'From: '. $noreplyEmail . "\r\n" .
            'Reply-To: ' . $noreplyEmail . "\r\n";
            // Send form
            $sent = wp_mail($to, $subject, strip_tags($message), $headers);
        } else {
            // Indicate error
            $error = TRUE;
        }
    }else{
        $checkProjName = FALSE;
    }
}
$Choice_list    = $NftPromoModel->getChoiceList();
$Network_list   = $NftPromoModel->getCollectionNetworkList();
?>

<div class="container">
    <div class="row text-center">
        <h2>Lets get some info</h2>
        <p>Fill in the form below to get your NFT project into the calendar.</p>
        <p>Want to stand out on the website ask us about the premium Advertising.</p>
    </div>
    <div class="row">
        <div class="col-md-12">
                <?php
                if (isset($checkProjName)) {
                    echo($checkProjName ? "" : "<p class='mt-5 text-center alert alert-warning'>Project name ".$projectProjectName." already exists in our database, please add a new one.</p>");
                }
                if (isset($add)) {
                    echo($add ? "<p class='mt-5 alert text-center alert-success'>Collection ".$projectProjectName." has been submitted.</p>" : "<p class='mt-5 text-center alert alert-danger'>Collection could not be added.</p>");
                }
                if (isset($sent)) {
                    echo($sent ? '<p class="alert text-center alert-success">Collection has been succesfully submitted.</p>':'');
                }
                ?>
        </div>
    </div>
      <div class="row">
        <form action="<?=$base_url;?>" method="post" class="nft-form" >
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectProjectName" class="form-label">Project Name *</label>
                            <input type="text" maxlength="255" class="" required name="projectProjectName" id="projectProjectName" required>
                            <input type="hidden" name="p" value="<?=$page;?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectName" class="form-label">Your Name *</label>
                            <input type="text" maxlength="255" class="" required name="projectName" id="projectName" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="email" class="form-label">Your E-mailaddress *</label>
                            <input type="email" maxlength="255" class="" required name="projectEmail" id="projectEmail" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                    <label for="projectDescription" class="form-label">Project description</label>
                        <textarea class="" maxlength="1024" required name="projectDescription" style="resize:none;" id="projectDescription" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="projectMintDate" class="form-label">Public Mint Date *</label>
                        <input type="date" class="" required name="projectMintDate" id="projectMintDate" required>
                    </div>
                    <div class="col-md-6">
                    <label for="projectPreSaleDate" class="form-label">Pre Sale Date(optional)</label>
                        <input type="date" class="" required name="projectPreSaleDate" id="projectPreSaleDate">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <label for="projectNetwork" class="form-label">Project Network *</label>
                        <select name="projectNetwork" class="form-control" list="datalistOptions" id="projectNetwork" required> >
                            <?php foreach ($Network_list as $Network) { ?>
                                <datalist id="datalistOptions">
                                <option value="<?= $Network->getNetworkId() ?>"> <?= $Network->getNetworkName(); ?> </option>
                            </datalist>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                    <label for="projectMintPrice" class="form-label">Mint Price *</label>
                        <input type="number" class="" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="255" required name="projectMintPrice" id="projectMintPrice" required>
                    </div>
                    <div class="col-md-4">
                    <label for="projectSupply" class="form-label">Total Supply *</label>
                        <input type="number" class="" min="1" step="1" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only" required name="projectSupply" id="projectSupply" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectTwitter" class="form-label">Project Twitter *</label>
                            <input type="text" class="" maxlength="255" required name="projectTwitter" id="projectTwitter" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectDiscord" class="form-label">Project Discord *</label>
                            <input type="text" class="" maxlength="255" required name="projectDiscord" id="projectDiscord" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectWebsite" class="form-label">Project Website *</label>
                            <input type="text" class="" maxlength="255" required name="projectWebsite" id="projectWebsite" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <label for="projectImage" class="form-label">Project Image *</label>
                            <input type="file" name="fileToUpload" class="form-control customLineHeight" id="inputGroupFile02" value=""
                            onchange="document.getElementById('projectImage').value = this.value.split('\\').pop().split('/').pop()" required>
                            <input type="hidden" class="form-control" readonly id="projectImage" name="projectImage" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <label for="projectFeatured" class="form-label">Recieve info about being featured on the home page?</label>
                            <select name="projectFeatured" class="" list="datalistOptions" id="projectFeatured" required>
                            <?php foreach ($Choice_list as $choice) { ?>
                                <datalist id="datalistOptions">
                                <option value="<?= $choice->getChoiceVar() ?>"> <?= $choice->getChoice(); ?> </option>
                            </datalist>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <input type="submit" value="Submit project" name="submit" class="btn btn-purple">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>