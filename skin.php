<?php if (!defined('PmWiki')) exit();
/* PmWiki Skittlish skin
 *
 * Examples at: http://pmwiki.com/Cookbook/Skittlish and http://solidgone.org/Skins/
 * Copyright (c)2016 David Gilbert
 * This work is licensed under a Creative Commons Attribution-Share Alike 4.0 International License.
 * Please retain the links in the footer.
 * http://creativecommons.org/licenses/by-sa/4.0/
 */
global $FmtPV;
$FmtPV['$SkinName'] = '"Skittlish"';
$FmtPV['$SkinVersion'] = '"1.2.1"';
$FmtPV['$SkinDate'] = '"20160225"';

# Default style
global $SkinStyle;
$ValidSkinStyles = array('fixed','fluid');
if ( isset($_GET['style']) && in_array($_GET['style'], $ValidSkinStyles) )
	$SkinStyle = $_GET['style'];
elseif ( !in_array($SkinStyle, $ValidSkinStyles) )
	$SkinStyle = 'fixed';

global $PageLogoUrl, $PageLogoUrlHeight, $PageLogoUrlWidth, $HTMLStylesFmt;
if (!empty($PageLogoUrl)) {
	dg_SetLogoHeightWidth(15);
	$HTMLStylesFmt['skittlish'] .=
		'#siteheader .sitetitle a{height:' .$PageLogoUrlHeight .'; background: url(' .$PageLogoUrl .') left top no-repeat} '.
		'#siteheader .sitetitle a, #siteheader .sitetag{padding-left: ' .$PageLogoUrlWidth .'} '.
		'#siteheader .sitetag{margin-top: ' .(44-substr($PageLogoUrlHeight,0,-2)) .'px}';
}
$SkinColor = dg_SetSkinColor('orange', array('blue','cyan','green','orange','pink','red','violet'));

global $skittlish_DefaultStyle;
$skittlish_DefaultStyle=$SkinStyle .' ' .$SkinColor;

# Move any (:noleft:) or SetTmplDisplay('PageLeftFmt', 0); directives to variables for access in jScript.
$FmtPV['$PageOptions'] = "\$GLOBALS['TmplDisplay']['PageOptionsFmt']";
Markup_e('nooptions', 'directives',  '/\\(:nooptions:\\)/i', "SetTmplDisplay('PageOptionsFmt',0)");

# ----------------------------------------
# - Standard Skin Setup
# ----------------------------------------
$FmtPV['$WikiTitle'] = '$GLOBALS["WikiTitle"]';
$FmtPV['$WikiTag'] = '$GLOBALS["WikiTag"]';

# Move any (:noleft:) or SetTmplDisplay('PageLeftFmt', 0); directives to variables for access in jScript.
$FmtPV['$LeftColumn'] = "\$GLOBALS['TmplDisplay']['PageLeftFmt']";
Markup_e('noleft', 'directives',  '/\\(:noleft:\\)/i', "SetTmplDisplay('PageLeftFmt',0)");
$FmtPV['$RightColumn'] = "\$GLOBALS['TmplDisplay']['PageRightFmt']";
Markup_e('noright', 'directives',  '/\\(:noright:\\)/i', "SetTmplDisplay('PageRightFmt',0)");
$FmtPV['$ActionBar'] = "\$GLOBALS['TmplDisplay']['PageActionFmt']";
Markup_e('noaction', 'directives',  '/\\(:noaction:\\)/i', "SetTmplDisplay('PageActionFmt',0)");
$FmtPV['$TabsBar'] = "\$GLOBALS['TmplDisplay']['PageTabsFmt']";
Markup_e('notabs', 'directives',  '/\\(:notabs:\\)/i', "SetTmplDisplay('PageTabsFmt',0)");
$FmtPV['$SearchBar'] = "\$GLOBALS['TmplDisplay']['PageSearchFmt']";
Markup_e('nosearch', 'directives',  '/\\(:nosearch:\\)/i', "SetTmplDisplay('PageSearchFmt',0)");
$FmtPV['$TitleGroup'] = "\$GLOBALS['TmplDisplay']['PageTitleGroupFmt']";
Markup_e('notitlegroup', 'directives',  '/\\(:notitlegroup:\\)/i', "SetTmplDisplay('PageTitleGroupFmt',0)");
Markup_e('notitle', 'directives',  '/\\(:notitle:\\)/i', "SetTmplDisplay('PageTitleFmt',0); SetTmplDisplay('PageTitleGroupFmt',0)");
Markup('fieldset', 'inline', '/\\(:fieldset:\\)/i', "<fieldset>");
Markup('fieldsetend', 'inline', '/\\(:fieldsetend:\\)/i', "</fieldset>");

# Override pmwiki styles otherwise they will override styles declared in css
global $HTMLStylesFmt;
$HTMLStylesFmt['pmwiki'] = '';

# Add a custom page storage location
global $WikiLibDirs;
$PageStorePath = dirname(__FILE__)."/wikilib.d/{\$FullName}";
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0, array(new PageStore($PageStorePath)));

# ----------------------------------------
# - Standard Skin Functions
# ----------------------------------------
function dg_SetSkinColor($default, $valid_colors){
global $SkinColor, $ValidSkinColors, $_GET;
	if ( !is_array($ValidSkinColors) ) $ValidSkinColors = array();
	$ValidSkinColors = array_merge($ValidSkinColors, $valid_colors);
	if ( isset($_GET['color']) && in_array($_GET['color'], $ValidSkinColors) )
		$SkinColor = $_GET['color'];
	elseif ( !in_array($SkinColor, $ValidSkinColors) )
		$SkinColor = $default;
	return $SkinColor;
}
function dg_PoweredBy(){
	print ('<a href="http://pmwiki.com/'.($GLOBALS['bi_BlogIt_Enabled']?'Cookbook/BlogIt">BlogIt':'">PmWiki').'</a>');
}
# Determine logo height and width
function dg_SetLogoHeightWidth ($wPad, $hPad=0){
global $PageLogoUrl, $PageLogoUrlHeight, $PageLogoUrlWidth;
	if (!isset($PageLogoUrlWidth) || !isset($PageLogoUrlHeight)){
		$size = @getimagesize($PageLogoUrl);
		if (!isset($PageLogoUrlWidth))  SDV($PageLogoUrlWidth, ($size ?$size[0]+$wPad :0) .'px');
		if (!isset($PageLogoUrlHeight))  SDV($PageLogoUrlHeight, ($size ?$size[1]+$hPad :0) .'px');
	}
}
