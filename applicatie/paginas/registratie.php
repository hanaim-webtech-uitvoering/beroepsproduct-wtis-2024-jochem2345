<?php
require_once '../functies/layout_functies.php';
require_once '../functies/gebruiker_functies.php';

$errors = registratieAfhandelen() ?? '';

maakHtmlHead('Registratie');
maakHeader();
?>
<h1>Registreer</h1>
<?php 
if ($errors) {
    foreach ($errors as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
} 
?>
<form method="post" action="">
    <input type="hidden" name="rol" value="Client">

    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="gebruikersnaam" required value="<?= isset($_POST['gebruikersnaam']) ? htmlspecialchars($_POST['gebruikersnaam']) : '' ?>">
    
    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="wachtwoord" required>
    
    <label for="confirm_password">Bevestig wachtwoord:</label>
    <input type="password" id="confirm_password" name="bevestig_wachtwoord" required>
    
    <label for="first_name">Voornaam:</label>
    <input type="text" id="first_name" name="voornaam" required value="<?= isset($_POST['voornaam']) ? htmlspecialchars($_POST['voornaam']) : '' ?>">

    <label for="last_name">Achternaam:</label>
    <input type="text" id="last_name" name="achternaam" required value="<?= isset($_POST['achternaam']) ? htmlspecialchars($_POST['achternaam']) : '' ?>">

    <label for="adress">Adres:</label>
    <input type="text" id="adress" name="adres" value="<?= isset($_POST['adres']) ? htmlspecialchars($_POST['adres']) : '' ?>">

    <button type="submit">Registreren</button>
</form>
<p>Heb je al een account? <a href="/paginas/login.php">Log hier in</a>.</p>
<?php
maakFooter();