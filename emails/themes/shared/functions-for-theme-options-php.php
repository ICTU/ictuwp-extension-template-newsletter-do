<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//========================================================================================================

$default_name        = get_bloginfo( 'name' );
$default_description = get_bloginfo( 'description' );

//========================================================================================================

$theme_defaults = array(
	'theme_max_posts'                 => 5,
	'theme_max_agenda'                => 5,
	'theme_nieuwsbrieftitel_datetext' => date( get_option( 'date_format' ) ),
	'theme_colofon_block_1'           => 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.',
	'theme_colofon_block_2'           => 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>',
	'theme_sitetitle'                 => $default_name,
	'theme_sitepayoff'                => $default_description,
	'theme_categories'                => array(),
	'theme_titel_nieuws'              => 'Nieuws',
	'theme_titel_events'              => 'Evenementen',
	'theme_socials_title'             => 'Social media',
	'theme_socials_xwitter_url'       => 'https://twitter.com/digioverheid',
	'theme_socials_xwitter_linktext'  => 'Volg ons via X',
	'theme_socials_mastodon_url'      => 'https://social.overheid.nl/@DigitaleOverheid',
	'theme_socials_mastodon_linktext' => 'Volg ons via Mastodon',
	'theme_socials_linkedin_url'      => 'https://www.linkedin.com/company/digitaleoverheidnl/',
	'theme_socials_linkedin_linxtext' => 'Volg ons op LinkedIn',
	'theme_mail_unsubscribe_text'     => 'Wilt u deze nieuwsbrief niet meer ontvangen?',
	'theme_mail_unsubscribe_linktext' => 'Meld u zich hier af',
	'theme_preview_text_view_online'  => 'Kunt u deze nieuwsbrief niet goed lezen? <a href="{email_url}" style="color: #01689B">Bekijk dan de online versie</a><br>',

	'theme_vrije_invoer_xx3_title' => '',
	'theme_vrije_invoer_xx3_text'  => '',
	'theme_vrije_invoer_xx3_url'   => '',
	'theme_vrije_invoer_xx3_image' => '',
	'theme_vrije_invoer_xx3_label' => '',


);


// Mandatory!
$controls->merge_defaults( $theme_defaults );

//========================================================================================================

$laatsteberichten = array(
	'0' => __( '-selecteer bericht-', 'newsletter' ),
);

$maxberichten = 50;

$arguments = array(
	'numberposts' => $maxberichten,
	'orderby'     => 'date',
	'order'       => 'DESC',
);
$myposts   = get_posts( $arguments );


foreach ( $myposts as $post ) {
	setup_postdata( $post );
	$titel                         = get_the_title( $post->ID );
	$datum                         = ' - (' . get_the_date( get_option( 'date_format' ), $post->ID ) . ')';
	$category                      = '';
	$laatsteberichten[ $post->ID ] = $titel . $datum . $category;
}

//========================================================================================================

