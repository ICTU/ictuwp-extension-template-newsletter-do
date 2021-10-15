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
	$filters['posts_per_page'] = (int) $theme_options['theme_max_posts'];
}
if ( $filters['posts_per_page'] == 0 ) {
	$filters['posts_per_page'] = 5;
}

if ( ! empty( $theme_options['theme_tags'] ) ) {
	$filters['tag'] = $theme_options['theme_tags'];
}


// Maximum number of events to retrieve
$filters['theme_max_agenda'] = 5;
if ( isset( $theme_options['theme_max_agenda'] ) ) {
	$filters['theme_max_agenda'] = (int) $theme_options['theme_max_agenda'];
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

// Styles
$color = isset( $theme_options['theme_color'] ) ? $theme_options['theme_color'] : '#777';
if ( empty( $color ) ) {
	$color = '#777';
}

$font      = isset( $theme_options['theme_font'] ) ? $theme_options['theme_font'] : '';
$font_size = isset( $theme_options['theme_font_size'] ) ? $theme_options['theme_font_size'] : '';


$theme_nieuwsbrieftitel   = isset( $theme_options['theme_nieuwsbrieftitel'] ) ? $theme_options['theme_nieuwsbrieftitel'] : 'Digitale Overheid - {date}';
$colofon_blok1            = isset( $theme_options['theme_colofon_block_1'] ) ? $theme_options['theme_colofon_block_1'] : 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.';
$colofon_blok2            = isset( $theme_options['theme_colofon_block_2'] ) ? $theme_options['theme_colofon_block_2'] : 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>';
$colofon_blok3            = isset( $theme_options['theme_colofon_block_3'] ) ? $theme_options['theme_colofon_block_3'] : 'Digitale Overheid is ook te volgen op Twitter: <a href="https://twitter.com/digioverheid">@digioverheid</a>';
$theme_show_featuredimage = isset( $theme_options['theme_show_featuredimage'] ) ? $theme_options['theme_show_featuredimage'] : '';
$theme_piwiktrackercode   = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';


/**
 * Accepts a post or a post ID.
 *
 * @param WP_Post $post
 */
function rhswp_newsletter_the_excerpt( $post, $words = 80 ) {
	$post    = get_post( $post );
	$excerpt = $post->post_excerpt;
	if ( empty( $excerpt ) ) {
		$excerpt = $post->post_content;
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = wp_strip_all_tags( $excerpt, true );
	}
	echo wp_trim_words( $excerpt, $words );
}


?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
	  xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!-- NAME: 1:2:1 COLUMN - FULL WIDTH -->
	<!--[if gte mso 15]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>*|MC:SUBJECT|*</title>

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

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}

		.templateContainer {
			max-width: 600px !important;
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

		/*
		@tab Page
		@section Background Style
		@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
		*/
		body, #bodyTable {
			/*@editable*/
			background-color: #FAFAFA;
		}

		/*
		@tab Page
		@section Background Style
		@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
		*/
		#bodyCell {
			/*@editable*/
			border-top: 0;
		}

		/*
		@tab Page
		@section Heading 1
		@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
		@style heading 1
		*/
		h1 {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 26px;
			/*@editable*/
			font-style: normal;
			/*@editable*/
			font-weight: bold;
			/*@editable*/
			line-height: 125%;
			/*@editable*/
			letter-spacing: normal;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Page
		@section Heading 2
		@tip Set the styling for all second-level headings in your emails.
		@style heading 2
		*/
		h2 {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 22px;
			/*@editable*/
			font-style: normal;
			/*@editable*/
			font-weight: bold;
			/*@editable*/
			line-height: 125%;
			/*@editable*/
			letter-spacing: normal;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Page
		@section Heading 3
		@tip Set the styling for all third-level headings in your emails.
		@style heading 3
		*/
		h3 {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 20px;
			/*@editable*/
			font-style: normal;
			/*@editable*/
			font-weight: bold;
			/*@editable*/
			line-height: 125%;
			/*@editable*/
			letter-spacing: normal;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Page
		@section Heading 4
		@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
		@style heading 4
		*/
		h4 {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 18px;
			/*@editable*/
			font-style: normal;
			/*@editable*/
			font-weight: bold;
			/*@editable*/
			line-height: 125%;
			/*@editable*/
			letter-spacing: normal;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Preheader
		@section Preheader Style
		@tip Set the background color and borders for your email's preheader area.
		*/
		#templatePreheader {
			/*@editable*/
			background-color: #FAFAFA;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 0;
			/*@editable*/
			padding-top: 9px;
			/*@editable*/
			padding-bottom: 9px;
		}

		/*
		@tab Preheader
		@section Preheader Text
		@tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
		*/
		#templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
			/*@editable*/
			color: #656565;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 12px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Preheader
		@section Preheader Link
		@tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
		*/
		#templatePreheader .mcnTextContent a, #templatePreheader .mcnTextContent p a {
			/*@editable*/
			color: #656565;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
		}

		/*
		@tab Header
		@section Header Style
		@tip Set the background color and borders for your email's header area.
		*/
		#templateHeader {
			/*@editable*/
			background-color: #ffffff;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 0;
			/*@editable*/
			padding-top: 0px;
			/*@editable*/
			padding-bottom: 25px;
		}

		/*
		@tab Header
		@section Header Text
		@tip Set the styling for your email's header text. Choose a size and color that is easy to read.
		*/
		#templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 16px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: center;
		}

		/*
		@tab Header
		@section Header Link
		@tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
		*/
		#templateHeader .mcnTextContent a, #templateHeader .mcnTextContent p a {
			/*@editable*/
			color: #007C89;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
		}

		/*
		@tab Upper Body
		@section Upper Body Style
		@tip Set the background color and borders for your email's upper body area.
		*/
		#templateUpperBody {
			/*@editable*/
			background-color: #FFFFFF;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 0;
			/*@editable*/
			padding-top: 0;
			/*@editable*/
			padding-bottom: 0;
		}

		/*
		@tab Upper Body
		@section Upper Body Text
		@tip Set the styling for your email's upper body text. Choose a size and color that is easy to read.
		*/
		#templateUpperBody .mcnTextContent, #templateUpperBody .mcnTextContent p {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 16px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Upper Body
		@section Upper Body Link
		@tip Set the styling for your email's upper body links. Choose a color that helps them stand out from your text.
		*/
		#templateUpperBody .mcnTextContent a, #templateUpperBody .mcnTextContent p a {
			/*@editable*/
			color: #007C89;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
		}

		/*
		@tab Columns
		@section Column Style
		@tip Set the background color and borders for your email's columns.
		*/
		#templateColumns {
			/*@editable*/
			background-color: #ffffff;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 0;
			/*@editable*/
			padding-top: 0;
			/*@editable*/
			padding-bottom: 16px;
		}

		/*
		@tab Columns
		@section Column Text
		@tip Set the styling for your email's column text. Choose a size and color that is easy to read.
		*/
		#templateColumns .columnContainer .mcnTextContent, #templateColumns .columnContainer .mcnTextContent p {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 16px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Columns
		@section Column Link
		@tip Set the styling for your email's column links. Choose a color that helps them stand out from your text.
		*/
		#templateColumns .columnContainer .mcnTextContent a, #templateColumns .columnContainer .mcnTextContent p a {
			/*@editable*/
			color: #007C89;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
		}

		/*
		@tab Lower Body
		@section Lower Body Style
		@tip Set the background color and borders for your email's lower body area.
		*/
		#templateLowerBody {
			/*@editable*/
			background-color: #FFFFFF;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 2px solid #EAEAEA;
			/*@editable*/
			padding-top: 0;
			/*@editable*/
			padding-bottom: 9px;
		}

		/*
		@tab Lower Body
		@section Lower Body Text
		@tip Set the styling for your email's lower body text. Choose a size and color that is easy to read.
		*/
		#templateLowerBody .mcnTextContent, #templateLowerBody .mcnTextContent p {
			/*@editable*/
			color: #202020;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 16px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: left;
		}

		/*
		@tab Lower Body
		@section Lower Body Link
		@tip Set the styling for your email's lower body links. Choose a color that helps them stand out from your text.
		*/
		#templateLowerBody .mcnTextContent a, #templateLowperBody .mcnTextContent p a {
			/*@editable*/
			color: #007C89;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
		}

		/*
		@tab Footer
		@section Footer Style
		@tip Set the background color and borders for your email's footer area.
		*/
		#templateFooter {
			/*@editable*/
			background-color: #ffffff;
			/*@editable*/
			background-image: none;
			/*@editable*/
			background-repeat: no-repeat;
			/*@editable*/
			background-position: center;
			/*@editable*/
			background-size: cover;
			/*@editable*/
			border-top: 0;
			/*@editable*/
			border-bottom: 0;
			/*@editable*/
			padding-top: 9px;
			/*@editable*/
			padding-bottom: 9px;
		}

		/*
		@tab Footer
		@section Footer Text
		@tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
		*/
		#templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
			/*@editable*/
			color: #656565;
			/*@editable*/
			font-family: Helvetica;
			/*@editable*/
			font-size: 12px;
			/*@editable*/
			line-height: 150%;
			/*@editable*/
			text-align: center;
		}

		/*
		@tab Footer
		@section Footer Link
		@tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
		*/
		#templateFooter .mcnTextContent a, #templateFooter .mcnTextContent p a {
			/*@editable*/
			color: #656565;
			/*@editable*/
			font-weight: normal;
			/*@editable*/
			text-decoration: underline;
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
			/*
			@tab Mobile Styles
			@section Heading 1
			@tip Make the first-level headings larger in size for better readability on small screens.
			*/
			h1 {
				/*@editable*/
				font-size: 22px !important;
				/*@editable*/
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Heading 2
			@tip Make the second-level headings larger in size for better readability on small screens.
			*/
			h2 {
				/*@editable*/
				font-size: 20px !important;
				/*@editable*/
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Heading 3
			@tip Make the third-level headings larger in size for better readability on small screens.
			*/
			h3 {
				/*@editable*/
				font-size: 18px !important;
				/*@editable*/
				line-height: 125% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Heading 4
			@tip Make the fourth-level headings larger in size for better readability on small screens.
			*/
			h4 {
				/*@editable*/
				font-size: 16px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Boxed Text
			@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
			.mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
				/*@editable*/
				font-size: 14px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Preheader Visibility
			@tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
			*/
			#templatePreheader {
				/*@editable*/
				display: block !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Preheader Text
			@tip Make the preheader text larger in size for better readability on small screens.
			*/
			#templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
				/*@editable*/
				font-size: 14px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Header Text
			@tip Make the header text larger in size for better readability on small screens.
			*/
			#templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
				/*@editable*/
				font-size: 16px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Upper Body Text
			@tip Make the upper body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
			#templateUpperBody .mcnTextContent, #templateUpperBody .mcnTextContent p {
				/*@editable*/
				font-size: 16px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Column Text
			@tip Make the column text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
			#templateColumns .columnContainer .mcnTextContent, #templateColumns .columnContainer .mcnTextContent p {
				/*@editable*/
				font-size: 16px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Lower Body Text
			@tip Make the lower body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
			#templateLowerBody .mcnTextContent, #templateLowerBody .mcnTextContent p {
				/*@editable*/
				font-size: 16px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}

		@media only screen and (max-width: 480px) {
			/*
			@tab Mobile Styles
			@section Footer Text
			@tip Make the footer content text larger in size for better readability on small screens.
			*/
			#templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
				/*@editable*/
				font-size: 14px !important;
				/*@editable*/
				line-height: 150% !important;
			}

		}</style>
	<script>var w = window;
		if (w.performance || w.mozPerformance || w.msPerformance || w.webkitPerformance) {
			var d = document;
			AKSB = w.AKSB || {}, AKSB.q = AKSB.q || [], AKSB.mark = AKSB.mark || function (e, _) {
				AKSB.q.push(["mark", e, _ || (new Date).getTime()])
			}, AKSB.measure = AKSB.measure || function (e, _, t) {
				AKSB.q.push(["measure", e, _, t || (new Date).getTime()])
			}, AKSB.done = AKSB.done || function (e) {
				AKSB.q.push(["done", e])
			}, AKSB.mark("firstbyte", (new Date).getTime()), AKSB.prof = {
				custid: "90616",
				ustr: "",
				originlat: "0",
				clientrtt: "23",
				ghostip: "92.123.225.218",
				ipv6: false,
				pct: "10",
				clientip: "213.125.22.122",
				requestid: "d6447ac0",
				region: "25168",
				protocol: "h2",
				blver: 14,
				akM: "x",
				akN: "ae",
				akTT: "O",
				akTX: "1",
				akTI: "d6447ac0",
				ai: "199322",
				ra: "false",
				pmgn: "",
				pmgi: "",
				pmp: "",
				qc: ""
			}, function (e) {
				var _ = d.createElement("script");
				_.async = "async", _.src = e;
				var t = d.getElementsByTagName("script"), t = t[t.length - 1];
				t.parentNode.insertBefore(_, t)
			}(("https:" === d.location.protocol ? "https:" : "http:") + "//ds-aksb-a.akamaihd.net/aksb.min.js")
		}</script>
</head>
<body>
<!--*|IF:MC_PREVIEW_TEXT|*-->
<!--[if !gte mso 9]><!----><span class="mcnPreviewText"
								 style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">*|MC_PREVIEW_TEXT|*</span>
<!--<![endif]-->
<!--*|END:IF|*-->
<center>
	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
		<tr>
			<td align="center" valign="top" id="bodyCell">
				<!-- BEGIN TEMPLATE // -->
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="center" valign="top" id="templatePreheader">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
								   style="width:600px;">
								<tr>
									<td align="center" valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="preheaderContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding: 0px 18px 9px; text-align: center;">

																<div style="text-align: left;">Wordt de nieuwsbrief niet
																	goed weergegeven? <a
																		style="color: #01689B">Bekijk in je browser</a>
																</div>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateHeader">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
								   style="width:600px;">
								<tr>
									<td align="center" valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="headerContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnImageBlock"
											   style="min-width:100%;">
											<tbody class="mcnImageBlockOuter">
											<tr>
												<td valign="top" style="padding:0px" class="mcnImageBlockInner">
													<table align="left" width="100%" border="0" cellpadding="0"
														   cellspacing="0"
														   class="mcnImageContentContainer" style="min-width:100%;">
														<tbody>
														<tr>
															<td class="mcnImageContent" valign="top"
																style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">


																<img align="center" alt=""
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/73382f6f-c38d-6c1d-5865-4808fad65e89.png"
																	 width="51"
																	 style="max-width:100px; padding-bottom: 0; display: inline !important; vertical-align: bottom;"
																	 class="mcnImage">


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
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateUpperBody">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
								   style="width:600px;">
								<tr>
									<td align="center" valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="bodyContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<div
																	style="display:flex; width: 100%; align-items: center; justify-content: space-between; background-color:#007BC7;">
																	<p
																		style="font-weight: 700; font-size: 24px; color: #fff; margin-left: 30px; padding:19px 0px">
																		Digitale Overheid</p>

																	<p
																		style="font-weight: 400; font-size: 18px; color: #fff; margin-right: 30px; padding:19px 0px">
																		Nieuwsbrief 30 april 2021</p>
																</div>

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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnCaptionBlock">
											<tbody class="mcnCaptionBlockOuter">
											<tr>
												<td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">


													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   class="mcnCaptionBottomContent">
														<tbody>
														<tr>
															<td class="mcnCaptionBottomImageContent" align="center"
																valign="top"
																style="padding:0 9px 9px 9px;">


																<img alt=""
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/3dacf59d-9b51-2ab4-82f7-394b15204c60.jpg"
																	 width="564" style="max-width:768px;"
																	 class="mcnImage">


															</td>
														</tr>
														<tr>
															<td class="mcnTextContent" valign="top"
																style="padding:0 9px 0 9px;" width="564">
																<p class="null"><span style="font-size:14px"><span
																			style="color: #696969;font-weight: 600;">DIGITAAL TOEGANKELIJK</span></span>
																</p>

																<h1 class="null"><strong><span
																			style="color:#01689B; font-size:32px; line-height:48px">Rathenau: actievere overheid nodig tegen onwenselijk online gedrag</span></strong>
																</h1>

																<p style="color:#000; font-size: 18px; font-weight: bold; margin: 10px 0">
																	16 augustus
																	2020</p>

																<p style="color:#000; font-size: 18px">Advies aan de
																	overheid is pro-actiever in te
																	grijpen en een maatschappelijke dialoog te
																	starten.</p>

															</td>
														</tr>
														</tbody>
													</table>


												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnDividerBlock"
											   style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
													<table class="mcnDividerContent" border="0" cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td>
																<span></span>
															</td>
														</tr>
														</tbody>
													</table>
													<!--
																	<td class="mcnDividerBlockInner" style="padding: 18px;">
																	<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
													-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<strong><span
																		style="font-family:arial,helvetica neue,helvetica,sans-serif"><span
																			style="font-size:32px">Laatste nieuws</span></span></strong>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateColumns">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
								<tr>
									<td valign="top">
										<!--[if (gte mso 9)|(IE)]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
											   style="width:600px;">
											<tr>
												<td align="center" valign="top" width="300" style="width:300px;">
										<![endif]-->
										<table align="left" border="0" cellpadding="0" cellspacing="0" width="300"
											   class="columnWrapper">
											<tr>
												<td valign="top" class="columnContainer">
													<table border="0" cellpadding="0" cellspacing="0" width="100%"
														   class="mcnCaptionBlock">
														<tbody class="mcnCaptionBlockOuter">
														<tr>
															<td class="mcnCaptionBlockInner" valign="top"
																style="padding:9px;">

																DIT IS EEN BERICHT START
																<table align="left" border="0" cellpadding="0"
																	   cellspacing="0"
																	   class="mcnCaptionBottomContent">
																	<tbody>
																	<tr>
																		<td class="mcnCaptionBottomImageContent"
																			align="center" valign="top"
																			style="padding:0 9px 9px 9px;">


																			<img alt=""
																				 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/8b32e4ad-cedd-1cba-dabd-675180dd48de.jpg"
																				 width="264" style="max-width:368px;"
																				 class="mcnImage">


																		</td>
																	</tr>
																	<tr>
																		<td class="mcnTextContent" valign="top"
																			style="padding:0 9px 0 9px;" width="264">

																			<p style="font-size:14px"><strong><span
																						style="color:#696969; text-transform:uppercase">Artificiële Intelligentie (AI)</span></strong>
																			</p>

																			<h2 class="null"><span
																					style="color:#01689B"><strong><span
																							style="font-size:24px; margin: 12px 0px; line-height:36px">E-magazine: AI als instrument voor gemeenten</span></strong></span>
																			</h2>

																			<p style="font-size:18px"><strong>24
																					september 2020</strong></p>
																			<p>In 20 artikelen geeft dit digitale
																				magazine een actueel beeld van de
																				mogelijkheden, toepassingen en risico’s
																				van AI (Artificial Intelligence) door
																				gemeenten.</p>

																		</td>
																	</tr>
																	</tbody>
																</table>
																DIT IS EEN BERICHT EINDE


															</td>
														</tr>
														</tbody>
													</table>
													<table border="0" cellpadding="0" cellspacing="0" width="100%"
														   class="mcnCaptionBlock">
														<tbody class="mcnCaptionBlockOuter">
														<tr>
															<td class="mcnCaptionBlockInner" valign="top"
																style="padding:9px;">


																WEG!

															</td>
														</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</table>
										<!--[if (gte mso 9)|(IE)]>
										</td>
										<td align="center" valign="top" width="300" style="width:300px;">
										<![endif]-->
										<table align="left" border="0" cellpadding="0" cellspacing="0" width="300"
											   class="columnWrapper">
											<tr>
												<td valign="top" class="columnContainer">
													<table border="0" cellpadding="0" cellspacing="0" width="100%"
														   class="mcnCaptionBlock">
														<tbody class="mcnCaptionBlockOuter">
														<tr>
															<td class="mcnCaptionBlockInner" valign="top"
																style="padding:9px;">


																<table align="left" border="0" cellpadding="0"
																	   cellspacing="0"
																	   class="mcnCaptionBottomContent">
																	<tbody>
																	<tr>
																		<td class="mcnCaptionBottomImageContent"
																			align="center" valign="top"
																			style="padding:0 9px 9px 9px;">


																			<img alt=""
																				 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/22b98681-80c2-fb34-fd99-c26cbd07c032.jpg"
																				 width="264" style="max-width:368px;"
																				 class="mcnImage">


																		</td>
																	</tr>
																	<tr>
																		<td class="mcnTextContent" valign="top"
																			style="padding:0 9px 0 9px;" width="264">
																			<p style="font-size:14px"><strong><span
																						style="color:#696969; text-transform:uppercase">Digitaal toegankelijk</span></strong>
																			</p>

																			<h2 class="null"><span
																					style="color:#01689B"><u><strong><span
																								style="font-size:24px; line-height:36px">Digitale toegankelijkheid gaat de hele organisatie aan</span></strong></u></span>
																			</h2>
																			<p style="font-size:18px"><strong>23
																					september 2020</strong></p>
																			<p>1 op de 5 Nederlanders heeft moeite om de
																				digitale informatie en diensten van
																				de overheid te gebruiken. Daarom is het
																				heel belangrijk dat overheidswebsites
																				voor iedereen toegankelijk zijn.</p>
																		</td>
																	</tr>
																	</tbody>
																</table>


															</td>
														</tr>
														</tbody>
													</table>
													<table border="0" cellpadding="0" cellspacing="0" width="100%"
														   class="mcnCaptionBlock">
														<tbody class="mcnCaptionBlockOuter">
														<tr>
															<td class="mcnCaptionBlockInner" valign="top"
																style="padding:9px;">


																<table align="left" border="0" cellpadding="0"
																	   cellspacing="0"
																	   class="mcnCaptionBottomContent">
																	<tbody>
																	<tr>
																		<td class="mcnCaptionBottomImageContent"
																			align="center" valign="top"
																			style="padding:0 9px 9px 9px;">


																			<img alt=""
																				 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/8b32e4ad-cedd-1cba-dabd-675180dd48de.jpg"
																				 width="264" style="max-width:368px;"
																				 class="mcnImage">


																		</td>
																	</tr>
																	<tr>
																		<td class="mcnTextContent" valign="top"
																			style="padding:0 9px 0 9px;" width="264">
																			<p style="font-size:14px"><strong><span
																						style="color:#696969; text-transform:uppercase">Artificiële Intelligentie (AI)</span></strong>
																			</p>

																			<h2 class="null"><span
																					style="color:#01689B"><strong><span
																							style="font-size:24px; line-height:36px">E-magazine: AI als instrument voor gemeenten</span></strong></span>
																			</h2>
																			<p style="font-size:18px"><strong>24
																					september 2020</strong></p>
																			<p>In 20 artikelen geeft dit digitale
																				magazine een actueel beeld van de
																				mogelijkheden, toepassingen en risico’s
																				van AI (Artificial Intelligence) door
																				gemeenten.</p>
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
										<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateLowerBody">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
								   style="width:600px;">
								<tr>
									<td align="center" valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="bodyContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnDividerBlock"
											   style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
													<table class="mcnDividerContent" border="0" cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td>
																<span></span>
															</td>
														</tr>
														</tbody>
													</table>
													<!--
																	<td class="mcnDividerBlockInner" style="padding: 18px;">
																	<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
													-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<strong><span
																		style="font-family:arial,helvetica neue,helvetica,sans-serif"><span
																			style="font-size:32px">Evenementen</span></span></strong>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="300" style="width:300px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:300px;"
														   width="100%" class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">

																<strong><span
																		style="font-size:24px; line-height:36px"><span
																			style="color:#01689B">Cybersecurity for Artificial Intelligence</span></span></strong><br>
																<br>
																<img data-file-id="5453529" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/d26493ec-97ba-e9cd-2c79-8aed068c2bb4.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;Dinsdag 30 september 2020<br>
																<img data-file-id="5453533" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/5033e04f-5446-ec02-1b76-294c78036f8f.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;17:00–19:00<br>
																<br>
																<strong><span
																		style="font-size:24px; line-height:36px"><span
																			style="color:#01689B">Cybersecurity for Artificial Intelligence</span></span></strong><br>
																<br>
																<img data-file-id="5453529" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/d26493ec-97ba-e9cd-2c79-8aed068c2bb4.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;Dinsdag 30 september 2020<br>
																<img data-file-id="5453533" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/5033e04f-5446-ec02-1b76-294c78036f8f.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;17:00–19:00
															</td>
														</tr>
														</tbody>
													</table>
													<!--[if mso]>
													</td>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="300" style="width:300px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:300px;"
														   width="100%" class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">

																<strong><span
																		style="font-size:24px; line-height:36px"><span
																			style="color:#01689B">Overheidsbrede Cyberwebinars</span></span></strong><br>
																<br>
																<img data-file-id="5453529" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/d26493ec-97ba-e9cd-2c79-8aed068c2bb4.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;Dinsdag 30 september 2020<br>
																<img data-file-id="5453533" height="12"
																	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/5033e04f-5446-ec02-1b76-294c78036f8f.png"
																	 style="border: 0px  ; width: 12px; height: 12px; margin: 0px;"
																	 width="12">&nbsp;
																&nbsp;17:00–19:00
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnDividerBlock"
											   style="min-width:100%;">
											<tbody class="mcnDividerBlockOuter">
											<tr>
												<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
													<table class="mcnDividerContent" border="0" cellpadding="0"
														   cellspacing="0" width="100%"
														   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
														<tbody>
														<tr>
															<td>
																<span></span>
															</td>
														</tr>
														</tbody>
													</table>
													<!--
																	<td class="mcnDividerBlockInner" style="padding: 18px;">
																	<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
													-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<strong><span
																		style="font-family:arial,helvetica neue,helvetica,sans-serif"><span
																			style="font-size:32px">Volg ons via</span></span></strong>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                            <span style="color:#01689B"><img data-file-id="5453537" height="16"
															 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/1f96e75c-c6c3-9460-8d3b-25231c4f859c.png"
															 style="border: 0px  ; width: 16px; height: 16px; margin: 0px;"
															 width="16">&nbsp; &nbsp;<u>Twitter</u><br>
<img data-file-id="5453541" height="16"
	 src="https://mcusercontent.com/3e910dcf189c820fdd63ae55d/images/e90ba490-fd35-3401-744f-3f025ab5aee3.png"
	 style="border: 0px  ; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<u>LinkedIn</u></span>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<div
																	style="background-color: #007BC7; padding: 19px 30px">
																	<h3 style="font-weight: 700; font-size: 26px; color: #fff; text-align: left;">
																		Digitale
																		Overheid</h3>

																	<p
																		style="font-weight: 400; font-size: 24px; color: #fff; font-style: italic;text-align: left">
																		Voor professionals die werken aan digitalisering
																		van de overheid</p>
																</div>
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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" id="templateFooter">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="600"
								   style="width:600px;">
								<tr>
									<td align="center" valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
								   class="templateContainer">
								<tr>
									<td valign="top" class="footerContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
											   class="mcnTextBlock"
											   style="min-width:100%;">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
													<!--[if mso]>
													<table align="left" border="0" cellspacing="0" cellpadding="0"
														   width="100%"
														   style="width:100%;">
														<tr>
													<![endif]-->

													<!--[if mso]>
													<td valign="top" width="600" style="width:600px;">
													<![endif]-->
													<table align="left" border="0" cellpadding="0" cellspacing="0"
														   style="max-width:100%; min-width:100%;" width="100%"
														   class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
																style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																<div style="text-align: left;"><span
																		style="color:#000000">Wilt u niet langer onze nieuwsbrief ontvangen? Dan kunt u zich </span><a
																		href="#" style="color: #01689B" target="_blank"><span
																			style="color:#01689B">uitschrijven</span></a><span
																		style="color:#01689B">.</span></div>

																<div style="text-align: left;"><br>
																	<span style="color:#000000">

																		$TEXT_DIT_IS_

																		Dit is een publicatie van het ministerie van Binnenlandse Zaken en Koninkrijksrelaties.<br>
<br>
Heeft u tips of nieuws voor de nieuwsbrief? Wij horen graag van u! Stuur een e-mail naar </span><a href="http://"
																								   style="color: #01689B"
																								   target="_blank"><span
																			style="color:#01689B">redactie@digitaleoverheid.nl</span></a>
																</div>

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
													<![endif]-->
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
				</table>
				<!-- // END TEMPLATE -->
			</td>
		</tr>
	</table>
</center>
</body>
</html>
