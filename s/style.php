<?

// body
$style = 'body {';
$style.= 'background:#'.(($R->profile_background_color)? $R->profile_background_color : '070707').' ';
$style.= ($R->profile_background_image_url)? 'url('.$R->profile_background_image_url.') ' : '';
$style.= ($R->profile_background_tile)? ' ' : 'no-repeat ';
$style.= '; color:#'.(($R->profile_text_color)? $R->profile_text_color : '999999').'; ';
$style.= '}';

// a
$style.= 'a { color:#'.(($R->profile_link_color)? $R->profile_link_color : '369aa9').'; }';

// avatar, maker
$style.= '#avatar, #maker {';
$style.= 'background:#'.(($R->profile_sidebar_fill_color)? $R->profile_sidebar_fill_color : '000000').';';
$style.= 'border:7px solid #'.(($R->profile_sidebar_border_color)? $R->profile_sidebar_border_color : '0A0A0A').';';
$style.= '}';

// help
$style.= '#help {';
$style.= 'background:#'.(($R->profile_sidebar_fill_color)? $R->profile_sidebar_fill_color : '').';';
$style.= '}';

?>
