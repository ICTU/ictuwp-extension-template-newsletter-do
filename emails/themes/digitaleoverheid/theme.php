<?php
global $newsletter; // Newsletter object
global $post; // Current post managed by WordPress

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Some variabled are prepared by Newsletter Plus and are available inside the theme,
 * for example the theme options used to build the email body as configured by blog
 * owner.
 *
 * $theme_options - is an associative array with theme options: every option starts
 * with "theme_" as required. See the theme-options.php file for details.
 * Inside that array there are the autmated email options as well, if needed.
 * A special value can be present in theme_options and is the "last_run" which indicates
 * when th automated email has been composed last time. Is should be used to find if
 * there are now posts or not.
 *
 * $is_test - if true it means we are composing an email for test purpose.
 */


// This array will be passed to WordPress to extract the posts
$filters = array();

// Maximum number of post to retrieve
$filters['posts_per_page'] = 5;
if ( isset( $theme_options['theme_max_posts'] ) ) {
	$filters['posts_per_page'] = ( int ) $theme_options['theme_max_posts'];
}
if ( $filters['posts_per_page'] == 0 ) {
	$filters['posts_per_page'] = 5;
}

if ( ! empty( $theme_options['theme_tags'] ) ) {
	$filters['tag'] = $theme_options['theme_tags'];
}


$uitgelicht = 0;


if ( ! empty( $theme_options['theme_select_uitgelicht'] ) ) {

	$uitgelicht = get_post( $theme_options['theme_select_uitgelicht'] );

	// uitgelicht niet mee nemen in andere berichten
	$filters['exclude'] = array( $uitgelicht->ID );

}

// Maximum number of events to retrieve
$filters['theme_max_agenda'] = 5;
if ( isset( $theme_options['theme_max_agenda'] ) ) {
	$filters['theme_max_agenda'] = ( int ) $theme_options['theme_max_agenda'];
}
if ( $filters['theme_max_agenda'] == 0 ) {
	$filters['theme_max_agenda'] = 5;
}


// Include only posts from specified categories. Do not filter per category is no
// one category has been selected.
if ( isset( $theme_options['theme_categories'] ) ) {
	if ( is_array( $theme_options['theme_categories'] ) ) {
		$filters['cat'] = implode( ',', $theme_options['theme_categories'] );
	}
}


// Retrieve the posts asking them to WordPress
$posts = get_posts( $filters );

$counter       = count( $posts );
$linkeraantal  = round( ( $counter / 2 ), 0 );
$rechteraantal = ( $counter - $linkeraantal );


// Styles
$color = isset( $theme_options['theme_color'] ) ? $theme_options['theme_color'] : '#777';
if ( empty( $color ) ) {
	$color = '#777';
}


$font                            = isset( $theme_options['theme_font'] ) ? $theme_options['theme_font'] : '';
$font_size                       = isset( $theme_options['theme_font_size'] ) ? $theme_options['theme_font_size'] : '';
$theme_nieuwsbrieftitel_datetext = isset( $theme_options['theme_nieuwsbrieftitel_datetext'] ) ? $theme_options['theme_nieuwsbrieftitel_datetext'] : date( get_option( 'date_format' ) );
$colofon_blok1                   = isset( $theme_options['theme_colofon_block_1'] ) ? $theme_options['theme_colofon_block_1'] : 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.';
$colofon_blok2                   = isset( $theme_options['theme_colofon_block_2'] ) ? $theme_options['theme_colofon_block_2'] : 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>';
$theme_piwiktrackercode          = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';
$theme_titel_nieuws              = isset( $theme_options['theme_titel_nieuws'] ) ? $theme_options['theme_titel_nieuws'] : 'Nieuws';
$theme_titel_events              = isset( $theme_options['theme_titel_events'] ) ? $theme_options['theme_titel_events'] : 'Agenda';
$theme_titel_socials             = isset( $theme_options['theme_titel_socials'] ) ? $theme_options['theme_titel_socials'] : 'Social media';
$theme_sitetitle                 = isset( $theme_options['theme_sitetitle'] ) ? $theme_options['theme_sitetitle'] : get_bloginfo( 'name' );
$theme_sitepayoff                = isset( $theme_options['theme_sitepayoff'] ) ? $theme_options['theme_sitepayoff'] : get_bloginfo( 'description' );
$theme_socials_twitter_url       = isset( $theme_options['theme_socials_twitter_url'] ) ? $theme_options['theme_socials_twitter_url'] : '';
$theme_socials_twitter_linktext  = isset( $theme_options['theme_socials_twitter_linktext'] ) ? $theme_options['theme_socials_twitter_linktext'] : '';
$theme_socials_linkedin_url      = isset( $theme_options['theme_socials_linkedin_url'] ) ? $theme_options['theme_socials_linkedin_url'] : '';
$theme_socials_linkedin_linktext = isset( $theme_options['theme_socials_linkedin_linktext'] ) ? $theme_options['theme_socials_linkedin_linktext'] : '';
$theme_socials_linkedin_linktext = isset( $theme_options['theme_socials_linkedin_linktext'] ) ? $theme_options['theme_socials_linkedin_linktext'] : '';
$theme_mail_unsubscribe_text     = isset( $theme_options['theme_mail_unsubscribe_text'] ) ? $theme_options['theme_mail_unsubscribe_text'] : 'Wilt u deze nieuwsbrief niet meer ontvangen?';
$theme_mail_unsubscribe_linktext = isset( $theme_options['theme_mail_unsubscribe_linktext'] ) ? $theme_options['theme_mail_unsubscribe_linktext'] : 'Meld u zich hier af';
$theme_preview_text              = isset( $theme_options['theme_preview_text'] ) ? $theme_options['theme_preview_text'] : $theme_nieuwsbrieftitel_datetext;


//$asseturl = $_SERVER['HTTPS'] . $_SERVER['SERVER_NAME'] . '/';

$asset_domain = get_theme_root_uri();
$asseturl     = wp_slash( str_replace( '/themes', '/', $asset_domain ) );
$asset_folder = dirname( __FILE__ );
if ( stripos( $asset_folder, 'wp-content' ) ) {
	$folders  = explode( 'wp-content/', $asset_folder );
	$asseturl .= $folders[1] . '/';
}


//========================================================================================================

/**
 * Accepts a post or a post ID.
 *
 * @param WP_Post $post
 */
function rhswp_newsletter_get_excerpt( $post, $words = 80 ) {
	$post    = get_post( $post );
	$excerpt = $post->post_excerpt;
	if ( empty( $excerpt ) ) {
		$excerpt = $post->post_content;
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = wp_strip_all_tags( $excerpt, true );
	}

	return wp_trim_words( $excerpt, $words );
}

//========================================================================================================

function mail_get_label( $postID = 0 ) {
	$return = '&nbsp;';
	if ( ( $postID ) && function_exists( 'rhswp_get_sublabel' ) ) {
		$return = strtoupper( rhswp_get_sublabel( $postID ) );
	}

	return $return;
}

//========================================================================================================

function write_bericht( $postobject, $theme_options ) {

	$return                 = '';
	$theme_piwiktrackercode = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';

	if ( $postobject ) {

		$uitgelicht_image_size = 'image-5x3-small';
		$uitgelicht_title      = $postobject->post_title;
		$uitgelicht_label      = mail_get_label( $postobject->ID );
		$uitgelicht_date       = get_the_date( get_option( 'date_format' ), $postobject->ID );
		$uitgelicht_excerpt    = rhswp_newsletter_get_excerpt( $postobject->ID );
		$uitgelicht_url        = get_permalink( $postobject->ID ) . $theme_piwiktrackercode;
		$image                 = wp_get_attachment_image_src( get_post_thumbnail_id( $postobject->ID ), $uitgelicht_image_size );
		if ( $image ) {
			$alt   = 'Lees ' . $uitgelicht_title;
			$image = '<tr><td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;"><a href="' . $uitgelicht_url . '" role="presentation" tabindex="-1"><img alt="' . $alt . '" src="' . $image[0] . '" width="264" class="mcnImage"></a></td></tr>';
		}

		$return = '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
<tbody class="mcnCaptionBlockOuter">
<tr>
  <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
    <table role="presentation" align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent">
      <tbody>' . $image . '
      <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;" width="264">
          <p style="font-size:14px"><strong><span style="color:#696969; text-transform:uppercase">' . $uitgelicht_label . '</span></strong></p>
          <h3 class="null"><a href="' . $uitgelicht_url . '" style="color:#01689B; text-decoration: none"><strong><span style="font-size:18px; line-height:24px; margin: 12px 0px;">' . $uitgelicht_title . '</span></strong></a></h3>
          <p style="font-size:14px"><strong>' . $uitgelicht_date . '</strong></p>
          <p>' . $uitgelicht_excerpt . '</p></td>
      </tr>
      </tbody>
    </table>
  </td>
</tr>
</tbody>
</table>';
	}


	echo $return;


}

//========================================================================================================

function maak_event( $eventobject, $asseturl, $theme_options ) {

	$return                 = '';
	$theme_piwiktrackercode = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';

	if ( $eventobject ) {
		$uitgelicht_url = get_permalink( $eventobject->ID ) . $theme_piwiktrackercode;
		$datum          = $eventobject->output( '#_EVENTDATES' );
		$tijd           = $eventobject->output( '#_EVENTTIMES' );
// $location_town = $eventobject->output( '#_LOCATIONTOWN' );

		$return = '<h3><a href="' . $uitgelicht_url . '"><strong><span style="font-size:18px; line-height:24px; color:#01689B">' . get_the_title( $eventobject->ID ) . '</span></span></strong></a></h3>';
		if ( $datum ) {
			$return .= '<img alt="datum" height="12" src="' . $asseturl . 'icon_calendar.jpeg" style="border: 0px; width: 12px; height: 12px; margin: 0px;" width="12">&nbsp;&nbsp;' . $datum . '<br>';
		}
		if ( $tijd ) {
			$return .= '<img alt="tijd" height="12" src="' . $asseturl . 'icon_clock.jpeg" style="border: 0px; width: 12px; height: 12px; margin: 0px;" width="12">&nbsp;&nbsp;' . $tijd . '<br><br>';
		}

	}

	return $return;
}

//========================================================================================================


?>
<!doctype html>
<html lang="nl" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
	  xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $theme_nieuwsbrieftitel_datetext ?></title>
	<style type="text/css">
		p {
			margin: 10px 0;
			padding: 0;
		}

		table {
			border-collapse: collapse;
		}

		h1, h2, h3, h4, h5, h6 {
			display: block;
			margin: 0;
			padding: 0;
		}

		img, a img {
			border: 0;
			height: auto;
			outline: none;
			text-decoration: none;
		}

		body, #bodyTable, #bodyCell {
			height: 100%;
			margin: 0;
			padding: 0;
			width: 100%;
		}

		.mcnPreviewText {
			display: none !important;
		}

		#outlook a {
			padding: 0;
		}

		img {
			-ms-interpolation-mode: bicubic;
		}

		table {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		.ReadMsgBody {
			width: 100%;
		}

		.ExternalClass {
			width: 100%;
		}

		p, a, li, td, blockquote {
			mso-line-height-rule: exactly;
		}

		a[href^=tel], a[href^=sms] {
			color: inherit;
			cursor: default;
			text-decoration: none;
		}

		p, a, li, td, body, table, blockquote {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		.ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font {
			line-height: 100%;
		}

		a {
			text-decoration: none;
			cursor: pointer;
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		a:hover {
			text-decoration: underline !important;

			color: #01689b;
		}

		.templateContainer {
			max-width: 600px !important;
			margin: 0 auto;
		}

		a.mcnButton {
			display: block;
		}

		.mcnImage, .mcnRetinaImage {
			vertical-align: bottom;
		}

		.mcnTextContent {
			word-break: break-word;
		}

		.mcnTextContent img {
			height: auto !important;
		}

		.mcnDividerBlock {
			table-layout: fixed !important;
		}

		.columnWrapper {
			float: left;
			text-align: left;
		}

		body, #bodyTable {
			background-color: #FAFAFA;
		}

		#bodyCell {
			border-top: 0;
		}

		h1 {
			color: #202020;
			font-family: Helvetica;
			font-size: 26px;
			font-style: normal;
			font-weight: bold;
			line-height: 125%;
			letter-spacing: normal;
			text-align: left;
		}

		h2 {
			color: #202020;
			font-family: Helvetica;
			font-size: 22px;
			font-style: normal;
			font-weight: bold;
			line-height: 125%;
			letter-spacing: normal;
			text-align: left;
		}

		h3 {
			color: #202020;
			font-family: Helvetica;
			font-size: 20px;
			font-style: normal;
			font-weight: bold;
			line-height: 125%;
			letter-spacing: normal;
			text-align: left;
		}

		h4 {
			color: #202020;
			font-family: Helvetica;
			font-size: 18px;
			font-style: normal;
			font-weight: bold;
			line-height: 125%;
			letter-spacing: normal;
			text-align: left;
		}

		#templatePreheader {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			border-bottom: 0;
			padding-top: 9px;
			padding-bottom: 9px;
		}

		#templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
			color: #656565;
			font-family: Helvetica;
			font-size: 12px;
			line-height: 150%;
			text-align: left;
		}

		#templatePreheader .mcnTextContent a, #templatePreheader .mcnTextContent p a {
			color: #04689b;
			font-weight: normal;
			text-decoration: underline;
		}

		#templateHeader {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			border-bottom: 0;
			padding-top: 0px;
			/* padding-bottom:25px; */
		}

		#templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
			color: #202020;
			font-family: Helvetica;
			font-size: 16px;
			line-height: 150%;
			text-align: center;
		}

		#templateHeader .mcnTextContent a, #templateHeader .mcnTextContent p a {
			color: #007C89;
			font-weight: normal;
			/* text-decoration:underline; */
		}

		#templateUpperBody {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			border-bottom: 0;
			padding-top: 0;
			padding-bottom: 0;
		}

		#templateUpperBody .mcnTextContent, #templateUpperBody .mcnTextContent p {
			color: #202020;
			font-family: Helvetica;
			font-size: 16px;
			line-height: 150%;
			text-align: left;
		}

		#templateUpperBody .mcnTextContent a, #templateUpperBody .mcnTextContent p a {
			color: #04689b;
			font-weight: normal;
			/* text-decoration:underline; */
		}

		#templateColumns {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			border-bottom: 0;
			padding-top: 0;
			padding-bottom: 16px;
		}

		#templateColumns .columnContainer .mcnTextContent, #templateColumns .columnContainer .mcnTextContent p {
			color: #202020;
			font-family: Helvetica;
			font-size: 16px;
			line-height: 150%;
			text-align: left;
		}

		#templateColumns .columnContainer .mcnTextContent a, #templateColumns .columnContainer .mcnTextContent p a {
			color: #04689b;
			font-weight: normal;
			/* text-decoration:underline; */
		}

		#templateLowerBody {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			padding-top: 0;
			padding-bottom: 9px;
		}

		#templateLowerBody .mcnTextContent, #templateLowerBody .mcnTextContent p {
			color: #202020;
			font-family: Helvetica;
			font-size: 16px;
			line-height: 150%;
			text-align: left;
		}

		#templateLowerBody .mcnTextContent a, #templateLowperBody .mcnTextContent p a {
			color: #04689b;
			font-weight: normal;
		}

		#templateFooter {
			background-color: #ffffff;
			background-image: none;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			border-top: 0;
			border-bottom: 0;
			padding-top: 9px;
			padding-bottom: 9px;
		}

		#templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
			color: #656565;
			font-family: Helvetica;
			font-size: 12px;
			line-height: 150%;
			text-align: center;
		}

		#templateFooter .mcnTextContent a, #templateFooter .mcnTextContent p a {
			color: #04689b;
			font-weight: normal;
			text-decoration: underline;
		}

		@media only screen and (max-width: 600px) {
			.query {
				font-size: 20px !important;
			}
		}

		@media only screen and (min-width: 768px) {
			.templateContainer {
				width: 600px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			body, table, td, p, a, li, blockquote {
				-webkit-text-size-adjust: none !important;
			}

		}

		@media only screen and (max-width: 480px) {
			body {
				width: 100% !important;
				min-width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.columnWrapper {
				max-width: 100% !important;
				width: 100% !important;
				display: block;
			}

			.templateContainer {
				width: 100%;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnRetinaImage {
				max-width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImage {
				width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnCartContainer, .mcnCaptionTopContent, .mcnRecContentContainer, .mcnCaptionBottomContent, .mcnTextContentContainer, .mcnBoxedTextContentContainer, .mcnImageGroupContentContainer, .mcnCaptionLeftTextContentContainer, .mcnCaptionRightTextContentContainer, .mcnCaptionLeftImageContentContainer, .mcnCaptionRightImageContentContainer, .mcnImageCardLeftTextContentContainer, .mcnImageCardRightTextContentContainer, .mcnImageCardLeftImageContentContainer, .mcnImageCardRightImageContentContainer {
				max-width: 100% !important;
				width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnBoxedTextContentContainer {
				min-width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageGroupContent {
				padding: 9px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnCaptionLeftContentOuter .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
				padding-top: 9px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageCardTopImageContent, .mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent, .mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent {
				padding-top: 18px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageCardBottomImageContent {
				padding-bottom: 9px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageGroupBlockInner {
				padding-top: 0 !important;
				padding-bottom: 0 !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageGroupBlockOuter {
				padding-top: 9px !important;
				padding-bottom: 9px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnTextContent, .mcnBoxedTextContentColumn {
				padding-right: 18px !important;
				padding-left: 18px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcnImageCardLeftImageContent, .mcnImageCardRightImageContent {
				padding-right: 18px !important;
				padding-bottom: 0 !important;
				padding-left: 18px !important;
			}

		}

		@media only screen and (max-width: 480px) {
			.mcpreview-image-uploader {
				display: none !important;
				width: 100% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			h1 {
				font-size: 22px !important;
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			h2 {
				font-size: 20px !important;
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			h3 {
				font-size: 18px !important;
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			h4 {
				font-size: 16px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			.mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
				font-size: 14px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templatePreheader {
				display: block !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
				font-size: 14px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
				font-size: 16px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templateUpperBody .mcnTextContent, #templateUpperBody .mcnTextContent p {
				font-size: 16px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templateColumns .columnContainer .mcnTextContent, #templateColumns .columnContainer .mcnTextContent p {
				font-size: 16px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templateLowerBody .mcnTextContent, #templateLowerBody .mcnTextContent p {
				font-size: 16px !important;
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {

			#templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
				font-size: 14px !important;
				line-height: 150% !important;
			}
		}
	</style>
</head>
<body>
<span class="mcnPreviewText"
	  style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;"><?php echo $theme_preview_text ?></span>

<center>
	<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"
		   id="bodyTable">
		<tr>
			<td align="center" valign="top" id="bodyCell"><!-- BEGIN TEMPLATE // -->

				<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="center" valign="top" id="templatePreheader">

							<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
								   width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="preheaderContainer">
										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">


													<table role="presentation" align="left" border="0" cellpadding="0"
														   cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding: 0px 18px 9px; text-align: center;">
																<div style="text-align: left;">Kunt u deze nieuwsbrief
																	niet goed lezen?
																	<a href="{email_url}" style="color: #01689B">Bekijk
																		dan de online versie</a>
																</div>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateHeader">

							<!-- <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
 class="templateContainer">
    <tr>
        <td valign="top" class="headerContainer">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
            class="mcnImageBlock" style="min-width:100%;">
                <tbody class="mcnImageBlockOuter">
                    <tr>
                        <td valign="top" style="padding:0px" class="mcnImageBlockInner">
                            <table role="presentation" align="left" width="100%" border="0" cellpadding="0"
                            cellspacing="0" class="mcnImageContentContainer"
                            style="min-width:100%;">
                                <tbody>
                                    <tr>
                                        <td class="mcnImageContent" valign="top"
                                        style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                        <img align="center" alt="Logo Rijksoverheid" src="<?php /* echo $asseturl . 'digitaleoverheid-header-breed.png' */ ?>" width="51" style="max-width:100px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
 </table> -->

							<table role="presentation" width="578" align="center" role="presentation"
								   style="border-collapse:collapse;">
								<tbody>
								<tr>
									<td width="264"></td>
									<td width="314">
										<img align="center" alt="Logo Rijksoverheid"
											 src="<?php echo $asseturl . 'digitaleoverheid-header-breed.png' ?>"
											 width="314" height="125"
											 style="padding-bottom: 0px; vertical-align: bottom; border-radius: 0%; display: block !important;"
											 class="mcnImage">
									</td>
								</tr>
								</tbody>
							</table>

						</td>

					</tr>
					<tr>
						<td align="center" valign="top" id="templateUpperBody">
							<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
								   width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="bodyContainer">
										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<table role="presentation" width="94%" align="center"
														   role="presentation"
														   style="background-color: #007BC7;">
														<tbody>
														<tr>
															<td width="50%">
																<h1 class="query"
																	style="font-family: Helvetica; font-weight: 700; font-size: 24px; color: #fff; text-align: left; padding-left: 10px !important;">
																	<?php echo $theme_sitetitle ?>
																</h1>
															</td>
															<td width="50%">
																<p class="query"
																   style="font-family: Helvetica;font-weight: 400; font-size: 18px; color: #fff; text-align: right;  padding-right: 10px !important;">
																	<?php echo $theme_nieuwsbrieftitel_datetext ?>
																</p>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
										<?php
										if ( $uitgelicht ) {
											// START UITGELICHT ARTIKEL

											$uitgelicht_image_size = 'medium_large';
											$uitgelicht_title      = $uitgelicht->post_title;
											$uitgelicht_label      = mail_get_label( $uitgelicht->ID );
											$uitgelicht_date       = get_the_date( get_option( 'date_format' ), $uitgelicht->ID );
											$uitgelicht_excerpt    = rhswp_newsletter_get_excerpt( $uitgelicht->ID );
											$uitgelicht_url        = get_permalink( $uitgelicht->ID ) . $theme_piwiktrackercode;
											$image                 = wp_get_attachment_image_src( get_post_thumbnail_id( $uitgelicht->ID ), $uitgelicht_image_size );
											if ( $image ) {
												$alt   = 'Lees ' . $uitgelicht_title;
												$image = '<tr><td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;"><a href="' . $uitgelicht_url . '" role="presentation" tabindex="-1"><img alt="' . $alt . '" src="' . $image[0] . '" width="564" style="max-width:768px;" class="mcnImage"></a></td></tr>';

											}

											?>

											<table role="presentation" border="0" cellpadding="0" cellspacing="0"
												   width="100%"
												   class="mcnCaptionBlock">
												<tbody class="mcnCaptionBlockOuter">
												<tr>
													<td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
														<table role="presentation" align="left" border="0"
															   cellpadding="0" cellspacing="0"
															   class="mcnCaptionBottomContent">
															<tbody>
															<?php echo $image ?>
															<tr>
																<td class="mcnTextContent" valign="top"
																	style="padding:0 9px 0 9px;" width="564"><p
																		class="null"><span
																			style="font-size:14px"><span
																				style="color: #696969;font-weight: 600;"><?php echo $uitgelicht_label ?></span></span>
																	</p>
																	<h2 class="null"><a
																			href="<?php echo $uitgelicht_url ?>"><strong>
																				<span
																					style="color:#01689B; font-size:24px; line-height:32px;"><?php echo $uitgelicht_title ?></span></strong></a>
																	</h2>
																	<p style="color:#000; font-size: 18px; font-weight: bold; margin: 10px 0"><?php echo $uitgelicht_date ?></p>
																	<p style="color:#000; font-size: 18px"><?php echo $uitgelicht_excerpt ?></p>
																</td>
															</tr>
															</tbody>
														</table>
													</td>
												</tr>
												</tbody>
											</table>


											<?php
											// EIND UITGELICHT ARTIKEL
										}
										?>


										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnDividerBlock" style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:9px;">
													<table role="presentation" class="mcnDividerContent" border="0"
														   cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td><span></span></td>
														</tr>
														</tbody>
													</table>
												</td>
											</tr>
											</tbody>
										</table>
										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table role="presentation" align="left" border="0" cellspacing="0"
														   cellpadding="0"
														   width="100%" style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->

													<table role="presentation" align="left" border="0" cellpadding="0"
														   cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
																<h2><strong><span
																			style="font-family:arial,helvetica neue,helvetica,sans-serif; font-size:32px"><?php echo $theme_titel_nieuws ?></span></strong>
																</h2>
															</td>
														</tr>
														</tbody>
													</table>

													<!--[if mso]>
													</td>
													<![endif]-->

													<!--[if mso]>
													</tr>
													</table>
													<![endif]--></td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateColumns">
							<table role="presentation" border="0" cellpadding="0" cellspacing="0"
								   class="templateContainer">
								<tr width="100%">
									<td valign="top" align="left" class="columnWrapper">

										<!-- START LINKERKOLOM -->

										<table role="presentation" align="center" border="0" cellpadding="0"
											   cellspacing="0" width="100%">
											<tr>
												<td valign="top" class="columnContainer">
													<?php
													$postcounter = 0;

													foreach ( $posts as $post ) {
														setup_postdata( $post );
														$postcounter ++;
														if ( $postcounter > $linkeraantal ) {
															break;
														} else {
															echo write_bericht( $post, $theme_options );
														}
													}


													?>
												</td>
											</tr>
										</table>
									</td>

									<!-- EIND LINKERKOLOM -->


									<!-- START RECHTERKOLOM -->
									<td valign="top" align="left" class="columnWrapper">
										<table role="presentation" align="cenetr" border="0" cellpadding="0"
											   cellspacing="0" width="100%">
											<tr>
												<td valign="top" class="columnContainer">
													<?php

													$postcounter = 0;

													foreach ( $posts as $post ) {
														setup_postdata( $post );
														$postcounter ++;
														if ( $postcounter <= $linkeraantal ) {
// break;
														} else {
															echo write_bericht( $post, $theme_options );
														}
													}


													?>


												</td>
											</tr>
										</table>

									</td>
									<!-- EIND RECHTERKOLOM -->


								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateLowerBody">

							<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
								   width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="bodyContainer">
										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnDividerBlock" style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
													<table role="presentation" class="mcnDividerContent" border="0"
														   cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td><span></span></td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>

										<?php

										$linker_events  = '';
										$rechter_events = '';
										$args_selection = array(
											'scope'      => 'future',
											// alleen toekomstige events tonen
											'pagination' => '0',
											// nee, we willen geen pagination
											'limit'      => $filters['theme_max_agenda'],
											// het aantal events per pagina
										);
										$EM_Events      = EM_Events::get( $args_selection );

										if ( $EM_Events ) {

											// er zijn events...
											$counter       = count( $EM_Events );
											$linkeraantal  = round( ( $counter / 2 ), 0 );
											$rechteraantal = ( $counter - $linkeraantal );
											$postcounter   = 0;

											foreach ( $EM_Events as $EM_Event ) {
												setup_postdata( $EM_Event );
												$postcounter ++;
												if ( $postcounter <= $linkeraantal ) {
													$linker_events .= maak_event( $EM_Event, $asseturl, $theme_options );
												} else {
													$rechter_events .= maak_event( $EM_Event, $asseturl, $theme_options );
												}
											}
										}


										?>


										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

													<table role="presentation" align="left" border="0" cellpadding="0"
														   cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
																<h2><strong><span
																			style="font-family:arial,helvetica neue,helvetica,sans-serif; font-size:32px"><?php echo $theme_titel_events ?></span></strong>
																</h2>
															</td>
														</tr>
														</tbody>
													</table>
												</td>
											</tr>
											</tbody>
										</table>


										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   class="templateContainer">
											<tbody class="mcnTextBlockOuter">
											<tr width="100%">
												<td class="columnWrapper" valign="top" width="50%">
													<table role="presentation" align="center" border="0" cellpadding="0"
														   cellspacing="0"
														   width="100%">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
																<?php
																echo $linker_events;
																?>
															</td>
														</tr>
														</tbody>
													</table>
												</td>
												<td class="columnWrapper" valign="top" width="50%">
													<table role="presentation" align="center" border="0" cellpadding="0"
														   cellspacing="0"
														   width="100%">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
																<?php
																echo $rechter_events;
																?>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>


										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnDividerBlock" style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
													<table role="presentation" class="mcnDividerContent" border="0"
														   cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td><span></span></td>
														</tr>
														</tbody>
													</table>

													<!--
													<td class="mcnDividerBlockInner" style="padding: 18px;">
													<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
													--></td>
											</tr>
											</tbody>
										</table>


										<?php
										// als er socials zijn
										if ( ( $theme_socials_twitter_url && $theme_socials_twitter_linktext ) || ( $theme_socials_linkedin_url && $theme_socials_linkedin_linktext ) ) {
											// START als er socials zijn
											?>


											<table role="presentation" border="0" cellpadding="0" cellspacing="0"
												   width="100%"
												   class="mcnTextBlock" style="min-width:100%;">
												<tbody class="mcnTextBlockOuter">
												<tr>
													<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">


														<table role="presentation" align="left" border="0"
															   cellpadding="0" cellspacing="0"
															   style="max-width:100%; min-width:100%;" width="100%"
															   class="mcnTextContentContainer">
															<tbody>
															<tr>
																<td valign="top" class="mcnTextContent"
																	style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
																	<strong><span
																			style="font-family:arial,helvetica neue,helvetica,sans-serif"><span
																				style="font-size:32px"><?php echo $theme_titel_socials ?></span></span></strong>


																</td>
															</tr>
															</tbody>
														</table>

													</td>
												</tr>
												</tbody>
											</table>
											<table role="presentation" border="0" cellpadding="0" cellspacing="0"
												   width="100%"
												   class="mcnTextBlock" style="min-width:100%;">
												<tbody class="mcnTextBlockOuter">
												<tr>
													<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

														<table role="presentation" align="left" border="0"
															   cellpadding="0" cellspacing="0"
															   style="max-width:100%; min-width:100%;" width="100%"
															   class="mcnTextContentContainer">
															<tbody>
															<tr>
																<td valign="top" class="mcnTextContent"
																	style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																	<?php
																	if ( $theme_socials_twitter_url && $theme_socials_twitter_linktext ) {

																		echo '<span style="color:#01689B"><img alt="twitter-logo" height="16" src="' . $asseturl . 'icon_twitter.jpeg" alt="" style="border: 0px; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<a href="' . $theme_socials_twitter_url . '" style="color:#01689B">' . $theme_socials_twitter_linktext . '</a><br>';

																	}
																	if ( $theme_socials_linkedin_url && $theme_socials_linkedin_linktext ) {

																		echo '<span style="color:#01689B"><img alt="linkedin-logo" height="16" src="' . $asseturl . 'icon_linkedin.jpeg" alt="" style="border: 0px; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<a href="' . $theme_socials_linkedin_url . '" style="color:#01689B">' . $theme_socials_linkedin_linktext . '</a><br>';

																	}

																	?>
																</td>
															</tr>
															</tbody>
														</table>

													</td>
												</tr>
												</tbody>
											</table>

											<?php
											// EIND als er socials zijn

										}
										?>

										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">


													<table role="presentation" align="left" border="0" cellpadding="0"
														   cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
																<div
																	style="background-color: #007BC7; padding: 19px 30px">
																	<p style="font-weight: 700; font-size: 26px; color: #fff; text-align: left;">
																		<?php echo $theme_sitetitle ?></p>
																	<p style="font-weight: 400; font-size: 24px; color: #fff; font-style: italic;text-align: left">
																		<?php echo $theme_sitepayoff ?></p>
																</div>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateFooter">

							<table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
								   width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="footerContainer">
										<table role="presentation" border="0" cellpadding="0" cellspacing="0"
											   width="100%"
											   class="mcnTextBlock" style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

													<table role="presentation" align="left" border="0" cellpadding="0"
														   cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
																<div style="text-align: left;">
																	<span
																		style="color:#000000"><?php echo $colofon_blok1 ?></span><br>
																	<span
																		style="color:#000000"><?php echo $colofon_blok2 ?></span><br>
																</div>
																<div style="text-align: left;"><br>
																	<span
																		style="color:#000000"><?php echo $theme_mail_unsubscribe_text ?></span>
																	<a href="{unsubscription_url}"
																	   style="color: #01689B" target="_blank"><span
																			style="color:#01689B"><?php echo $theme_mail_unsubscribe_linktext ?></span></a><span
																		style="color:#01689B">.</span>
																</div>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>

				<!-- // END TEMPLATE --></td>
		</tr>
	</table>
</center>
</body>

</html>
