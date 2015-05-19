<?php

require_once('Smarty/libs/Smarty.class.php');
include('MyFunctions.inc.php');

$hostgroups = get_all_hostgroups();
$app_version=get_version();

$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';

$smarty->assign('SKM_GLPI',$SKM_GLPI);
$smarty->assign("menu_hostgrps",$hostgroups);
$smarty->assign("app_version",$app_version);

?> 
