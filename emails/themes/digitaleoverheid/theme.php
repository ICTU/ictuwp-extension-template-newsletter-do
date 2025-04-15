<?php
global $newsletter; // Newsletter object
global $post; // Current post managed by WordPress

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//========================================================================================================

// variabelen worden gezet in ../shared/functions-for-theme-php.php
$shared_folder = dirname( __FILE__, 2 );
$shared_file   = $shared_folder . '/shared/functions-for-theme-php.php';
include_once( $shared_file );

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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
            font-size: 26px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        h2 {
            color: #202020;
            font-family: helvetica neue,helvetica,arial,sans-serif;
            font-size: 22px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        h3 {
            color: #202020;
            font-family: helvetica neue,helvetica,arial,sans-serif;
            font-size: 20px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        h4 {
            color: #202020;
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
            font-family: helvetica neue,helvetica,arial,sans-serif;
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
      style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;"><?php echo $theme_preview_text_view_online ?></span>

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
                                                                <div style="text-align: left;">
																	<?php echo $theme_preview_text_view_online ?>
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
                                                            <td width="66%">
                                                                <h1 class="query"
                                                                    style="font-family: helvetica neue,helvetica,arial,sans-serif; font-weight: 700; font-size: 21px; color: #fff; text-align: left; padding-left: 10px !important;">
																	<?php echo $theme_sitetitle ?>
                                                                </h1>
                                                            </td>
                                                            <td width="34%">
                                                                <p class="query"
                                                                   style="font-family: helvetica neue,helvetica,arial,sans-serif;font-weight: 400; font-size: 18px; color: #fff; text-align: right;  padding-right: 10px !important;">
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
                                                                    style="padding:0 9px 0 9px;" width="564">
                                                                    <p style="color:#000; font-size: 18px; font-weight: bold; margin: 10px 0"><?php echo $uitgelicht_date ?></p>
                                                                    <p class="null"><span style="font-size:14px"><span
                                                                                    style="color: #696969;font-weight: 600;"><?php echo $uitgelicht_label ?></span></span>
                                                                    </p>
                                                                    <h2 style="font-family:helvetica neue,helvetica,arial,sans-serif;"><a
                                                                                href="<?php echo $uitgelicht_url ?>"><strong>
																				<span
                                                                                        style="color:#01689B; font-size:24px; line-height:32px;"><?php echo $uitgelicht_title ?></span></strong></a>
                                                                    </h2>
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
										<?php // START (1) check if any posts are available
										if ( $post_counter > 0 ) {
											?>


                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                                   width="100%"
                                                   class="mcnDividerBlock" style="min-width:100%;">
                                                <tbody class="mcnDividerBlockOuter">
                                                <tr>
                                                    <td class="mcnDividerBlockInner"
                                                        style="min-width:100%; padding:9px;">
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
											<?php // END (1) check if any posts are available
										}
										?>

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
													<?php // START (2) check if any posts are available
													if ( $post_counter > 0 ) {
													?>

                                                    <table role="presentation" align="left" border="0" cellpadding="0"
                                                           cellspacing="0"
                                                           style="max-width:100%; min-width:100%;" width="100%"
                                                           class="mcnTextContentContainer">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top" class="mcnTextContent"
                                                                style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <h2 style="font-family:helvetica neue,helvetica,arial,sans-serif; font-size:32px;"><?php echo $theme_titel_nieuws ?></h2>
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
													<?php // END (2) check if any posts are available
													}
													?>

													<![endif]--></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
					<?php // START (3) check if any posts are available
					if ( $post_counter > 0 ) {
						?>
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
                                            
                                            <table role="presentation" align="center" border="0" cellpadding="0"
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
						<?php // END (3) check if any posts are available
					}
					?>

                    <tr>
                        <td align="center" valign="top" id="templateLowerBody">

                            <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0"
                                   width="100%"
                                   class="templateContainer">
                                <tr>
                                    <td valign="top" class="bodyContainer">

										<?php
										if ( $vrije_invoer ) {

											?>
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                                   width="100%"
                                                   class="mcnDividerBlock" style="min-width:100%;">
                                                <tbody class="mcnDividerBlockOuter">
                                                <tr>
                                                    <td class="mcnDividerBlockInner"
                                                        style="min-width:100%; padding:18px;">
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

											echo $vrije_invoer;

										} else {
											// GEEN UITGELICHTE DINGES

										}
										?>

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
											$event_counter = count( $EM_Events );
											$linkeraantal  = round( ( $event_counter / 2 ), 0 );
											$rechteraantal = ( $event_counter - $linkeraantal );
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

										if ( $linker_events || $rechter_events ) {
											// only show events title etc if events are available

											?>


                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                                   width="100%"
                                                   class="mcnTextBlock" style="min-width:100%;">
                                                <tbody class="mcnTextBlockOuter">
                                                <tr>
                                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">

                                                        <table role="presentation" align="left" border="0"
                                                               cellpadding="0"
                                                               cellspacing="0"
                                                               style="max-width:100%; min-width:100%;" width="100%"
                                                               class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" class="mcnTextContent"
                                                                    style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                    <h2 style="font-family:helvetica neue,helvetica,arial,sans-serif; font-size:32px;"><?php echo $theme_titel_events ?></h2>
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
                                                        <table role="presentation" align="center" border="0"
                                                               cellpadding="0"
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
                                                        <table role="presentation" align="center" border="0"
                                                               cellpadding="0"
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
                                                    <td class="mcnDividerBlockInner"
                                                        style="min-width:100%; padding:18px;">
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
										}

										?>

										<?php
										// als er socials zijn
										if ( ( $theme_socials_xwitter_url && $theme_socials_xwitter_linktext ) || ( $theme_socials_linkedin_url && $theme_socials_linkedin_linxtext ) || ( $theme_socials_mastodon_url && $theme_socials_mastodon_linktext ) ) {
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

                                                                    <h2 style="font-family:helvetica neue,helvetica,arial,sans-serif; font-size:32px;"><?php echo $theme_socials_title ?></h2>


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
																	if ( $theme_socials_xwitter_url && $theme_socials_xwitter_linktext ) {

																		echo '<span style="color:#01689B"><img alt="x / twitter-logo" height="16" src="' . $asseturl . 'icon-xwitter.jpg" alt="" style="border: 0px; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<a href="' . $theme_socials_xwitter_url . '" style="color:#01689B">' . $theme_socials_xwitter_linktext . '</a><br>';

																	}
																	if ( $theme_socials_linkedin_url && $theme_socials_linkedin_linxtext ) {

																		echo '<span style="color:#01689B"><img alt="linkedin-logo" height="16" src="' . $asseturl . 'icon_linkedin.jpeg" alt="" style="border: 0px; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<a href="' . $theme_socials_linkedin_url . '" style="color:#01689B">' . $theme_socials_linkedin_linxtext . '</a><br>';

																	}
																	if ( $theme_socials_mastodon_url && $theme_socials_mastodon_linktext ) {

																		echo '<span style="color:#01689B"><img alt="Mastodon-logo" height="16" src="' . $asseturl . 'icon_mastodon.jpg" alt="" style="border: 0px; width: 16px; height: 16px; margin: 0px;" width="16">&nbsp; &nbsp;<a href="' . $theme_socials_mastodon_url . '" style="color:#01689B">' . $theme_socials_mastodon_linktext . '</a><br>';

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
