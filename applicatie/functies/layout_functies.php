<?php

function maakHtmlHead($titel = 'Pizzeria Sole Machina 🍕') {
    echo <<<HTML
        <!DOCTYPE html>
        <html lang="nl">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$titel</title>
        </head>
        <body>
    HTML;
}

function maakHeader($rol = 'gast') {
    $gebruiker = '';
    $navigatieHtml = '';

    if (isset($_SESSION['voornaam'])) {
        $gebruiker = $_SESSION['voornaam'];
    }

    if ($rol === 'Personnel') {
        $gebruiker = 'medewerker ' . $gebruiker;
        $navigatieHtml = <<<HTML
            <nav>
                <ul>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="bestellingsoverzicht.php">Bestellingsoverzicht</a></li>
                    <li><a href="detailoverzicht.php">Detailoverzicht</a></li>
                    <li><a href="uitloggen.php">Uitloggen</a></li>
                </ul>
            </nav>
        HTML;
    } elseif ($rol === 'Client') {
        $gebruiker = 'klant ' . $gebruiker;
        $navigatieHtml = <<<HTML
            <nav>
                <ul>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="profiel.php">Profiel</a></li>
                    <li><a href="uitloggen.php">Uitloggen</a></li>
                </ul>
            </nav>
        HTML;
    } elseif ($rol === 'gast') {
        $gebruiker = 'gast';
        $navigatieHtml = <<<HTML
            <nav>
                <ul>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="login.php">Inloggen</a></li>
                </ul>
            </nav>
        HTML;
    }

    echo <<<HTML
        <header>
            <h1>Pizzeria Sole Machina 🍕</h1>
            <p>Welkom $gebruiker, bij de beste pizzeria in de stad!</p>
            $navigatieHtml
        </header>
    HTML;
}

function maakFooter() {
    echo <<<HTML
        <footer>
            <p>&copy; 2023 Pizzeria Sole Machina</p>
            <p><a href="privacyverklaring.php">Privacyverklaring</a></p>
        </footer>
        </body>
        </html>
    HTML;
}