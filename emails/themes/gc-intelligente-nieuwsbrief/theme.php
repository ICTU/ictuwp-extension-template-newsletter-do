<?php
global $newsletter; // Newsletter object
global $post; // Current post managed by WordPress

if (!defined('ABSPATH'))
    exit;

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
if ( isset($theme_options['theme_gc3_max_posts'] ) ) {
  $filters['posts_per_page'] = (int) $theme_options['theme_gc3_max_posts'];
}
if ($filters['posts_per_page'] == 0) {
    $filters['posts_per_page'] = 5;
}

if (!empty($theme_options['theme_tags'])) {
    $filters['tag'] = $theme_options['theme_tags'];
}


// Maximum number of events to retrieve
$filters['theme_gc3_max_agenda'] = 5;
if ( isset($theme_options['theme_gc3_max_agenda'] ) ) {
  $filters['theme_gc3_max_agenda'] = (int) $theme_options['theme_gc3_max_agenda'];
}
if ($filters['theme_gc3_max_agenda'] == 0) {
    $filters['theme_gc3_max_agenda'] = 5;
}


// Include only posts from specified categories. Do not filter per category is no
// one category has been selected.
if ( isset($theme_options['theme_gc3_categories'] ) ) {
  if (is_array($theme_options['theme_gc3_categories'])) {
      $filters['cat'] = implode(',', $theme_options['theme_gc3_categories']);
  }
}


// Retrieve the posts asking them to WordPress
$posts = get_posts($filters);

// Styles
$color = isset( $theme_options['theme_color'] ) ? $theme_options['theme_color'] : '#777';
if (empty($color))
    $color = '#777';

$font       = isset( $theme_options['theme_font'] ) ? $theme_options['theme_font'] : '';
$font_size  = isset( $theme_options['theme_font_size'] ) ? $theme_options['theme_font_size'] : '';



$theme_gc3_nieuwsbrieftitel  = isset( $theme_options['theme_gc3_nieuwsbrieftitel'] ) ? $theme_options['theme_gc3_nieuwsbrieftitel'] : 'Gebruiker Centraal - {date}';
$theme_gc3_colofon1  = isset( $theme_options['theme_gc3_colofon1'] ) ? $theme_options['theme_gc3_colofon1'] : 'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.';
$theme_gc3_colofon_twitter  = isset( $theme_options['theme_gc3_colofon_twitter'] ) ? $theme_options['theme_gc3_colofon_twitter'] : 'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:info@gebruikercentraal.nl">info@gebruikercentraal.nl</a>';
$theme_gc3_colofon_contactinfo  = isset( $theme_options['theme_gc3_colofon_contactinfo'] ) ? $theme_options['theme_gc3_colofon_contactinfo'] : 'Gebruiker Centraal is ook te volgen op Twitter: <a href="https://twitter.com/GebrCentraal">@GebrCentraal</a>';
$theme_toon_featuredimage  = isset( $theme_options['theme_toon_featuredimage'] ) ? $theme_options['theme_toon_featuredimage'] : '';

$theme_gc3_inleiding  = isset( $theme_options['theme_gc3_inleiding'] ) ? $theme_options['theme_gc3_inleiding'] : '<span style="color: white; background: red;">Voer een inleiding in</span>';
$theme_gc3_inleiding = nl2br( $theme_gc3_inleiding );
$theme_gc3_inleiding_ondertekening  = isset( $theme_options['theme_gc3_inleiding_ondertekening'] ) ? $theme_options['theme_gc3_inleiding_ondertekening'] : '<span style="color: white; background: red;">Voer een naam in</span>';

$theme_piwiktrackercode   = isset( $theme_options['theme_piwiktrackercode'] ) ? '?pk_campaign=' . $theme_options['theme_piwiktrackercode'] : '';


/**
 * Accepts a post or a post ID.
 * 
 * @param WP_Post $post
 */
function rhswp_newsletter_the_excerpt($post, $words = 80) {
    $post = get_post($post);
    $excerpt = $post->post_excerpt;
    if (empty($excerpt)) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = wp_strip_all_tags($excerpt, true);
    }
    echo wp_trim_words($excerpt, $words);
}


?>
<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width">
<title>Nieuwsbrief januari 2017 - De Toekomst van Gebruiker Centraal</title>
<style type="text/css">
.ExternalClass {
  width: 100%;
}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%;
}
body {
  -webkit-text-size-adjust: none;
  -ms-text-size-adjust: none;
}
body {
  margin: 0;
  padding: 0;
}
table td, table {
  border-collapse: collapse;
}
p {
  margin: 0;
  padding: 0;
  margin-bottom: 0;
}
.ExternalClass h1, .ExternalClass h2, .ExternalClass h3, .ExternalClass h4, .ExternalClass h5, .ExternalClass h6 {
  padding: 0.5em 0 0.5em 0 !important;
}
span.yshortcuts {
  color: #002F3E;
  background-color: none;
  border: none;
}
span.yshortcuts:hover, span.yshortcuts:active, span.yshortcuts:focus {
  color: #002F3E;
  background-color: none;
  border: none;
}

h1, h2, h3, h4, h5, h6 {
  padding: 0;
  margin: 0;
  line-height: 100%;
}
a:link, a, a:visited, a:link {
  color: #002F3E;
}
p {
  margin: 0 0 1.35em 0;
}
h1, h2, h3, h4, h5, h6 {
  margin: 0.5em 0 0.5em 0;
}
h1 {
  font-size: 2em;
}
h2 {
  font-size: 1.5em;
}
h3 {
  font-size: 1.17em;
}
h4 {
  font-size: 1em;
}
h5 {
  font-size: 0.83em;
}
h6 {
  font-size: 0.67em;
}
img {
  max-width: 95%;
  height: auto;
}
.header_image img {
  max-width: 100%;
}
.alignleft {
  display: inline;
  float: left;
}
.alignright {
  display: inline;
  float: right;
}
.aligncenter {
  clear: both;
  display: block;
  margin-left: auto;
  margin-right: auto;
}
img.alignleft, img.alignright, img.alignnone {
  margin: 7px;
}
.width {
  width: 100%;
}
.container, .content {
  min-width: 100%;
}
.title {
  color: #002F3E;
}
.text_right {
  text-align: right;
}
a {
  color: #002f3e;
  text-decoration: underline;
}
a img {
  margin-bottom: -4px;
  margin-bottom: -0.4rem;
}
a:hover {
  color: #c42c76;
}
p {
  margin: 0 0 16px 0;
  padding: 0;
}
ol, ul {
  padding: 0 0 0 16px;
}
blockquote, blockquote::before {
  color: #002f3e;
}
blockquote {
  margin: 16px;
}
blockquote::before {
  content: "\201C";
  display: block;
  font-size: 30px;
  height: 0;
  left: -16px;
  position: relative;
  top: -16px;
}
.entry-content code {
  background-color: #f1f1f1;
  color: #002f3e;
}
cite {
  font-style: normal;
}
p {
  -webkit-hyphens: auto;
  -moz-hyphens: auto;
  -ms-hyphens: auto;
  -o-hyphens: auto;
  hyphens: auto;
  margin: 0 0 16px 0;
  padding: 0;
  -moz-hyphens: auto;
  -ms-hyphens: auto;
  -o-hyphens: auto;
  -webkit-hyphens: auto;
  hyphens: auto;
  font-family: Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 22px;
}
.attachment a, .gallery a {
  border: none;
}
ol li {
  list-style-type: decimal;
}
ul li {
  list-style-type: disc;
}
ol ol, ul ul {
  margin-bottom: 0;
}
.infoblock {
  background: #e6e6e6;
  border: 1px solid #b3b3b3;
  padding: 1em;
  margin: 1em 0;
}
img.centered, .aligncenter {
  display: block;
  margin: 0 auto 16px;
}
.alignleft {
  float: left;
  text-align: left;
}
.alignright {
  float: right;
  text-align: right;
}
img.alignleft, .wp-caption.alignleft {
  margin: 5.33333333px 8px 16px 0;
}
img.alignright, .wp-caption.alignright {
  margin: 5.33333333px 0 16px 8px;
}
.wp-caption.alignnone {
  margin: 5.33333333px 0 0 0;
}
.wp-caption-text {
  font-size: 12px;
  font-weight: normal;
  text-align: left;
  border-bottom: 1px solid #ddd;
  line-height: 1.4;
  padding: 8px 0;
}
.alignright .wp-caption-text {
  margin-left: 10px;
  margin-bottom: 0 !important;
}
.alignleft .wp-caption-text {
  margin-right: 10px;
  margin-bottom: 0 !important;
}
.gallery-caption {
  border-bottom: none;
}
body, .body_style, h1, h2, h3, h4, h5, h6, p, li, a, td {
  font-family: Helvetica, Arial, sans-serif;
}
body, .body_style {
  font-size: 12px;
}
body a, .body_style a {
  font-weight: bold;
}
body, .body_style, table.container {
  background-color: #ffffff;
  color: #002f3e;
}
table.content {
  background-color: #ffffff;
}
.width {
  max-width: 700px;
}
.holder {
  padding: 1.5%;
}
.branding_html {
  padding: 16px 16px 16px 32px;
  font-size: 21.6px;
}
.branding_html img {
  width: auto;
  max-height: 90px;
}
.title, h1 {
  text-transform: uppercase;
  font-weight: bold;
}
.title {
  font-size: 21.6px;
}
.email_content, table, .email_content .contact_info, table .contact_info, .email_content h1, table h1, .email_content h2, table h2, .email_content h3, table h3, .email_content h4, table h4, .email_content h5, table h5, .email_content h6, table h6 {
  color: #002f3e;
}
.email_content h1, table h1, .email_content h2, table h2, .email_content h3, table h3, .email_content h4, table h4, .email_content h5, table h5, .email_content h6, table h6 {
  display: block;
  float: none;
  clear: both;
  font-weight: bold;
  text-transform: uppercase;
}
.email_content h1, table h1, .email_content h2, table h2, .email_content h3, table h3, .email_content h4, table h4, .email_content h5, table h5, .email_content h6, table h6 {
  margin: 16px 0 8px 0;
  padding: 0;
}
.email_content h1, table h1 {
  font-size: 24px;
}
.email_content h2, table h2 {
  font-size: 22px;
}
.email_content h3, table h3 {
  font-size: 20px;
}
.email_content h4, table h4 {
  font-size: 18px;
}
.email_content h5, table h5 {
  font-size: 16px;
}
.email_content h6, table h6 {
  font-size: 14px;
}
.from {
  font-weight: bold;
  font-size: 12px;
  line-height: 22px;
}
table.content td, table.content p, table.content li {
  font-size: 12px;
  line-height: 22px;
}
hr {
  border: 0;
  background: #e6e6e6;
  height: 2px;
  margin: 8px 0 32px 0;
  display: block;
  float: none;
  clear: both;
}
.view_link, .unsubscribe {
  text-align: center;
  background-color: #002f3e;
}
.view_link, .unsubscribe, .view_link a, .unsubscribe a {
  color: #ffffff;
  font-size: 13px;
  font-weight: normal;
  line-height: 25px;
}
.blauwe_rand, .content_title, .title {
  background: #002f3e;
  color: #ffffff;
}
.blauwe_rand h1, .content_title h1, .title h1, .blauwe_rand h2, .content_title h2, .title h2, .blauwe_rand h3, .content_title h3, .title h3, .blauwe_rand h4, .content_title h4, .title h4, .blauwe_rand h5, .content_title h5, .title h5, .blauwe_rand h6, .content_title h6, .title h6 {
  color: #ffffff;
}
.schaap, .email_content {
  background: #e6e6e6;
}
.email_content {
  padding: 16px 16px 16px 16px;
}
.contact_info {
  padding: 0 16px 16px 16px;
}
.email_content_wit {
  background: #ffffff;
  padding: 16px 16px 16px 16px;
  display: block;
  overflow: hidden;
  clear: both;
  float: none;
}
.email_content_wit img {
  max-width: 100%;
  height: auto;
  margin: 0 0 16px 0;
}
.email_content_wit img.alignleft, .email_content_wit .alignleft img {
  margin: 0 16px 16px 0;
  float: left;
}
.email_content_wit img.alignright, .email_content_wit .alignright img {
  margin: 0 0 16px 16px;
  float: left;
}
.content_width table {
  max-width: 90%;
}
.title {
  padding: 16px 16px 16px 32px;
  background: #004152;
}
.logo {
  padding: 0 16px 0 16px;
  width: 96px;
}
.logo img {
  width: 80px;
  height: 68px;
}
.bottom img {
  vertical-align: bottom;
}
</style>

<!--[if gte mso 9]>

<style type="text/css">

    .content {

    	width:700px;

    }

</style>

<![endif]-->
<!--[if mso]>

<style>

    h1, h2, h3, h4, h5, h6, p, li, td, a  {

      font-family: Arial, sans-serif !important;

    }

</style>

<![endif]-->

</head>
<body style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; color: #002f3e;">
<div class="body_style" data-builder="alternative_color" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; color: #002f3e;"> 
  
  <!--[if gte mso 9]>

	<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">

	<v:fill type="tile" src="" color="#FFFFFF"/>

	</v:background>

	<![endif]-->
  
  <table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #002f3e;">
    <tr>
      <td class="holder" data-builder="bg" valign="top" align="left" background="" style="font-family: Helvetica, Arial, sans-serif; padding: 1.5%;"><table class="container" border="0" align="center" cellpadding="0" cellspacing="0" style="min-width: 100%; color: #002f3e; background-color: #ffffff;">
          <tr>
            <td valign="middle" align="center" class="blauwe_rand" style="font-family: Helvetica, Arial, sans-serif; background: #002f3e; color: #ffffff;"><div class="width" style="width: 100%; max-width: 700px;">
                <table class="content content_title" align="center" border="0" cellspacing="0" cellpadding="10px" style="min-width: 100%; color: #ffffff; background-color: #ffffff; background: #002f3e;">
                  <tr>
                    <td valign="middle" class="view_link" colspan="2" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 25px; background-color: #002f3e; text-align: center; color: #ffffff; font-weight: normal;">Kunt u deze nieuwsbrief niet goed lezen? <a href="{email_url}" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 25px;">Bekijk dan de online versie</a>.</td>
                  </tr>
                  <tr>
                    <td valign="middle" class="branding_html" data-builder="branding_html" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; padding: 16px 16px 16px 32px; line-height: 22px;"><h1 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 24px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; text-transform: uppercase; color: #ffffff; clear: both; display: block; float: none;">Gebruiker Centraal</h1></td>
                    <td class="blauwe_rand logo" width="80" height="68" valign="middle" rowspan="2" style="font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-size: 13px; background: #002f3e; color: #ffffff; padding: 0 16px 0 16px; width: 96px;"><img src="http://www.gebruikercentraal.nl/mailingassets/gebruiker-centraal-logo.jpg" alt="onderste helft van logo Gebruiker centraal" border="0" width="80" style="height: 68px; max-width: 95%; width: 80px;"></td>
                  </tr>
                  <tr>
                    <td class="title" data-builder="title_color" style="color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-weight: bold; text-transform: uppercase; line-height: 22px; font-size: 13px; background: #004152; padding: 16px 16px 16px 32px;"><div data-builder="email_title">
                        <h2 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 22px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; clear: both; display: block; float: none; font-weight: bold; text-transform: uppercase;"><?php echo $theme_gc3_nieuwsbrieftitel ?></h2>
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr>
            <td valign="middle" align="center" style="font-family: Helvetica, Arial, sans-serif;"><div class="width" style="width: 100%; max-width: 700px;">
                <table class="content content_main" align="center" border="0" cellspacing="0" cellpadding="10px" style="min-width: 100%; color: #002f3e; background-color: #ffffff;">

                  <tr>
                    <td class="email_content" data-builder="body_color" style="font-family: Helvetica, Arial, sans-serif; color: #002f3e; line-height: 22px; font-size: 13px; background: #e6e6e6; padding: 16px 16px 16px 16px;"><table data-builder="email_content" class="email_content_wit" style="color: #002f3e; background: #ffffff; clear: both; display: block; float: none; overflow: hidden; padding: 16px 16px 16px 16px;">
                        <tr></tr>
                        <tr>
                          <td style="font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-size: 13px;"><p style="color: #555; line-height: 22px; font-size: 13px; margin-bottom: 0 !important;"><?php echo $theme_gc3_inleiding ?><br>
                            </p>
                            <p style="margin: 0 0 16px 0; padding: 0; -moz-hyphens: auto; -ms-hyphens: auto; -o-hyphens: auto; -webkit-hyphens: auto; hyphens: auto; font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-size: 13px; text-align: right;" data-mce-style="text-align: right;"><em><?php echo $theme_gc3_inleiding_ondertekening ?></em></p>

                          <?php
                                foreach ($posts as $post) {
                                    setup_postdata($post);

                                    
                                    if ( $theme_toon_featuredimage ) {
                                      $image = nt_post_image(get_the_ID(), 'thumbnail');
                                    }
                                    else {
                                      $image = '';
                                    }
                                    
                                    ?>
                            
                            <hr style="background: #e6e6e6; border: 0; clear: both; display: block; float: none; height: 2px; margin: 8px 0 32px 0;">
                            <h1 style="margin: 0 0 16px 0; padding: 0; -moz-hyphens: auto; -ms-hyphens: auto; -o-hyphens: auto; -webkit-hyphens: auto; hyphens: auto; font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-size: 13px;"><a href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" class="head"><?php the_title(); ?></a></h1>
                            <p style="color: #555; line-height: 22px; font-size: 13px; margin-bottom: 0 !important;">

                            <?php
                              if ( $theme_toon_featuredimage ) { 
                              // idealiter is dit plaatje 88px breed
                                if ( $image ) {
                                  // er is een plaatje gevonden
                                  ?>
                                    <a target="_tab" href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" target="_blank"><img src="<?php echo $image; ?>" alt="" width="100" border="0" height="100" style="display: inline; float: left; clear: none; margin-right: 10px;"></a>
                                    <?php 
                                }
                                else {
                                  // er zou een plaatje moeten zijn, maar dat is er niet

                                  }
                              }

                                  ?>
                              
                              <?php rhswp_newsletter_the_excerpt($post); ?><br><a href="<?php echo get_permalink() . $theme_piwiktrackercode; ?>" style="font-size: 11px"><?php echo $theme_options['theme_gc3_read_more']; ?></a></p>

                          <?php
                                }
                                ?>
                            

                        <?php
if (class_exists('EM_Events')) {

  $agendablok = EM_Events::output(
    array(
      'format'      =>  '<h2 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #002f3e; clear: both; display: block; float: none; font-weight: bold; text-transform: uppercase;"><a href="#_EVENTURL" style="text-decoration: none">#_EVENTNAME</a></h2>
      <p><strong>#_EVENTDATES {has_location}(#_LOCATIONTOWN){/has_location}</strong></p><p>#_EVENTEXCERPT<br><strong><a href="#_EVENTURL">' .  $theme_options['theme_gc3_read_more'] . '</a></strong></p><hr style="background: #e6e6e6; border: 0; clear: both; display: block; float: none; height: 2px; margin: 8px 0 32px 0;">',
      'limit'       =>  $filters['theme_gc3_max_agenda'] ) );
  
  
  // tricky dick!
  $agendablok = str_replace( '/">', '/' . $theme_piwiktrackercode  .'">', $agendablok );
  if ( 'Geen Evenementen' != $agendablok ) {

    echo '<hr style="background: #e6e6e6; border: 0; clear: both; display: block; float: none; height: 2px; margin: 8px 0 32px 0;"><h1 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 24px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; text-transform: uppercase; color: #002f3e; clear: both; display: block; float: none;"><span style="color: rgb(51, 153, 102);" data-mce-style="color: #339966;">Agenda</span></h1>';    
    echo $agendablok;
  }

}
else {
  // er staat niks in de agenda
}


?>
                            


                           <hr style="background: #e6e6e6; border: 0; clear: both; display: block; float: none; height: 2px; margin: 8px 0 32px 0;"><h3 style="line-height: 100%; margin: 16px 0 8px 0; padding: 0; font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #002f3e; clear: both; display: block; float: none; font-weight: bold; text-transform: uppercase;">Colofon</h3>
                            <p style="color: #555; line-height: 22px; font-size: 13px; margin-bottom: 0 !important;"><?php echo $theme_gc3_colofon1 ?></p>
                            <p style="color: #555; line-height: 22px; font-size: 13px; margin-bottom: 0 !important;"><?php echo $theme_gc3_colofon_twitter ?></p></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td class="email_content contact_info" data-builder="body_color" style="font-family: Helvetica, Arial, sans-serif; color: #002f3e; line-height: 22px; font-size: 13px; background: #e6e6e6; padding: 0 16px 16px 16px;"><table data-builder="contact_info" class="email_content_wit" style="color: #002f3e; background: #ffffff; clear: both; display: block; float: none; overflow: hidden; padding: 16px 16px 16px 16px;">
                        <tr>
                          <td style="font-family: Helvetica, Arial, sans-serif; line-height: 22px; font-size: 13px;"><?php echo $theme_gc3_colofon_contactinfo ?></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td class="unsubscribe" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 25px; background-color: #002f3e; text-align: center; color: #ffffff; font-weight: normal;"> Wilt u deze nieuwsbrief niet meer ontvangen? <a href="{unsubscription_url}" style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; line-height: 25px;">Meld u dan hier af.</a></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
</body>
</html>
