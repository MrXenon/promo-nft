<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include_once PROMO_NFT_PLUGIN_MODEL_DIR . "/NftPromoModel.class.php";
$NftPromoModel = new NftPromoModel();
$page = basename(get_the_title(), 'Drops');
$pageId = $NftPromoModel->getColnetId($page);

if ($NftPromoModel->getNrOfPageCollections($pageId) < 1) {
}else{
    //if valid nft id has not been clicked, show the overview per category.
    if(!isset($_GET['nft'])){
        $col_list = $NftPromoModel->getPageCollectionList($pageId);
?>
<div class="container">
    <?php foreach($col_list as $obj){ 
        ?>
    <div class="row nftBorderTopBottom SingleNft  bg-nft-dark">
        <div class="col-md-3">
            <img src="<?= PROMO_NFT_PLUGIN_IMG_DIR . $obj->getCollectionImage();?>" style="width:100%;">
        </div>
        <div class="col-md-5">
            <h1 class="white"><?= $obj->getCollectionTitle();?></h1>
            <p class="white">
            <?= mb_strimwidth($obj->getCollectionDescription(), 0, 250, '...');?>
            </p>
        </div>
        <div class="col-md-4 border-left">
            <?php $date = strtotime($obj->getCollectionPreDate()); ?>
           <p class="white dateSupplySingle"> <?= date('d/m/Y',$date);?></p>
            <div class="inline">
                <div class="row toBottom">
                    <?php
                    $id = $obj->getCollectionNetwork();
                    $class = $obj->getNetworkById($id);
                    ?>
                    <div class="col-md-2"><div class="<?= $class; ?>"></div></div>
                    <div class="col-md-10"><p class="white dateSupplySingle"><?= $obj->getCollectionSupply();?></p></div>
                </div>
            </div>

            <div class="row bottom">
                <div class="col-md-6 inline">
                    <a href="<?= $obj->getCollectionSite();?>" target="_blank"><div class="nftIconWebsite spacer"></div></a>
                    <a href="<?= $obj->getCollectionTwitter();?>" target="_blank"><div class="nftIconTwitter spacer"></div></a>
                    <a href="<?= $obj->getCollectionDiscord();?>" target="_blank"><div class="nftIconDiscord spacer"></div></a>
                </div>
                <div class="col-md-6"><a href="<?=get_page_link()."?nft=".$obj->getCollectionId();?>" class="btn btn-purple btn-single">More!</a></div>
            </div>
        </div>
    </div>
    <?php }
    } 
    // collection_page
    if(isset($_GET['nft'])){
        $nft = $_GET['nft'];
        if(filter_var($nft, FILTER_VALIDATE_INT)){
            $col_list = $NftPromoModel->getPageNftCollectionList($nft);
            foreach($col_list as $obj){
        ?>
        <div class="container bg-nft-dark nftBorderBottom">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center white padding-top-20"><?= $obj->getCollectionTitle();?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <img src="<?= PROMO_NFT_PLUGIN_IMG_DIR . $obj->getCollectionImage();?>" class="NftSingle-img" alt="<?= $obj->getCollectionTitle();?>">
                </div>
                <div class="col-md-7 nftBorderBottom">
                <p class="white indent-top">
                    <?= $obj->getCollectionDescription();?>
                </p>
                </div>
            </div>
            <div class="row emptySpace">
                    <?php
                    $id = $obj->getCollectionNetwork();
                    $class = $obj->getNetworkById($id);
                    ?>
                <div class="col-md-6 white fs-25 inline">
                    <table class="alignNetworkTable">
                        <tr>
                            <td class="text-center">Network:</td>
                            <td class="text-center"><div class="<?= $class;?> NftDiv"></div></td>
                        </tr>
                    </table>
                </div>
                <?php $date = strtotime($obj->getCollectionDate()); ?>
                <?php $Predate = strtotime($obj->getCollectionPreDate()); ?>
                <div class="col-md-6 white text-center fs-25">Public Sale: <?= date('d/m/Y',$date);?></div>
            </div>
            <div class="row emptySpace">
                <div class="col-md-6 white text-center fs-25">Supply: <?= $obj->getCollectionSupply();?></div>
                <div class="col-md-6 white text-center fs-25">Pre sale: <?= date('d/m/Y',$Predate);?></div>
            </div>
            <div class="row emptySpace">
                <div class="col-md-6 white text-center fs-25">Mint price: <?=$obj->getCollectionPrice();?></div>
                <div class="col-md-6 inline text-center fs-25">
                    <a href="<?= $obj->getCollectionSite();?>" target="_blank"><div class="nftIconWebsite spacer"></div></a>
                    <a href="<?= $obj->getCollectionTwitter();?>" target="_blank"><div class="nftIconTwitter spacer"></div></a>
                    <a href="<?= $obj->getCollectionDiscord();?>" target="_blank"><div class="nftIconDiscord spacer"></div></a>
                </div>
            </div>
        </div>
        <?php
            }
        }else{
            //return user to page as the link is incorrect.
            echo '<script>window.location.replace("'.get_page_link().'");</script>';
        }
        }else{ /* $nft has not been assigned, show nothing*/ }
    ?>
</div>

<?php
}
?>