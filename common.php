<?php

//htmlspecialchars
function h($str, $charset = 'UTF-8') {
  return htmlspecialchars($str, ENT_QUOTES, $charset);
}

//岡山追記
//mb_wordwrap：n文字ごとに改行
function mb_wordwrap($string, $width=75, $break="\n", $cut = false) {
  if (!$cut) {
      $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.',}\b#U';
  } else {
      $regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.'}#';
  }
  $string_length = mb_strlen($string,'UTF-8');
  $cut_length = ceil($string_length / $width);
  $i = 1;
  $return = '';
  while ($i < $cut_length) {
      preg_match($regexp, $string, $matches);
      $new_string = (!$matches ? $string : $matches[0]);
      $return .= $new_string.$break;
      $string = substr($string, strlen($new_string));
      $i++;
  }
  return $return.$string;
}

//閏年の判定
function isLeapYear ($year) {
  return checkdate(2, 29, $year);
}
?>