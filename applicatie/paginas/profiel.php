<?php
session_start();
require_once '../functies/layout_functies.php';

maakHtmlHead('Profiel');
maakHeader($_SESSION['rol']);

echo '<h2>Dit is een profiel pagina</h2>';

maakFooter();