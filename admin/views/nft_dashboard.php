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

$ColNetNr   =   $NftPromoModel->getNrOfCollectionNetworks();
$ColNr      =   $NftPromoModel->getNrOfCollections();
$featured   =   $NftPromoModel->getNrOfFeaturedCollections();
$ArchiveNet =   $NftPromoModel->getNrOfArchivedNetworks();
$ArchivedCol=   $NftPromoModel->getNrOfArchivedCollections();
$Shortcodes =   $NftPromoModel->getNftShortcodes();
$Author     =   $NftPromoModel->getNftAuthor();
$updateLog  =   $NftPromoModel->getNftUpdateLog();
$changeLog  =   $NftPromoModel->getNftChangeLog();
?>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<style>
.row{
    margin-left 0;
    margin-right: 0;
}
.card{
    height: 125px;
}
</style>

<div class="grey-bg container-fluid">
  <section id="minimal-statistics">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
        <h4 class="text-uppercase">Dashboard</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-rocket primary font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?= $ColNetNr;?></h3>
                  <span>Collection Networks</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-pie-chart warning font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?=$ColNr;?></h3>
                  <span>NFT Collections</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-graph success font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?=$featured;?></h3>
                  <span>Featured collections</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-folder danger font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?= $ArchiveNet + $ArchivedCol;?></h3>
                  <span>Archived items</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="minimal-statistics">
    <div class="row">
    </div>
    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-folder primary font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?= $ArchiveNet;?></h3>
                  <span>Archived Networks</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-folder warning font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?=$ArchivedCol;?></h3>
                  <span>Archived Collections</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shortcodes">
                        View shortcodes
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changelog">
                        View changelog
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateHistory">
                        Update history
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#author">
                        Author
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- Shortcodes -->
<div class="modal fade" id="shortcodes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shortcodes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php 
        foreach($Shortcodes as $obj){
          echo '<strong>'.$obj->getShortName().'</strong> '.  $obj->getShortDesc(). '<br><br> ';
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Changelog -->
<div class="modal fade" id="changelog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Changelog</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php foreach($changeLog as $obj){ ?>
          <p><?=$obj->getUpdateDesc();?></p>
            <h5><strong><?=$obj->getUpdateVersion();?> contains:</strong></h5>
            <ul style="font-size:13px;">
              <?=$obj->getUpdateList();?>
            </ul>
            <p><?=$obj->getUpdateFdesc();?></p>
            <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Update history -->
<div class="modal fade" id="updateHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <?php foreach($updateLog as $obj){ ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="<?=$obj->getUpdateVersion();?>" data-bs-toggle="tab" data-bs-target="#version<?=$obj->getUpdateId();?>" type="button" role="tab" aria-controls="<?=$obj->getUpdateVersion();?>" aria-selected="true"><?=$obj->getUpdateVersion();?></button>
        </li>
          <?php }?>
      </ul>
      <div class="tab-content" id="myTabContent">
      <?php foreach($updateLog as $obj){ ?>
        <div class="tab-pane fade" id="version<?=$obj->getUpdateId();?>" role="tabpanel" aria-labelledby="test">
          <div class="tab-pane fade show" id="<?=$obj->getUpdateVersion();?>" role="tabpanel" aria-labelledby="<?=$obj->getUpdateVersion();?>">
            <p><?=$obj->getUpdateDesc();?></p>
            <h5><strong><?=$obj->getUpdateVersion();?> contains:</strong></h5>
            <ul style="font-size:13px;">
              <?=$obj->getUpdateList();?>
            </ul>
            <p><?=$obj->getUpdateFdesc();?></p>
          </div>
        </div>
        <?php } ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Update history -->
<div class="modal fade" id="author" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        foreach($Author as $obj){
          echo $obj->getAuthorName() . ' <a href="'.$obj->getAuthorSite().'" target="_blank">Visit author page</a>';
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>