<?php
session_start();
require_once '../data/bestelling_data.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';

$bestellingen = haalBestellingVanClientOp($_SESSION['gebruikersnaam']);
$bestellingenHtml = bestellingenVanClientNaarHtml($bestellingen);

maakHtmlHead('Profiel');
maakHeader($_SESSION['rol']);

$voornaam = $_SESSION['voornaam'];

echo "<h2>Profiel</h2>" . $bestellingenHtml;

maakFooter();