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

//========================================================================================================

// variabelen worden gezet in ../shared/functions-for-theme-options-php.php
$shared_folder = dirname(__FILE__, 2);
$shared_file = $shared_folder . '/shared/functions-for-theme-options-php.php';
include_once( $shared_file );

//========================================================================================================


?>
<table class="form-table" style="border-spacing: 0;">


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


    <!-- START TOEGEVOEGD ------>
    <tr style="padding: 1rem; background: #eaeaea;">
        <td colspan="2" style="border: 1px solid var(--tnp-text) ?> border-bottom-style: none;">
            <h2 style="margin: 0;">Vrije invoer</h2>
        </td>
    </tr>
    <tr style="padding: 1rem; background: #eaeaea;">
        <th style="border-left: 1px solid var(--tnp-text);">Titel (verplicht)</th>
        <td style="border-right: 1px solid var(--tnp-text);">
			<?php $controls->text( 'theme_vrije_invoer_xx3_title', 50 ) ?>
            <p class="description"> Zowel titel als vrije tekst zijn verplicht.</p>
        </td>
    </tr>
    <tr style="padding: 0 1rem; background: #eaeaea;">
        <th style="border-left: 1px solid var(--tnp-text);">Vrije tekst (verplicht)</th>
        <td style="border-right: 1px solid var(--tnp-text);">
			<?php $controls->wp_editor( 'theme_vrije_invoer_xx3_text' ) ?>
        </td>
    </tr>
    <tr style="padding: 1rem; background: #eaeaea;">
        <th style="border-left: 1px solid var(--tnp-text);">Label</th>
        <td style="border-right: 1px solid var(--tnp-text);">
			<?php $controls->text( 'theme_vrije_invoer_xx3_label', 50 ) ?>
            <p class="description"> Dit is de korte tekst boven de titel. Wees kort; gebruik niet meer dan 3
                woorden.</p>
        </td>
    </tr>
    <tr style="padding: 0 1rem; background: #eaeaea;">
        <th style="border-left: 1px solid var(--tnp-text);">
            Uitgelichte afbeelding
        </th>
        <td style="border-right: 1px solid var(--tnp-text);">
			<?php $controls->media( 'theme_vrije_invoer_xx3_image' ) ?>
            <p class="description"> Deze afbeelding wordt breed getoond en moet een minimale breedte hebben van 600 pixels.</p>
        </td>
    </tr>
    <tr style="padding: 0 1rem 1rem 1rem; background: #eaeaea;">
        <th style="border: 1px solid var(--tnp-text) ?> border-right-style: none; border-top-style: none;">
            URL
        </th>
        <td style="border: 1px solid var(--tnp-text) ?> border-left-style: none; border-top-style: none;">
			<?php $controls->text_url( 'theme_vrije_invoer_xx3_url' ) ?>
            <p class="description"> Deze link wordt toegevoegd aan de titel en de uitgelichte afbeelding als je die hebt
                toegevoegd.</p>
        </td>
    </tr>
    <!-- EIND TOEGEVOEGD ------>

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
			<?php $controls->textarea( 'theme_preview_text_view_online' ); ?>
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
        <th>Mastodon URL</th>
        <td>
			<?php $controls->text( 'theme_socials_mastodon_url', 50 ); ?>
        </td>
    </tr>
    <tr>
        <th>Mastodon linktekst</th>
        <td>
			<?php $controls->text( 'theme_socials_mastodon_linktext', 50 ); ?>
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
