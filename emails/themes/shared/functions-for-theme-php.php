<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


//========================================================================================================

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

//========================================================================================================

$asseturl = get_asset_url();


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
$posts         = get_posts( $filters );
$post_counter  = count( $posts );
$linkeraantal  = round( ( $post_counter / 2 ), 0 );
$rechteraantal = ( $post_counter - $linkeraantal );


// Styles
$color = isset( $theme_options['theme_color'] ) ? $theme_options['theme_color'] : '#777';
if ( empty( $color ) ) {
	$color = '#777';
}

//========================================================================================================

$font                            = isset( $theme_options['theme_font'] ) ? $theme_options['theme_font'] : '';
$font_size                       = isset( $theme_options['theme_font_size'] ) ? $theme_options['theme_font_size'] : '';
$theme_nieuwsbrieftitel_datetext = isset( $theme_options['theme_nieuwsbrieftitel_datetext'] ) ? $theme_options['theme_nieuwsbrieftitel_datetext'] : date( get_option( 'date_format' ) );
$colofon_blok1                   = isset( $theme_options['theme_colofon_block_1'] ) ? $theme_options['theme_colofon_block_1'] : 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.';
$colofon_blok2                   = isset( $theme_options['theme_colofon_block_2'] ) ? $theme_options['theme_colofon_block_2'] : 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>';
$theme_piwiktrackercode          = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';
$theme_titel_nieuws              = isset( $theme_options['theme_titel_nieuws'] ) ? $theme_options['theme_titel_nieuws'] : 'Nieuws';
$theme_titel_events              = isset( $theme_options['theme_titel_events'] ) ? $theme_options['theme_titel_events'] : 'Agenda';
$theme_socials_title             = isset( $theme_options['theme_socials_title'] ) ? $theme_options['theme_socials_title'] : 'Social media';
$theme_sitetitle                 = isset( $theme_options['theme_sitetitle'] ) ? $theme_options['theme_sitetitle'] : get_bloginfo( 'name' );
$theme_sitepayoff                = isset( $theme_options['theme_sitepayoff'] ) ? $theme_options['theme_sitepayoff'] : get_bloginfo( 'description' );
$theme_socials_xwitter_url       = isset( $theme_options['theme_socials_xwitter_url'] ) ? $theme_options['theme_socials_xwitter_url'] : '';
$theme_socials_xwitter_linktext  = isset( $theme_options['theme_socials_xwitter_linktext'] ) ? $theme_options['theme_socials_xwitter_linktext'] : '';
$theme_socials_mastodon_url      = isset( $theme_options['theme_socials_mastodon_url'] ) ? $theme_options['theme_socials_mastodon_url'] : '';
$theme_socials_mastodon_linktext = isset( $theme_options['theme_socials_mastodon_linktext'] ) ? $theme_options['theme_socials_mastodon_linktext'] : '';
$theme_socials_linkedin_url      = isset( $theme_options['theme_socials_linkedin_url'] ) ? $theme_options['theme_socials_linkedin_url'] : '';
$theme_socials_linkedin_linxtext = isset( $theme_options['theme_socials_linkedin_linxtext'] ) ? $theme_options['theme_socials_linkedin_linxtext'] : '';
$theme_socials_linkedin_linxtext = isset( $theme_options['theme_socials_linkedin_linxtext'] ) ? $theme_options['theme_socials_linkedin_linxtext'] : '';
$theme_mail_unsubscribe_text     = isset( $theme_options['theme_mail_unsubscribe_text'] ) ? $theme_options['theme_mail_unsubscribe_text'] : 'Wilt u deze nieuwsbrief niet meer ontvangen?';
$theme_mail_unsubscribe_linktext = isset( $theme_options['theme_mail_unsubscribe_linktext'] ) ? $theme_options['theme_mail_unsubscribe_linktext'] : 'Meld u zich hier af';
$theme_preview_text_view_online  = isset( $theme_options['theme_preview_text_view_online'] ) ? $theme_options['theme_preview_text_view_online'] : 'Kunt u deze nieuwsbrief niet goed lezen? <a href="{email_url}" style="color: #01689B">Bekijk dan de online versie</a><br>';

$theme_vrije_invoer_title = isset( $theme_options['theme_vrije_invoer_title'] ) ? $theme_options['theme_vrije_invoer_title'] : '';
$theme_vrije_invoer_text  = isset( $theme_options['theme_vrije_invoer_text'] ) ? $theme_options['theme_vrije_invoer_text'] : '';
$theme_vrije_invoer_image = isset( $theme_options['theme_vrije_invoer_image'] ) ? $theme_options['theme_vrije_invoer_image'] : null;
$theme_vrije_invoer_url   = isset( $theme_options['theme_vrije_invoer_url'] ) ? $theme_options['theme_vrije_invoer_url'] : '';
$theme_vrije_invoer_label = isset( $theme_options['theme_vrije_invoer_label'] ) ? $theme_options['theme_vrije_invoer_label'] : '';

$vrije_invoer = get_vrije_invoer( $theme_options );

//========================================================================================================

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

		$post_image_size = 'image-5x3-small';
		$post_title      = $postobject->post_title;
		$post_label      = mail_get_label( $postobject->ID );
		$post_date       = get_the_date( get_option( 'date_format' ), $postobject->ID );
		$post_excerpt    = rhswp_newsletter_get_excerpt( $postobject->ID );
		$post_url        = get_permalink( $postobject->ID ) . $theme_piwiktrackercode;
		$image           = wp_get_attachment_image_src( get_post_thumbnail_id( $postobject->ID ), $post_image_size );
		if ( $image ) {
			$alt   = 'Lees ' . $post_title;
			$image = '<tr><td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;"><a href="' . $post_url . '" role="presentation" tabindex="-1"><img alt="' . $alt . '" src="' . $image[0] . '" width="264" class="mcnImage"></a></td></tr>';
		}

		$return = '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
<tbody class="mcnCaptionBlockOuter">
<tr>
  <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
    <table role="presentation" align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent">
      <tbody>' . $image . '
      <tr>
        <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;" width="264">
          <p style="font-size:14px"><strong>' . $post_date . '</strong></p>
          <p style="font-size:14px"><strong><span style="color:#696969; text-transform:uppercase">' . $post_label . '</span></strong></p>
          <h3 class="null"><a href="' . $post_url . '" style="color:#01689B; text-decoration: none"><strong><span style="font-size:18px; line-height:24px; margin: 12px 0px;">' . $post_title . '</span></strong></a></h3>
          <p>' . $post_excerpt . '</p></td>
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
		$event_url = get_permalink( $eventobject->ID ) . $theme_piwiktrackercode;
		$datum     = $eventobject->output( '#_EVENTDATES' );
		$tijd      = $eventobject->output( '#_EVENTTIMES' );
//      $location_town = $eventobject->output( '#_LOCATIONTOWN' );

		$return = '<h3><a href="' . $event_url . '"><strong><span style="font-size:18px; line-height:24px; color:#01689B">' . get_the_title( $eventobject->ID ) . '</span></span></strong></a></h3>';
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

function get_vrije_invoer( $theme_options = array() ) {

	$return = '';

	$theme_vrije_invoer_title = isset( $theme_options['theme_vrije_invoer_title'] ) ? $theme_options['theme_vrije_invoer_title'] : '';
	$theme_vrije_invoer_text  = isset( $theme_options['theme_vrije_invoer_text'] ) ? $theme_options['theme_vrije_invoer_text'] : '';
	$theme_vrije_invoer_image = isset( $theme_options['theme_vrije_invoer_image'] ) ? $theme_options['theme_vrije_invoer_image'] : null;
	$theme_vrije_invoer_url   = isset( $theme_options['theme_vrije_invoer_url'] ) ? $theme_options['theme_vrije_invoer_url'] : '';
	$theme_vrije_invoer_label = isset( $theme_options['theme_vrije_invoer_label'] ) ? $theme_options['theme_vrije_invoer_label'] : '';

	if ( $theme_vrije_invoer_title && $theme_vrije_invoer_text ) {

		// START UITGELICHT ARTIKEL
		$entry_image_size   = 'medium_large';
		$image              = '';
		$imageURL_start     = '';
		$imageURL_end       = '';
		$image_alt          = $theme_vrije_invoer_title;
		$titel              = '<strong><span style="color:#000; font-size:24px; line-height:32px;">' . $theme_vrije_invoer_title . '</span></strong>';
		$vrije_invoer_label = '<p class="null"><span style="font-size:14px"><span
                                            style="color: #696969;font-weight: 600;">' . strtoupper($theme_vrije_invoer_label ). '</span></span>
                            </p>';

		// Do we have a valid URL?
		if ( filter_var( $theme_vrije_invoer_url, FILTER_VALIDATE_URL ) === false ) {
			// not a valid URL, keep the title as is
		} else {
			// append a link to the title

			$titel = '<a href="' . $theme_vrije_invoer_url . $theme_piwiktrackercode . '"><strong><span style="color:#01689B; font-size:24px; line-height:32px;">' . $theme_vrije_invoer_title . '</span></strong></a>';

			// prepare the link to the image
			$imageURL_start = '<a href = "' . $theme_vrije_invoer_url . $theme_piwiktrackercode . '" role = "presentation" tabindex = "-1">';
			$imageURL_end   = '</a>';

		}


		if ( is_array( $theme_vrije_invoer_image ) ) {

			$image = wp_get_attachment_image_src( $theme_vrije_invoer_image['id'], $entry_image_size );

			if ( $image ) {

				if ( ! $imageURL_start ) {
					// no link for this image; do not use the title as alt text, but get a different alt text
					$attachment = get_post( $theme_vrije_invoer_image['id'] );
					$image_alt  = get_post_meta( $theme_vrije_invoer_image['id'], '_wp_attachment_image_alt', true );
					if ( ! $image_alt ) {
						$image_alt = $attachment->post_title;
					}
					if ( ! $image_alt ) {
						$image_alt = $attachment->post_excerpt;
					}
					if ( ! $image_alt ) {
						$image_alt = $theme_vrije_invoer_title;
					}
				}
				$image = '<tr><td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">' . $imageURL_start . '<img alt="' . $image_alt . '" src="' . $image[0] . '" width="564" style="max-width:768px;" class="mcnImage">' . $imageURL_end . '</td></tr>';
			}
		} else {
			// no image
		}

		$return = '
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
                    ' . $image . '
                    <tr>
                        <td class="mcnTextContent" valign="top"
                            style="padding:0 9px 0 9px;" width="564">' . $vrije_invoer_label . '
                            <h2 class="null">' . $titel . '</h2>
                            <p style="color:#000; font-size: 16px">' . $theme_vrije_invoer_text . '</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>';

		// EIND UITGELICHT ARTIKEL
	} else {

	}

	return $return;


}

//========================================================================================================

