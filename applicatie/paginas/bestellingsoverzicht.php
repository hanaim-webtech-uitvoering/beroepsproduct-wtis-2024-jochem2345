<?php
session_start();
require_once '../functies/layout_functies.php';

maakHtmlHead('Bestellingsoverzicht');
maakHeader($_SESSION['rol']);

echo '<h2>Dit is een bestellingsoverzicht pagina</h2>';

maakFooter();