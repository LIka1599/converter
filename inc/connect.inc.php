<?
  try {
    $connect = new PDO('mysql:host=localhost;dbname=users', 'root', 'root');
  } catch (PDOException $e) {
    $error = $e->getMessage();
    trigger_error($error, E_USER_ERROR);
    die();
  }
?>