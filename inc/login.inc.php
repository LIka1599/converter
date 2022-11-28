<?php

function myError($no, $msg, $file, $line)
{
  if ($no == E_USER_ERROR) {
    echo "Что-то пошло не так..";
    $s = "$msg в $file: $line \n";
    error_log($s, 3, "error.log");
  }
}
set_error_handler("myError");

function checkLogin($login, $connect)
{  
  $sql = "SELECT * FROM users WHERE login = ? ";

  $query = $connect->prepare($sql);
  $params = [$login];
  $query->execute($params);
  //$data = $query->fetchAll();

  if ($query->fetchAll()) {
    return false;
  } else {
    return true;
  }
}

function addToDataBase($login, $pass, $connect)
{
  $sql = "INSERT INTO users (login, pass) VALUES (:login, :pass)";

  $query = $connect->prepare($sql);
  $params = ['login' => $login, 'pass' => $pass];
  $result = $query->execute($params);
  if ($result) {
    return true;
  } else {
    return false;
  }
}

function checkWithDataBase($login, $pass, $connect)
{
  $sql = "SELECT * FROM users WHERE pass = ? AND login = ? ";

  $query = $connect->prepare($sql);
  $params = [$pass, $login];
  $query->execute($params);
  //$data = $query->fetchAll();

  if ($query->fetchAll()) {
    return true;
  } else {
    return false;
  }
}

function clearData($value)
{
  $value = trim($value);
  $value = stripslashes($value);
  $value = strip_tags($value);
  $value = htmlspecialchars($value);
  return $value;
}

$login = clearData($_POST['login']);

$pass = clearData($_POST['pass']);

$error = [];
$flag_bd = 0;
$flag = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (strlen($login) < 3 || empty($login)) {
    $error['login'] = '<div class="form__input-error" id = "error-login">Логин слишком короткий</div>';
    $flag = 1;
  }

  if (strlen($pass) < 5 || empty($pass)) {
    $error['pass'] = '<div class="form__input-error" id = "error-pass">Пароль слишком короткий</div>';
    $flag = 1;
  }


  if ($flag == 0) {
    if ($_POST['reg']) {
      $check = checkLogin($login, $connect);
      if (!$check) {
        $error['login'] = '<div class="form__input-error" id = "error-login">Пользователь с таким логином уже загеристрирован, авторийзуйтесь или выберите другой логин.</div>';
        $flag_bd = 1;
      } else {
        $result = addToDataBase($login, $pass, $connect);
        if (!$result) {
          $error['entry'] = '<div class="form__input-error" id ="error-entry">Что-то пошло не так</div>';
          $flag_bd = 1;
        }
      }
    }

    if ($_POST['entry']) {
      $result = checkWithDataBase($login, $pass, $connect);
      if (!$result) {
        $error['entry'] = '<div class="form__input-error" id ="error-entry">Неправильно введен логин или пароль</div>';
        $flag_bd = 1;
      }
    }

    if ($flag_bd == 0) {
      session_start();
      $_SESSION['login']  = true;
      setcookie("cookie[login]", $login);
      $new_url = 'entry_page.php';
      header('Location: ' . $new_url);
    }

  }
}
