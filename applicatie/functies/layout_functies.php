<?php

function maakHtmlHead($titel = 'Pizzeria Sole Machina 🍕', $styling = '') {
    $style = "<style>";

    $style .= <<<CSS
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    CSS;

    $style .= $styling;

    $style .= "</style>";




    echo <<<HTML
        <!DOCTYPE html>
        <html lang="nl">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$titel</title>
        $style
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

    switch ($rol) {
        case 'Personnel':
            $gebruiker = 'medewerker ' . $gebruiker;
            $navigatieHtml = <<<HTML
                <nav>
                    <ul>
                        <li><a href="menu.php">Menu</a></li>
                        <li><a href="profiel.php">Profiel</a></li>
                        <li><a href="bestellingsoverzicht.php">Bestellingsoverzicht</a></li>
                        <li><a href="uitloggen.php">Uitloggen</a></li>
                    </ul>
                </nav>
            HTML;
            break;

        case 'Client':
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
            break;

        case 'gast':
            $gebruiker = 'gast';
            $navigatieHtml = <<<HTML
                <nav>
                    <ul>
                        <li><a href="menu.php">Menu</a></li>
                        <li><a href="login.php">Inloggen</a></li>
                    </ul>
                </nav>
            HTML;
            break;
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

function controleerRol($rol) {
    if ($_SESSION['rol'] !== $rol) {
        header("Location: menu.php");
    }
}