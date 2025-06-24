<?php
require_once 'db_connectie.php';

function haalAlleMenuItemsOp() {
  $db = maakVerbinding();

  $query = 'SELECT name, price, type_id FROM Product';

  $data = $db->query($query);

  return $data->fetchAll(PDO::FETCH_ASSOC);
}
