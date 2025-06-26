<?php 
session_start();
require_once '../data/bestelling_data.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';
require_once '../functies/bestelling_functies.php';

$menu = haalAlleMenuItemsOp();
$menuHtml = menuItemsNaarHtmlTable($menu);

maakHtmlHead('Menu');

if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = 'gast';
}
maakHeader($_SESSION['rol']);

toevoegenAanWinkelmand();

$bestellingGemaakt = '';

if (isset($_SESSION['bestelnummer'])) {
    $bestellingGemaakt = "Bedankt voor uw bestelling, uw bestelnummer is " . $_SESSION['bestelnummer'] . ".";
    unset($_SESSION['bestelnummer']);
}

echo "<h2>Menu</h2>" . $bestellingGemaakt . $menuHtml . "<h3><a href='winkelmand.php'>Naar winkelmand</a></h3>";

maakFooter();
