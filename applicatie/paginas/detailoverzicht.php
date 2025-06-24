<?php
session_start();
require_once '../functies/layout_functies.php';

maakHtmlHead('Detailoverzicht');
maakHeader($_SESSION['rol']);

echo '<h2>Dit is een detailoverzicht pagina</h2>';

maakFooter();