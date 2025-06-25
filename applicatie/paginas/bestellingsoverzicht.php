<?php
session_start();
require_once '../data/bestelling_data.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';

maakHtmlHead('Bestellingsoverzicht');
maakHeader($_SESSION['rol']);

$bestellingen = haalAlleBestellingenOp();
$alleBestellingenHtml = alleBestellingenNaarHtml($bestellingen);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bestelnummer = $_POST["bestelnummer"];
    $nieuweStatus = $_POST["status"];

    statusWijzigen($bestelnummer, $nieuweStatus);
    header("Refresh:0");
}

echo "<h2>Bestellingsoverzicht</h2>" . $alleBestellingenHtml;

maakFooter();