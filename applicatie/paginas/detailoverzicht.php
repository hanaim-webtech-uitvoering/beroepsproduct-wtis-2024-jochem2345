<?php
session_start();
require_once '../functies/layout_functies.php';

maakHtmlHead('Detailoverzicht');
maakHeader($_SESSION['rol']);

$bestellingNummer = '';

echo "<h2>Detailoverzicht van bestelling $bestellingNummer</h2>";
?>
<h2>Detailoverzicht van bestelling</h2>
<?php
maakFooter();