<?php
require_once '../data/gebruiker_data.php';

function valideerInloggegevens($gebruikersnaam, $wachtwoord) {
    $errors = [];

    if (empty($gebruikersnaam)) {
        $errors[] = 'Gebruikersnaam is verplicht.';
    }

    if (empty($wachtwoord)) {
        $errors[] = 'Wachtwoord is verplicht.';
    }

    if (strlen($gebruikersnaam) < 3 || strlen($gebruikersnaam) > 20) {
        $errors[] = 'Gebruikersnaam moet tussen de 3 en 20 tekens zijn.';
    }

    return $errors;
}

function valideerRegistratiegegevens($gebruikersnaam, $wachtwoord, $bevestig_wachtwoord) {
    $errors = valideerInloggegevens($gebruikersnaam, $wachtwoord);

    if (accountBestaatAl($gebruikersnaam)) {
        $errors[] = 'Gebruikersnaam is al in gebruik.';
    }

    if (strlen($wachtwoord) < 8 || !preg_match('/[A-Z]/', $wachtwoord) || !preg_match('/[0-9]/', $wachtwoord) || !preg_match('/[\W_]/', $wachtwoord)) {
        $errors[] = 'Wachtwoord moet minimaal 8 tekens zijn en één hoofdletter, cijfer en speciaal teken bevatten.';
    }

    if ($wachtwoord != $bevestig_wachtwoord) {
        $errors[] = 'Wachtwoord en bevestigd wachtwoord komen niet overeen.';
    }

    return $errors;
}

function inlogAfhandelen() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $errors = valideerInloggegevens($gebruikersnaam, $wachtwoord);

        if (empty($errors)) {
            $account = haalAccountOp($gebruikersnaam);
            // $wachtwoordKlopt = controleerWachtwoord($gebruikersnaam, $wachtwoord);

            if ($account /*&& $wachtwoordKlopt*/) {
                $_SESSION['gebruikersnaam'] = $account['username'];
                $_SESSION['voornaam'] = $account['first_name'];
                $_SESSION['rol'] = $account['role'];
                header('Location: /paginas/menu.php');
                exit;
            } else {
                $errors[] = 'Ongeldige gebruikersnaam of wachtwoord.';
            }
        }

        return $errors;
    }

}

function registratieAfhandelen() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];
        $bevestig_wachtwoord = $_POST['bevestig_wachtwoord'];
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $adres = $_POST['adres'];
        $rol = $_POST['rol'];

        $errors = valideerRegistratiegegevens($gebruikersnaam, $wachtwoord, $bevestig_wachtwoord);

        if (empty($errors)) {
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

            if (registreerAccount($gebruikersnaam, $hash, $voornaam, $achternaam, $adres, $rol)) {
                header('Location: /paginas/login.php');
                exit;
            } else {
                $errors[] = 'Er is een fout opgetreden bij het registreren.';
            }
        }

        return $errors;
    }
}