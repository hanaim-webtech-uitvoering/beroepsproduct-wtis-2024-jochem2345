<?php
session_start();
require_once '../functies/layout_functies.php';

maakHtmlHead('Winkelmandje');
maakHeader($_SESSION['rol']);

echo '<h2>Dit is een winkelmandje pagina</h2>';

maakFooter();