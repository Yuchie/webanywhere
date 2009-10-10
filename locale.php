<?php
// load locale from GET
if (empty($fixed_locale)) {
  $locale = $_REQUEST['locale'];
  if (empty($locale)) {
    if (isset($_COOKIE['userlocale'])) {
      // load locale from cookie
      $locale = $_COOKIE['userlocale'];
    } else {
      // load locale according to HTTP_ACCEPT_LANGUAGE
      preg_match('/^([a-z]+)-*([a-z]*)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
      $locale = $matches[1];
      if (! empty($matches[2])) {
        $locale .= '_' . strtoupper($matches[2]);
      }
    }
  } else {
    // save new locale to cookie
    echo "<meta http-equiv='Set-Cookie' content='userlocale=$locale;expires=Friday, 31-Dec-2099 23:59:59 GMT;'>";    
  }
} else {
  $locale = $fixed_locale;
}

// set PHP locale
$php_locale_file = "locale/$locale/LC_MESSAGES/WebAnywhere.php";
`echo "$php_locale_file" >> /tmp/wa.log`;
if (file_exists($php_locale_file)) {
  include($php_locale_file);
} else {
  function wa_gettext($text) {
      return $text;
  }
}

// set Javascript locale
$js_locale_file = "locale/$locale/LC_MESSAGES/WebAnywhere.js";
if (file_exists($js_locale_file)) {
  echo "<script type='text/javascript' src='$js_locale_file'></script>";
} else {
  echo "<script type='text/javascript'>function wa_gettext(text) { return text; }</script>";
}
?>
