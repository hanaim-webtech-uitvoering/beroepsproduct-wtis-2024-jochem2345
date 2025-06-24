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
