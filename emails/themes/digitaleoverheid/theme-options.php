<?php
/*
 * This is a pre packaged theme options page. Every option name
 * must start with "theme_" so Newsletter can distinguish them from other
 * options that are specific to the object using the theme.
 *
 * An array of theme default options should always be present and that default options
 * should be merged with the current complete set of options as shown below.
 *
 * Every theme can define its own set of options, the will be used in the theme.php
 * file while composing the email body. Newsletter knows nothing about theme options
 * (other than saving them) and does not use or relies on any of them.
 *
 * For multilanguage purpose you can actually check the constants "WP_LANG", until
 * a decent system will be implemented.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$default_name        = get_bloginfo( 'name' );
$default_description = get_bloginfo( 'description' );

$theme_defaults = array(
	'theme_max_posts'                 => 5,
	'theme_max_agenda'                => 5,
	'theme_nieuwsbrieftitel'          => 'Digitale Overheid - {date}',
	'theme_colofon_block_1'           => 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.',
	'theme_colofon_block_2'           => 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>',
	'theme_sitetitle'                 => $default_name,
	'theme_sitepayoff'                => $default_description,
	'theme_categories'                => array(),
	'theme_select_uitgelicht'         => 0,
	'theme_titel_nieuws'              => 'Nieuws',
	'theme_titel_events'              => 'Evenementen',
	'theme_titel_socials'             => 'Volg ons via social media',
	'theme_socials_twitter_url'       => 'https://twitter.com/digioverheid',
	'theme_socials_twitter_linktext'  => 'Volg ons via Twitter',
	'theme_socials_linkedin_url'      => 'https://www.linkedin.com/company/digitaleoverheidnl/',
	'theme_socials_linkedin_linktext' => 'Volg ons op LinkedIn',
	'theme_mail_unsubscribe_text'     => 'Wilt u deze nieuwsbrief niet meer ontvangen?',
	'theme_mail_unsubscribe_linktext' => 'Meld u zich hier af',
	'theme_preview_text'              => 'Nieuwsbrief Digitale Overheid',
);

// Mandatory!
$controls->merge_defaults( $theme_defaults );

$laatsteberichten = array(
	'0' => __( '-selecteer bericht-', 'newsletter' ),
);

$maxberichten = 100;

$arguments = array(
	'numberposts' => $maxberichten,
	'orderby'     => 'date',
	'order'       => 'DESC',
);
$myposts   = get_posts( $arguments );


foreach ( $myposts as $post ) {
	setup_postdata( $post );
	$titel = get_the_title( $post->ID );
	$datum = ' - (' . get_the_date( get_option( 'date_format' ), $post->ID ) . ')';
//	$category                      = get_the_date( $post->ID );
	$category                      = '';
	$laatsteberichten[ $post->ID ] = $titel . $datum . $category;
}


?>
<table class="form-table">

	<tr>
		<td colspan="2">
			<h2>Preselectie</h2>

			<p>Je kunt de nieuwsbrief automatisch laten vullen met nieuwsberichten. </p>
			<p>Met het aantal berichten bepaal je het maximum aantal berichten dat hierna automatisch aan je nieuwsbrief
				wordt toegevoegd.<br>
				De makkelijkste methode om de berichten die je in de nieuwsbrief wilt hebben tijdelijk te voorzien van
				een tag, zoals 'nieuwsbrief'. Deze tag kun je dan hieronder invoeren bij 'Filter op tag'; het wordt een
				criterium om de nieuwsberichten voor je nieuwsbrief automatisch te selecteren.<br>Je kunt de preselectie
				van nieuwsberichten ook beperken tot een categorie.</p>

		</td>
	</tr>
	<tr valign="top">
		<th>Piwik-trackercode</th>
		<td>
			<?php $controls->text( 'theme_piwiktrackercode', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>Uitgelicht bericht</th>
		<td>
			<?php
			$lists = $controls->get_list_options();

			$controls->select( 'theme_select_uitgelicht', $laatsteberichten ); ?>
			<p>Het bericht dat je hier selecteert wordt groot boven aan de mail weergegeven. <br> De lijst toont de
				laatste <?php echo $maxberichten ?> berichten, gesorteerd op datum.</p>

		</td>
	</tr>
	<tr>
		<th>Aantal berichten</th>
		<td>Selecteer <?php $controls->text( 'theme_max_posts', 5 ); ?> berichten</td>
	</tr>
	<tr>
		<th>Filter op tag</th>
		<td>
			<?php $controls->text( 'theme_tags', 50 ); ?>
			<p class="description" style="display: inline"> kommagescheiden invoeren</p>
		</td>
	</tr>
	<tr valign="top">
		<th>Titel in de nieuwsbrief</th>
		<td>
			<?php $controls->textarea( 'theme_nieuwsbrieftitel' ); ?>
			<p><code>{date}</code> is <em lang="en">placeholder</em> voor de datum; bij het versturen van de nieuwsbrief
				wordt deze vervangen door de datum</p>
		</td>
	</tr>
	<tr valign="top">
		<th>Preview text</th>
		<td>
			<?php $controls->textarea( 'theme_preview_text' ); ?>
			<p>Max. 2 regels tekst met een samenvatting van de inhoud van de nieuwbrief.</p>
		</td>
	</tr>

	<tr valign="top">
		<th>Titel boven berichten</th>
		<td>
			<?php $controls->text( 'theme_titel_nieuws', 50 ); ?>
		</td>
	</tr>

	<tr valign="top">
		<th>Filter op categorie</th>
		<td><?php $controls->categories_group( 'theme_categories' ); ?></td>
	</tr>


	<tr valign="top">
		<th>Titel boven agenda</th>
		<td>
			<?php $controls->text( 'theme_titel_events', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Aantal items in agenda</th>
		<td>Selecteer <?php $controls->text( 'theme_max_agenda', 5 ); ?> items voor de agenda</td>
	</tr>




	<tr valign="top">
		<th>Site-titel</th>
		<td>
			<?php $controls->text( 'theme_sitetitle', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Payoff</th>
		<td>
			<?php $controls->text( 'theme_sitepayoff', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Titel boven socialmedia-links</th>
		<td>
			<?php $controls->text( 'theme_titel_socials', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Twitter URL</th>
		<td>
			<?php $controls->text( 'theme_socials_twitter_url', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Twitter linktekst</th>
		<td>
			<?php $controls->text( 'theme_socials_twitter_linktext', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>LinkedIn URL</th>
		<td>
			<?php $controls->text( 'theme_socials_linkedin_url', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>LinkedIn linktekst</th>
		<td>
			<?php $controls->text( 'theme_socials_linkedin_linktext', 50 ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>inleiding bij uitschrijven nieuwsbrief</th>
		<td>
			<?php $controls->textarea( 'theme_mail_unsubscribe_text' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>linktekst voor uitschrijven nieuwsbrief</th>
		<td>
			<?php $controls->textarea( 'theme_mail_unsubscribe_linktext' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Colofon - blok 1</th>
		<td>
			<?php $controls->textarea( 'theme_colofon_block_1' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th>Colofon - blok 2</th>
		<td>
			<?php $controls->textarea( 'theme_colofon_block_2' ); ?>
		</td>
	</tr>

</table>
