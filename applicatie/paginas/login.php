<?php
session_start();
require_once '../functies/layout_functies.php';
require_once '../functies/gebruiker_functies.php';

$errors = inlogAfhandelen() ?? '';

maakHtmlHead('Login');
maakHeader();
?>
<h1>Login</h1>
<?php 
if ($errors) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
} 
?>
<form method="post" action="">
    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="gebruikersnaam" required>
    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="wachtwoord" required>
    <button type="submit">Inloggen</button>
</form>
<p>Heb je nog geen account? <a href="/paginas/registratie.php">Registreer hier</a>.</p>
<?php
maakFooter();