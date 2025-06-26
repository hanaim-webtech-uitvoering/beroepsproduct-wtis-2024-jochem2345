<?php
require_once '../data/bestelling_data.php';

function toevoegenAanWinkelmand() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product']) && isset($_POST['prijs'])) {
        $product = $_POST['product'];
        $prijs = $_POST['prijs'];
    
        if (!isset($_SESSION['winkelmand'])) {
            $_SESSION['winkelmand'] = [];
        }
    
        if (isset($_SESSION['winkelmand'][$product])) {
            $_SESSION['winkelmand'][$product]['aantal'] ++;
            $_SESSION['winkelmand'][$product]['prijs'] += $prijs;
        } else {
            $_SESSION['winkelmand'][$product] = [
                'aantal' => 1,
                'prijs' => $prijs
            ];
        }
    }
}

function bestellingAfhandelen() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['naam']) && isset($_POST['adres'])) {
        $naam = $_POST['naam'];
        $adres = $_POST['adres'];
        $errors = [];

        if (isset($_SESSION['winkelmand'])) {
            $_SESSION['bestelnummer'] = plaatsBestelling($naam, $adres);
            unset($_SESSION['winkelmand']);
            header("Location: menu.php");
            exit();
        } else {
            $errors[] = 'Je kan geen bestelling maken zonder producten.';
        }

        return $errors;
    }
}

function annuleerBestelling() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['annuleer'])) {
        unset($_SESSION['winkelmand']);
        header('Location: menu.php');
        exit();
    }
}

function verwijderVanWinkelmand() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
        $product = $_POST['product'];
        $prijs = $_POST['prijs'];

        if ($_SESSION['winkelmand'][$product]['aantal'] > 1) {
            $_SESSION['winkelmand'][$product]['aantal'] --;
            $_SESSION['winkelmand'][$product]['prijs'] -= $prijs;
        } else {
            unset($_SESSION['winkelmand'][$product]);
        }

        if (empty($_SESSION['winkelmand'])) {
            unset($_SESSION['winkelmand']);
        }

        header("Refresh:0");
    }
}