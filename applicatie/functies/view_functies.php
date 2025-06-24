<?php
function menuItemsNaarHtmlTable($menu) {
    $menuHtml = "<table>";

    $menuHtml .= "<tr><th>Naam</th><th>Prijs</th><th>Type</th></tr>";

    foreach ($menu as $item) {
        $naam = $item['name'];
        $prijs = $item['price'];
        $type = $item['type_id'];

        $menuHtml .= "<tr><td>$naam</td><td>$prijs</td><td>$type</td></tr>";
    }

    $menuHtml .= "</table>";

    return $menuHtml;
}

function bestellingenVanClientNaarHtml($bestellingen) {
    $bestellingenHTML = "<table>";

    $bestellingenHTML .= "<tr><th>Bestelnummer</th><th>Datum en tijd</th><th>Status</th><th>Producten met aantal</th></tr>";

    foreach ($bestellingen as $bestelling) {
        $bestelnummer = $bestelling['order_id'];
        $datetime = (new DateTime($bestelling['datetime']))->format('Y-m-d H:i');
        $producten = $bestelling['products'];
        $statusnumber = $bestelling['status'];

        $status = match (true) {
            $statusnumber == 1 => "Bereiden",
            $statusnumber == 2 => "In de oven",
            $statusnumber == 3 => "Klaar",
        };


        $bestellingenHTML .= "<tr><td>$bestelnummer</td><td>$datetime</td><td>$status</td><td>$producten</td></tr>";
    }

    $bestellingenHTML .= "</table>";

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

        $bestellingenHTML .= "<tr><td>$bestelnummer</td><td>$klant</td><td>$datetime</td><td>$status</td><td>$medewerker</td><td>$veranderStatus</td><td>$bekijkDetails</td></tr>";
    }

    $bestellingenHTML .= "</table>";

    return $bestellingenHTML;
}

function detailsNaarHtml($bestelling) {
    $detailsHTML = '';
    
    return $detailsHTML;
}
