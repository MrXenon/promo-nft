<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
add_shortcode('nft_featured_items','viewFeatured');
add_shortcode('nft_single','viewSingle');
add_shortcode('nft_add_collection','addCollection');
function viewFeatured($atts, $content = NULL){
    include PROMO_NFT_PLUGIN_INCLUDES_VIEWS_DIR . '/NftFeatured.php';
}

function viewSingle($atts, $content = NULL){
    include PROMO_NFT_PLUGIN_INCLUDES_VIEWS_DIR . '/NftSingle.php';
}

function addCollection($atts, $content = NULL){
    include PROMO_NFT_PLUGIN_INCLUDES_VIEWS_DIR . '/NftAddCollection.php';
}