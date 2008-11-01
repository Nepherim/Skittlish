<?php if (!defined('PmWiki')) exit();
/*
 * PmWiki IBM-Fr-Full
 * @requires PmWiki 2.2
 *
 * Copyright (c) 2007 David Gilbert
 */

global $FmtPV;
$FmtPV['$SkinName'] = '"skittlish"';
$FmtPV['$SkinVersion'] = '"0.0.1"';

## Add a custom page storage location
global $PageStorePath, $WikiLibDirs;
$PageStorePath = dirname(__FILE__)."/wikilib.d/{\$FullName}";
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0, array(new PageStore($PageStorePath)));

## Override pmwiki styles otherwise they will override styles declared in css
global $HTMLStylesFmt;
$HTMLStylesFmt['pmwiki'] = '';

## Define a link stye for new page links
global $LinkPageCreateFmt;
SDV($LinkPageCreateFmt, "<a class='createlinktext' href='\$PageUrl?action=edit'>\$LinkText</a>");

## Create a nosearch markup, since one doesn't exist
Markup('nosearch', 'directives',  '/\\(:nosearch:\\)/ei',
		"SetTmplDisplay('PageSearchFmt',0)");
