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
	'theme_nieuwsbrieftitel_datetext' => date( get_option( 'date_format' ) ),
	'theme_colofon_block_1'           => 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.',
	'theme_colofon_block_2'           => 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>',
	'theme_sitetitle'                 => $default_name,
	'theme_sitepayoff'                => $default_description,
	'theme_categories'                => array(),
	'theme_select_uitgelicht'         => 0,
	'theme_titel_nieuws'              => 'Nieuws',
	'theme_titel_events'              => 'Evenementen',
	'theme_socials_title'             => 'Social media',
	'theme_socials_xwitter_url'       => 'https://twitter.com/digioverheid',
	'theme_socials_xwitter_linktext'  => 'Volg ons via X',
	'theme_socials_linkedin_url'      => 'https://www.linkedin.com/company/digitaleoverheidnl/',
	'theme_socials_linkedin_linxtext' => 'Volg ons op LinkedIn',
	'theme_mail_unsubscribe_text'     => 'Wilt u deze nieuwsbrief niet meer ontvangen?',
	'theme_mail_unsubscribe_linktext' => 'Meld u zich hier af',
	'theme_preview_text'              => 'Nieuwsbrief Digitale Overheid',
);

// Mandatory!
$controls->merge_defaults( $theme_defaults );

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

			<p class="description">Je kunt de nieuwsbrief automatisch laten vullen met nieuwsberichten. </p>
			<p class="description">Met het aantal berichten bepaal je het maximum aantal berichten dat hierna
				automatisch aan je nieuwsbrief
				wordt toegevoegd.</p>
			<p class="description">De makkelijkste methode om de berichten die je in de nieuwsbrief wilt hebben
				tijdelijk te voorzien van
				een tag, zoals 'nieuwsbrief'. Deze tag kun je dan hieronder invoeren bij 'Filter op tag'; het wordt een
				criterium om de nieuwsberichten voor je nieuwsbrief automatisch te selecteren.<br>Je kunt de preselectie
				van nieuwsberichten ook beperken tot een categorie.</p>

		</td>
	</tr>
	<tr>
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
			<p class="description">Het bericht dat je hier selecteert wordt groot boven aan de mail weergegeven. De
				lijst toont de
				laatste <?php echo $maxberichten ?> berichten, gesorteerd op datum.</p>

		</td>
	</tr>
	<tr>
		<th>Aantal berichten</th>
		<td>Selecteer <?php $controls->text( 'theme_max_posts', 5 ); ?> berichten
			<p class="description">Dit is het aantal berichten onder het uitgelichte bericht.</p>
		</td>
	</tr>
	<tr>
		<th>Filter op tag</th>
		<td>
			<?php $controls->text( 'theme_tags', 50 ); ?>
			<p class="description"> kommagescheiden invoeren</p>
		</td>
	</tr>
	<tr>
		<th>Datum naast de titel</th>
		<td>
			<?php $controls->textarea( 'theme_nieuwsbrieftitel_datetext' ); ?>
			<p class="description">Deze tekst heeft geen invloed op het moment waarop de nieuwsbrief verstuurd
				wordt.</p>
		</td>
	</tr>
	<tr>
		<th>Preview text</th>
		<td>
			<?php $controls->textarea( 'theme_preview_text' ); ?>
			<p class="description">Max. 2 regels tekst met een samenvatting van de inhoud van de nieuwbrief.</p>
		</td>
	</tr>

	<tr>
		<th>Titel boven berichten</th>
		<td>
			<?php $controls->text( 'theme_titel_nieuws', 50 ); ?>
		</td>
	</tr>

	<tr>
		<th>Filter op categorie</th>
		<td><?php $controls->categories_group( 'theme_categories' ); ?></td>
	</tr>


	<tr>
		<th>Titel boven agenda</th>
		<td>
			<?php $controls->text( 'theme_titel_events', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>Aantal items in agenda</th>
		<td>Selecteer <?php $controls->text( 'theme_max_agenda', 5 ); ?> items voor de agenda</td>
	</tr>


	<tr>
		<th>Nieuwsbrief-titel</th>
		<td>
			<?php $controls->text( 'theme_sitetitle', 50 ); ?>
			<p class="description">.</p>
		</td>
	</tr>
	<tr>
		<th>Payoff</th>
		<td>
			<?php $controls->text( 'theme_sitepayoff', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>Titel boven socialmedia-links</th>
		<td>
			<?php $controls->text( 'theme_socials_title', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>X (Twitter) URL</th>
		<td>
			<?php $controls->text( 'theme_socials_xwitter_url', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>X (Twitter) linktekst</th>
		<td>
			<?php $controls->text( 'theme_socials_xwitter_linktext', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>LinkedIn URL</th>
		<td>
			<?php $controls->text( 'theme_socials_linkedin_url', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>LinkedIn linktekst</th>
		<td>
			<?php $controls->text( 'theme_socials_linkedin_linxtext', 50 ); ?>
		</td>
	</tr>
	<tr>
		<th>inleiding bij uitschrijven nieuwsbrief</th>
		<td>
			<?php $controls->textarea( 'theme_mail_unsubscribe_text' ); ?>
		</td>
	</tr>
	<tr>
		<th>linktekst voor uitschrijven nieuwsbrief</th>
		<td>
			<?php $controls->textarea( 'theme_mail_unsubscribe_linktext' ); ?>
		</td>
	</tr>
	<tr>
		<th>Colofon - blok 1</th>
		<td>
			<?php $controls->textarea( 'theme_colofon_block_1' ); ?>
		</td>
	</tr>
	<tr>
		<th>Colofon - blok 2</th>
		<td>
			<?php $controls->textarea( 'theme_colofon_block_2' ); ?>
		</td>
	</tr>

</table>
