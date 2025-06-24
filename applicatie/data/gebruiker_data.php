<?php
require_once 'db_connectie.php';

function haalAccountOp($gebruikersnaam) {
  $db = maakVerbinding();

  $query = 'SELECT username, first_name, last_name, address, role FROM "User" WHERE username = :username';
  $stmt = $db->prepare($query);
  $stmt->execute([':username' => $gebruikersnaam]);

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function registreerAccount($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $adres, $rol) {
  $db = maakVerbinding();

  if ($adres === '') {
      $adres = null;
  }

  $query = 'INSERT INTO "User" (username, password, first_name, last_name, address, role) VALUES (:username, :password, :first_name, :last_name, :address, :role)';
  $stmt = $db->prepare($query);
  
  return $stmt->execute([
    ':username' => $gebruikersnaam,
    ':password' => $wachtwoord,
    ':first_name' => $voornaam,
    ':last_name' => $achternaam,
    ':address' => $adres,
    ':role' => $rol
  ]);
}

function accountBestaatAl($gebruikersnaam) {
  $db = maakVerbinding();

  $query = 'SELECT COUNT(*) FROM "User" WHERE username = :username';
  $stmt = $db->prepare($query);
  $stmt->execute([':username' => $gebruikersnaam]);

  return $stmt->fetchColumn() > 0;
}

function controleerWachtwoord($gebruikersnaam, $wachtwoord) {
  $db = maakVerbinding();

  $query = 'SELECT password FROM "User" WHERE username = :username';
  $stmt = $db->prepare($query);
  $stmt->execute([':username' => $gebruikersnaam]);

  if ($account = $stmt->fetch()) {
    $hash = $account['password'];

    if (password_verify($wachtwoord, $hash)) {
      return true;
    } else {
      return false;
    }
  }
}