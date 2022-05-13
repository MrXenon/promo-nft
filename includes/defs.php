<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

define ( 'PROMO_NFT_VERSION', '1.0.4.1' );

define ( 'PROMO_NFT_REQUIRED_WP_VERSION', '4.0' );

define ( 'PROMO_NFT_PLUGIN_BASENAME', plugin_basename( PROMO_NFT_PLUGIN ) );

define ( 'PROMO_NFT_PLUGIN_NAME', trim( dirname ( PROMO_NFT_PLUGIN_BASENAME ), '/' ) );

define ( 'PROMO_NFT_PLUGIN_DIR', untrailingslashit( dirname ( PROMO_NFT_PLUGIN ) ) );

define ( 'PROMO_NFT_PLUGIN_INCLUDES_DIR', PROMO_NFT_PLUGIN_DIR . '/includes' );

define ( 'PROMO_NFT_PLUGIN_ICONS_DIR', get_site_url() . '/wp-content/plugins/'. PROMO_NFT_PLUGIN_NAME . '/icons' );

define ( 'PROMO_NFT_PLUGIN_ICONS_CRYPTO_DIR', PROMO_NFT_PLUGIN_ICONS_DIR . '/crypto' );

define ( 'PROMO_NFT_PLUGIN_IMG_DIR', get_site_url() . '/wp-content/uploads' . '/promo-nft-images/' );

define ( 'PROMO_NFT_PLUGIN_INCLUDES_VIEWS_DIR', PROMO_NFT_PLUGIN_INCLUDES_DIR	. '/views'	);

define ( 'PROMO_NFT_PLUGIN_MODEL_DIR', PROMO_NFT_PLUGIN_INCLUDES_DIR . '/model' );

define ( 'PROMO_NFT_PLUGIN_ADMIN_DIR', PROMO_NFT_PLUGIN_DIR . '/admin' );

define ( 'PROMO_NFT_PLUGIN_ADMIN_VIEWS_DIR', PROMO_NFT_PLUGIN_ADMIN_DIR . '/views' );

?>