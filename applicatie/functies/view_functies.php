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
        $datetime = $bestelling['datetime'];
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
