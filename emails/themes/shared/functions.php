<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function get_asset_url() {

	// folder for icons
	$asset_domain = get_theme_root_uri();
	$asseturl     = wp_slash( str_replace( '/themes', '/', $asset_domain ) );
	$asset_folder = dirname( __FILE__, 2 );
	if ( stripos( $asset_folder, 'wp-content' ) ) {
		$folders  = explode( 'wp-content/', $asset_folder );
		$asseturl .= $folders[1] . '/';
	} elseif ( stripos( $asset_folder, 'ictuwp-extension-template-newsletter-do' ) ) {
		// template served from Github dev. folder
		$folders  = explode( 'ictuwp-extension-template-newsletter-do/', $asset_folder );
		$asseturl .= 'extensions/newsletter/' . $folders[1] . '/';
	}

	$asseturl .= 'digitaleoverheid/';

	return $asseturl;

}
