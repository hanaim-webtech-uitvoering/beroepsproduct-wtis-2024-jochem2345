<?php
require_once 'db_connectie.php';

function haalAlleMenuItemsOp() {
  $db = maakVerbinding();

  $query = "
    SELECT name, price, type_id, STRING_AGG(ingredient_name, ', ') as ingredients 
    FROM Product p 
    LEFT JOIN Product_Ingredient pi ON p.name = pi.product_name 
    GROUP BY name, price, type_id
    ORDER BY type_id
  ";
  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function haalBestellingVanClientOp($gebruikersnaam) {
  $db = maakVerbinding();

  $query = "
    SELECT po.order_id, STRING_AGG(CONCAT(pop.product_name, ' - ', pop.quantity), ', ') AS products, datetime, status, SUM(p.price * pop.quantity) AS costs 
    FROM Pizza_Order po 
    INNER JOIN Pizza_Order_Product pop on po.order_id = pop.order_id 
    INNER JOIN Product p ON pop.product_name = p.name
    WHERE client_username = :client_username 
    GROUP BY po.order_id, datetime, status 
    ORDER BY datetime DESC
  ";
  $stmt = $db->prepare($query);
  $stmt->execute([':client_username' => $gebruikersnaam]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function haalAlleBestellingenOp() {
  $db = maakVerbinding();

  $query = "SELECT order_id, client_name, personnel_username, datetime, status FROM Pizza_Order ORDER BY datetime DESC";
  $stmt = $db->prepare($query);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function haalDetailsVanBestellingOp($bestelnummer) {
  $db = maakVerbinding();

  $query = "
    SELECT po.order_id, STRING_AGG(CONCAT(pop.product_name, ' - ', pop.quantity), ', ') AS products, datetime, status, client_name, personnel_username, client_username, address, SUM(p.price * pop.quantity) AS costs
    FROM Pizza_Order po 
    INNER JOIN Pizza_Order_Product pop on po.order_id = pop.order_id
    INNER JOIN Product p ON pop.product_name = p.name
    WHERE po.order_id = :order_id
    GROUP BY po.order_id, datetime, status, client_name, personnel_username, client_username, address
  ";
  $stmt = $db->prepare($query);
  $stmt->execute([':order_id' =>  $bestelnummer]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function statusWijzigen($bestelnummer, $status) {
  $db = maakVerbinding();

  $query = "UPDATE Pizza_Order SET status = :status WHERE order_id = :order_id";
  $stmt = $db->prepare($query);
  $stmt->execute([
    ':status' => $status, 
    ':order_id' => $bestelnummer
  ]);
}

// function plaatsBestelling