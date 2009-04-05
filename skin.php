<?php if (!defined('PmWiki')) exit();
/* PmWiki Skittlish skin
 *
 * Examples at: http://pmwiki.com/Cookbook/DropShadow and http://solidgone.com/Skins/
 * Copyright (c) 2009 David Gilbert
 * Dual licensed under the MIT and GPL licenses:
 *    http://www.opensource.org/licenses/mit-license.php
 *    http://www.gnu.org/licenses/gpl.html
 */
global $FmtPV, $SkinStyle, $PageLogoUrl, $PageLogoWidth, $RecipeInfo, $HTMLStylesFmt;
$FmtPV['$SkinName'] = '"skittlish"';
$FmtPV['$SkinVersion'] = '"0.1.0"';

# Default style
global $SkinStyle;
$ValidSkinStyles = array('fixed', 'fluid');
if ( isset($_GET['style']) && in_array($_GET['style'], $ValidSkinStyles) ) {
	$SkinStyle = $_GET['style'];
} elseif ( !in_array($SkinStyle, $ValidSkinStyles) ) {
	$SkinStyle = 'fixed';
}

if (!empty($PageLogoUrl) && !empty($PageLogoUrlWidth)) {
	$HTMLStylesFmt['skittlish'] = '#header h1 a {padding-left: ' .$PageLogoWidth .'; background: url(' .$PageLogoUrl .') left bottom no-repeat;}';
}

# Move any (:noleft:) or SetTmplDisplay('PageLeftFmt', 0); directives to variables for access in jScript.
$FmtPV['$PageOptions'] = "\$GLOBALS['TmplDisplay']['PageOptionsFmt']";
Markup('nooptions', 'directives',  '/\\(:nooptions:\\)/ei', "SetTmplDisplay('PageOptionsFmt',0)");
$FmtPV['$RightColumn'] = "\$GLOBALS['TmplDisplay']['PageRightFmt']";
Markup('noright', 'directives',  '/\\(:noright:\\)/ei', "SetTmplDisplay('PageRightFmt',0)");
$FmtPV['$SearchBar'] = "\$GLOBALS['TmplDisplay']['PageSearchFmt']";
Markup('nosearch', 'directives',  '/\\(:nosearch:\\)/ei', "SetTmplDisplay('PageSearchFmt',0)");
$FmtPV['$ActionBar'] = "\$GLOBALS['TmplDisplay']['PageActionFmt']";
Markup('noaction', 'directives',  '/\\(:noaction:\\)/ei', "SetTmplDisplay('PageActionFmt',0)");
$FmtPV['$TabsBar'] = "\$GLOBALS['TmplDisplay']['PageTabsFmt']";
Markup('notabs', 'directives',  '/\\(:notabs:\\)/ei', "SetTmplDisplay('PageTabsFmt',0)");

Markup('fieldset', 'inline', '/\\(:fieldset:\\)/i', "<fieldset>");
Markup('fieldsetend', 'inline', '/\\(:fieldsetend:\\)/i', "</fieldset>");

# ----------------------------------------
# - Standard Skin Setup
# ----------------------------------------
$FmtPV['$WikiTitle'] = '$GLOBALS["WikiTitle"]';

# Define a link stye for new page links
global $LinkPageCreateFmt;
SDV($LinkPageCreateFmt, "<a class='createlinktext' href='\$PageUrl?action=edit'>\$LinkText</a>");

# Default color scheme
global $SkinColor, $ValidSkinColors, $skittlish_DefaultStyle;
if ( !is_array($ValidSkinColors) ) $ValidSkinColors = array();
array_push($ValidSkinColors, 'blue', 'cyan', 'green', 'orange', 'pink', 'red', 'violet');

if ( isset($_GET['color']) && in_array($_GET['color'], $ValidSkinColors) ) {
	$SkinColor = $_GET['color'];
} elseif ( !in_array($SkinColor, $ValidSkinColors) ) {
	$SkinColor = 'orange';
}

$skittlish_DefaultStyle=$SkinStyle .' ' .$SkinColor;

# Override pmwiki styles otherwise they will override styles declared in css
global $HTMLStylesFmt;
$HTMLStylesFmt['pmwiki'] = '';

# Add a custom page storage location
global $WikiLibDirs;
$PageStorePath = dirname(__FILE__)."/wikilib.d/{\$FullName}";
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0, array(new PageStore($PageStorePath)));
