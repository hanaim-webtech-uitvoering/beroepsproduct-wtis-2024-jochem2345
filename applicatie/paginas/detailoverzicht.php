<?php
session_start();
require_once '../data/bestelling_data.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';

maakHtmlHead('Detailoverzicht');
maakHeader($_SESSION['rol']);

$bestelnummer = $_GET['bestelnummer'];

$bestellingDetails = haalDetailsVanBestellingOp($bestelnummer);
$detailsHTML = detailsNaarHtml($bestellingDetails);

echo $detailsHTML;

maakFooter();