<?php

  require "config.inc.php";

  $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name; 

  try {
    $connect = new PDO($dsn, $db_username, $db_pass);
  } catch (PDOException $e) {
    $error = $e->getMessage();
    trigger_error($error, E_USER_ERROR);
    die();
  }
?>