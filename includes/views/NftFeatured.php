<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

include_once PROMO_NFT_PLUGIN_MODEL_DIR . "/NftPromoModel.class.php";
// Declare class variable:
$NftPromoModel = new NftPromoModel();


if ($NftPromoModel->getNrOfFeaturedCollections() < 1) {
}else{
    $col_list       = $NftPromoModel->getCollectionFeaturedList();
?>
<div class="row">
        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">

    <?php foreach($col_list as $col_obj){ ?>
                <div class="carousel-item col-md-12">
                    <div class="featuredCard">
                        <div class="bg-dark padding-10 margin-10">
                            <h2 class="white text-center"><?= $col_obj->getCollectionTitle();?></h2>
                            <img class="featured-img" src="<?= PROMO_NFT_PLUGIN_IMG_DIR . $col_obj->getCollectionImage();?>">
                            <p class="white spacer">
                                <?= mb_strimwidth($col_obj->getCollectionDescription(), 0, 250, '...');?>
                            </p>
                            <hr class="border-purple">
                            <div class="row">
                                <div class="col-md-5">
                                    <p class="white dateSupply">
                                        <?php $date = strtotime($col_obj->getCollectionPreDate()); ?>
                                        <?= date('d/m/Y',$date);?>
                                    </p>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <?php
                                        $id = $col_obj->getCollectionNetwork();
                                        $class = $col_obj->getNetworkById($id);
                                        ?>
                                        <div class="col-md-2"><div class="<?= $class; ?>"></div></div>
                                        <div class="col-md-10"><div class="col-md-10 white dateSupply padding-20-left"><?= $col_obj->getCollectionSupply();?></div></div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row padding-10">
                                <div class="col-md-7">
                                    <div class="inline">
                                        <a href="<?= $col_obj->getCollectionSite();?>" target="_blank"><div class="nftIconWebsite"></div></a>
                                        <a href="<?= $col_obj->getCollectionTwitter();?>" target="_blank"><div class="nftIconTwitter"></div></a>
                                        <a href="<?= $col_obj->getCollectionDiscord();?>" target="_blank"><div class="nftIconDiscord"></div></a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <a href="<?=get_site_url().'/'.$class.'-drops/'?>" class="btn btn-purple">More!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?>
        </div>
    </div>
</div>

<?php }?>