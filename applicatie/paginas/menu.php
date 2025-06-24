<?php 
session_start();
require_once '../data/data_functies.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';

$menu = haalAlleMenuItemsOp();
$menuHtml = menuItemsNaarHtmlTable($menu);

maakHtmlHead('Menu');

if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = 'gast';
}
maakHeader($_SESSION['rol']);

echo $menuHtml;

maakFooter();
