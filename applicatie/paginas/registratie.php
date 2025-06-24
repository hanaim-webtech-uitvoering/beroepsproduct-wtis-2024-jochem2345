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
        echo "<p>$error</p>";
    }
} 
?>
<form method="post" action="">
    <input type="hidden" name="rol" value="Client">

    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="gebruikersnaam" required>
    
    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="wachtwoord" required>
    
    <label for="confirm_password">Bevestig wachtwoord:</label>
    <input type="password" id="confirm_password" name="bevestig_wachtwoord" required>
    
    <label for="first_name">Voornaam:</label>
    <input type="text" id="first_name" name="voornaam" required>

    <label for="last_name">Achternaam:</label>
    <input type="text" id="last_name" name="achternaam" required>

    <label for="adress">Adres:</label>
    <input type="text" id="adress" name="adres">

    <button type="submit">Registreren</button>
</form>
<p>Heb je al een account? <a href="/paginas/login.php">Log hier in</a>.</p>
<?php
maakFooter();