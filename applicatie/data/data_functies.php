<?php
require_once 'db_connectie.php';

function haalAlleMenuItemsOp() {
  $db = maakVerbinding();

  $query = 'SELECT name, price, type_id FROM Product';

  $data = $db->query($query);

  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function haalBestellingVanClientOp($gebruikersnaam) {
  $db = maakVerbinding();

  $query = "SELECT po.order_id, STRING_AGG(CONCAT(pop.product_name, ' - ', pop.quantity), ', ') AS products, datetime, status FROM Pizza_Order po INNER JOIN Pizza_Order_Product pop on po.order_id = pop.order_id WHERE client_username = :client_username GROUP BY po.order_id, datetime, status ORDER BY datetime DESC";
  $stmt = $db->prepare($query);
  $stmt->execute([':client_username' => $gebruikersnaam]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
