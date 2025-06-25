<?php
session_start();
require_once '../data/data_functies.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';
require_once '../functies/winkelmand_functies.php';

$winkelmandHtml = winkelmandNaarHtml();

maakHtmlHead('Winkelmand');
maakHeader($_SESSION['rol']);

$errors = bestellingAfhandelen() ?? '';
annuleerBestelling();
verwijderVanWinkelmand();


?>
<h2>Winkelmand</h2>
<?= 
$winkelmandHtml; 
if ($errors) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
} 
?>
<form method="post" action="">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required>
    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" required>
    <button type="submit">Bestellen</button>
</form>
<form method="post" action="">
    <button type="submit" name="annuleer" value="1">Bestelling annuleren</button>
</form>
<?php
maakFooter();