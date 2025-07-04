<?php

use Dom\HTMLElement;

function menuItemsNaarHtmlTable($menu) {
    $menuHtml = "<table>";

    $menuHtml .= "<tr><th>Naam</th><th>Prijs</th><th>Type</th><th>Ingrediënten</th><th>Toevoegen</th></tr>";

    foreach ($menu as $item) {
        $naam = $item['name'];
        $prijs = $item['price'];
        $type = $item['type_id'];
        $ingredienten = $item['ingredients'];

        $menuHtml .= "<tr><td>" . htmlspecialchars($naam) . "</td><td>" . htmlspecialchars($prijs) . "</td><td>" . htmlspecialchars($type) . "</td><td>" . htmlspecialchars($ingredienten ?? '') . "</td>";

        $menuHtml .= "
                <td>
                    <form action='' method='POST' style='display:inline;'>
                        <input type='hidden' name='product' value='" . htmlspecialchars($naam) . "'>
                        <input type='hidden' name='prijs' value='" . htmlspecialchars($prijs) . "'>
                        <button type='submit' name='toevoegen'>Toevoegen aan winkelmand</button>
                    </form>
                </td>
            </tr>
        ";
    }

    $menuHtml .= "</table>";

    return $menuHtml;
}

function winkelmandNaarHtml() {
    $totaleKosten = 0;


    if (isset($_SESSION['winkelmand'])) {
        $winkelmandHTML = "<table>";

        $winkelmandHTML .= "<tr><th>Product</th><th>Aantal</th><th>Kosten</th><th>Verwijderen</th></tr>";

        foreach ($_SESSION['winkelmand'] as $item => $waarde) {
            $aantal = $waarde['aantal'];
            $prijs = $waarde['prijs'];
            $totaleKosten += $prijs;
            $individuelePrijs = $prijs / $aantal;

            $winkelmandHTML .= "<tr><td>" . htmlspecialchars($item) . "</td><td>" . htmlspecialchars($aantal) . "</td><td>&euro;" . number_format($prijs, 2) . "</td>";

            $winkelmandHTML .= "
                    <td>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='product' value='" . htmlspecialchars($item) . "'>
                            <input type='hidden' name='prijs' value='" . htmlspecialchars($individuelePrijs) . "'>
                            <button type='submit' name='toevoegen'>Verwijder van winkelmand</button>
                        </form>
                    </td>
                </tr>
            ";
        }

        $winkelmandHTML .= "</table>";
    } else {
        $winkelmandHTML = "<a href='menu.php'>Winkelmand is leeg, ga naar het menu om producten toe te voegen.</a>";
    }


    $winkelmandHTML .= "<p><strong>Totale kosten:</strong> &euro;" . number_format($totaleKosten, 2, ',', '.') . "</p>";

    return $winkelmandHTML;
}

function bestellingenVanClientNaarHtml($bestellingen) {
    if (!empty($bestellingen)) {
        $bestellingenHTML = "<table>";

        $bestellingenHTML .= "<tr><th>Bestelnummer</th><th>Datum en tijd</th><th>Status</th><th>Producten met aantal</th><th>Kosten</th></tr>";

        foreach ($bestellingen as $bestelling) {
            $bestelnummer = $bestelling['order_id'];
            $datetime = (new DateTime($bestelling['datetime']))->format('Y-m-d H:i');
            $producten = $bestelling['products'];
            $kosten = $bestelling['costs'];
            $statusnumber = $bestelling['status'];

            $status = match (true) {
                $statusnumber == 1 => "Bereiden",
                $statusnumber == 2 => "In de oven",
                $statusnumber == 3 => "Klaar",
            };


            $bestellingenHTML .= "<tr>
                <td>" . htmlspecialchars($bestelnummer) . "</td>
                <td>" . htmlspecialchars($datetime) . "</td>
                <td>" . htmlspecialchars($status) . "</td>
                <td>" . htmlspecialchars($producten) . "</td>
                <td>&euro;" . htmlspecialchars($kosten) . "</td>
            </tr>";
        }

        $bestellingenHTML .= "</table>";
    } else {
        $bestellingenHTML = "<p>U heeft nog geen bestellingen gemaakt.</p>";
    }

    return $bestellingenHTML;
}

function alleBestellingenNaarHtml($bestellingen) {
    $bestellingenHTML = "<table>";

    $bestellingenHTML .= "<tr><th>Bestelnummer</th><th>Klant</th><th>Datum en tijd</th><th>Status</th><th>Medewerker</th><th>Verander status</th><th>Bekijk details</th></tr>";

    foreach ($bestellingen as $bestelling) {
        $bestelnummer = $bestelling['order_id'];
        $klant = $bestelling['client_name'];
        $datetime = (new DateTime($bestelling['datetime']))->format('Y-m-d H:i');
        $medewerker = $bestelling['personnel_username'];
        $statusnumber = $bestelling['status'];

        $status = match (true) {
            $statusnumber == 1 => "Bereiden",
            $statusnumber == 2 => "In de oven",
            $statusnumber == 3 => "Klaar",
        };

        $selected1 = $statusnumber == 1 ? 'selected' : '';
        $selected2 = $statusnumber == 2 ? 'selected' : '';
        $selected3 = $statusnumber == 3 ? 'selected' : '';

        $veranderStatus = <<<HTML
            <form action='' method='POST' style='display:inline;'>
                <input type='hidden' name='bestelnummer' value='{$bestelnummer}'>
                <select name='status'>
                    <option value='1' $selected1>Bereiden</option>
                    <option value='2' $selected2>In de oven</option>
                    <option value='3' $selected3>Klaar</option>
                </select>
                <button type='submit' name='bijgewerkte_status'>Bijwerken</button>
            </form>
        HTML;

        $bekijkDetails = "<a href='detailoverzicht.php?bestelnummer=$bestelnummer'>Bekijk details</a>";

        $bestellingenHTML .= "<tr>
            <td>" . htmlspecialchars($bestelnummer) . "</td>
            <td>" . htmlspecialchars($klant) . "</td>
            <td>" . htmlspecialchars($datetime) . "</td>
            <td>" . htmlspecialchars($status) . "</td>
            <td>" . htmlspecialchars($medewerker) . "</td>
            <td>$veranderStatus</td>
            <td>$bekijkDetails</td>
        </tr>";
    }

    $bestellingenHTML .= "</table>";

    return $bestellingenHTML;
}

function detailsNaarHtml($bestelling) {
    $bestelnummer = $bestelling[0]['order_id'];
    $klant = $bestelling[0]['client_name'];
    $klantgb = $bestelling[0]['client_username'];
    if (!$klantgb) {
        $klantgb = 'Geen';
    }
    $datetime = (new DateTime($bestelling[0]['datetime']))->format('Y-m-d H:i');
    $medewerker = $bestelling[0]['personnel_username'];
    $producten = $bestelling[0]['products'];
    $kosten = $bestelling[0]['costs'];
    $adres = $bestelling[0]['address'];
    
    $statusnumber = $bestelling[0]['status'];
    $status = match (true) {
        $statusnumber == 1 => "Bereiden",
        $statusnumber == 2 => "In de oven",
        $statusnumber == 3 => "Klaar",
        default => "Onbekend",
    };

    $productenArray = array_map('trim', explode(',', $producten)); // ["Coca Cola - 3", "Margherita Pizza - 2"]

    $productenGesplitst = [];
    foreach ($productenArray as $product) {
        $delen = explode(' - ', $product);
        if (count($delen) === 2) {
            $productenGesplitst[] = [
                'naam' => $delen[0],
                'aantal' => $delen[1],
            ];
        }
    }

    $html = "<h2>Detailoverzicht van bestelling " . htmlspecialchars($bestelnummer) . "</h2>";

    $html .= "<p><strong>Klantnaam:</strong> " . htmlspecialchars($klant) . "</p>";
    $html .= "<p><strong>Gebruikersnaam:</strong> " . htmlspecialchars($klantgb) . "</p>";
    $html .= "<p><strong>Medewerker:</strong> " . htmlspecialchars($medewerker) . "</p>";
    $html .= "<p><strong>Datum & Tijd:</strong> " . htmlspecialchars($datetime) . "</p>";
    $html .= "<p><strong>Status:</strong> " . htmlspecialchars($status) . "</p>";
    $html .= "<p><strong>Adres:</strong> " . htmlspecialchars($adres) . "</p>";
    $html .= "<p><strong>Totale kosten:</strong> &euro;" . number_format($kosten, 2, ',', '.') . "</p>";

    $html .= "<h3>Bestelde producten</h3>";
    $html .= "<table>";
    $html .= "<thead><tr><th>Productnaam</th><th>Aantal</th></tr></thead>";
    $html .= "<tbody>";

    foreach ($productenGesplitst as $product) {
        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($product['naam']) . "</td>";
        $html .= "<td>" . htmlspecialchars($product['aantal']) . "</td>";
        $html .= "</tr>";
    }

    $html .= "</tbody></table>";

    return $html;
}

