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

if (!defined('ABSPATH'))
    exit;

$theme_defaults = array(
    'theme_gc3_inleiding'   =>  'Inleiding',
    'theme_gc3_inleiding_ondertekening'   =>  "Rens Schipper",
    'theme_gc3_max_posts'   =>  5,
    'theme_gc3_max_agenda'  =>  5,
    'theme_gc3_read_more'   =>  'Lees meer',
    'theme_gc3_nieuwsbrieftitel'    =>  'Gebruiker Centraal - {date}',
    'theme_gc3_colofon1'     =>  "Dit is een nieuwsbrief van Gebruiker Centraal. Deze nieuwsbrief verschijnt maandelijks. Attendeer ook je collega's om zich hier op te abonneren.",
    'theme_gc3_colofon_twitter'     =>  '<a href="https://twitter.com/GebrCentraal">Volg ons op Twitter: @GebrCentraal</a>',
    'theme_gc3_colofon_contactinfo'      =>  'Projectteam Gebruiker Centraal<br>Mail: <a href="mailto:info@gebruikercentraal.nl">info@gebruikercentraal.nl</a><br>Website: <a href="http://www.gebruikercentraal.nl">www.gebruikercentraal.nl</a>',
    'theme_gc3_categories'  =>  array()
    );

// Mandatory!
$controls->merge_defaults($theme_defaults);
?>
<table class="form-table">
  
  <tr><td colspan="2">
  <h2>Preselectie</h2>
  
  <p>Je kunt de nieuwsbrief automatisch laten vullen met nieuwsberichten. </p>
  <p>Met het aantal berichten bepaal je het maximum aantal berichten dat hierna automatisch aan je nieuwsbrief wordt toegevoegd.<br>
    De makkelijkste methode om de berichten die je in de nieuwsbrief wilt hebben tijdelijk te voorzien van een tag, zoals 'nieuwsbrief'. Deze tag kun je dan hieronder invoeren bij 'Filter op tag'; het wordt een criterium om de nieuwsberichten voor je nieuwsbrief automatisch te selecteren.<br>Je kunt de preselectie van nieuwsberichten ook beperken tot een categorie.</p>
  
  </td></tr>

    <tr valign="top">
        <th>Titel in de nieuwsbrief</th>
        <td>
            <?php $controls->textarea('theme_gc3_nieuwsbrieftitel' ); ?>
            <p> <code>{date}</code> is <em lang="en">placeholder</em> voor de datum; bij het versturen van de nieuwsbrief wordt deze vervangen door de datum</p>
          <p>&nbsp;</p>
        </td>
    </tr>

    <tr valign="top">
        <th>Inleiding</th>
        <td>
            <?php $controls->textarea('theme_gc3_inleiding' ); ?>
        </td>
    </tr>
    <tr>
        <th>Naam onder inleiding</th>
        <td><?php $controls->text('theme_gc3_inleiding_ondertekening'); ?> </td>
    </tr>

    <tr valign="top">
        <th>Piwik-trackercode</th>
        <td>
            <?php $controls->text('theme_piwiktrackercode'); ?>
        </td>
    </tr>
  
    <tr>
        <th>Aantal berichten</th>
        <td>Selecteer <?php $controls->text('theme_gc3_max_posts', 5); ?> berichten</td>
    </tr>
    <tr>
        <th>Afbeelding gebruiken</th>
        <td>
            <?php $controls->checkbox('theme_toon_featuredimage', 'Toon uitgelichte afbeelding'); ?>
        </td>
    </tr>
    <tr>
        <th>Filter op tag</th>
        <td>
            <?php $controls->text('theme_tags', 30); ?>
            <p class="description" style="display: inline"> kommagescheiden invoeren</p>
        </td>
    </tr>

    <tr valign="top">
        <th>Filter op categorie</th>
        <td><?php $controls->categories_group('theme_gc3_categories'); ?></td>
    </tr>
    <tr valign="top">
        <th>'lees meer'-tekst</th>
        <td>
            <?php $controls->text('theme_gc3_read_more'); ?>
        </td>
    </tr>
<?php 

  $agendablok = EM_Events::output(
    array(
      'format'      =>  '<h2 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #002f3e; clear: both; display: block; float: none; font-weight: bold; text-transform: uppercase;"><a href="#_EVENTURL" style="text-decoration: none">#_EVENTNAME</a></h2>
      <p><strong>#_EVENTDATES {has_location}(#_LOCATIONTOWN){/has_location}</strong></p><p>#_EVENTEXCERPT<br><strong><a href="#_EVENTURL">' .  $theme_options['theme_gc3_read_more'] . '</a></strong></p><hr style="background: #e6e6e6; border: 0; clear: both; display: block; float: none; height: 2px; margin: 8px 0 32px 0;">',
      'limit'       =>  $filters['theme_gc3_max_agenda'] ) );
  
  
  // tricky dick!
  $agendablok = str_replace( '/">', '/' . $theme_piwiktrackercode  .'">', $agendablok );
  
  if ( 'Geen Evenementen' == $agendablok ) {
    ?>  
      <tr valign="top">
          <th>Agenda</th>
          <td>Er zijn op dit moment geen items voor de agenda</td>
      </tr>
    <?php    
  }
  else {
    ?>  
      <tr valign="top">
          <th>Aantal items in agenda</th>
          <td>Selecteer <?php $controls->text('theme_gc3_max_agenda', 5); ?> items voor de agenda (<?php echo $agendablok ?>)</td>
      </tr>
    <?php    
  }
  ?>


    <tr valign="top">
        <th>Colofon - regel 1</th>
        <td>
            <?php $controls->textarea('theme_gc3_colofon1' ); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Colofon - Twitter</th>
        <td>
            <?php $controls->textarea('theme_gc3_colofon_twitter' ); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Colofon - contactinfo</th>
        <td>
            <?php $controls->textarea('theme_gc3_colofon_contactinfo' ); ?>
        </td>
    </tr>

</table>
