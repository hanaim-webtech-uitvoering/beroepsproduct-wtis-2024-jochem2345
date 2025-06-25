<?php
session_start();
require_once '../data/bestelling_data.php';
require_once '../functies/view_functies.php';
require_once '../functies/layout_functies.php';
require_once '../functies/winkelmand_functies.php';

$winkelmandHtml = winkelmandNaarHtml();

maakHtmlHead('Winkelmand');
maakHeader($_SESSION['rol']);

$messages = bestellingAfhandelen() ?? '';
annuleerBestelling();
verwijderVanWinkelmand();

if (isset($_SESSION['voornaam']) && isset($_SESSION['achternaam'])) {
    $gebruikerNaam = $_SESSION['voornaam'] . ' ' . $_SESSION['achternaam'];
}

?>
<h2>Winkelmand</h2>
<?= 
$winkelmandHtml; 
if ($messages) {
    foreach ($messages as $message) {
        echo "<p>$message</p>";
    }
} 
?>
<form method="post" action="">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($gebruikerNaam ?? '') ?>" required>
    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" value="<?= htmlspecialchars($_SESSION['adres'] ?? '') ?>" required>
    <button type="submit">Bestellen</button>
</form>
<form method="post" action="">
    <button type="submit" name="annuleer" value="1">Bestelling annuleren</button>
</form>
<?php
maakFooter();