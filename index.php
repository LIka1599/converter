<?php
  ob_start();
  error_reporting(E_ERROR | E_PARSE);
  
  require "inc/connect.inc.php";
  require "inc/login.inc.php";
  require "inc/cache.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="css/style.css" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
  <title>Конвертер валют</title>

</head>

<body>
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="">
        <!-- Content -->
        <div class="card p-3">
          <form method="post">
            <h1 class="h3 mb-4">Войдите или зарегистрируйтесь, если хотите получить доступ к конвертатору валют</h1>
            <div class="row w-50">
              <div class="col">
                <input class="form-control login" type="text" placeholder="Введите логин" name="login">
                <?= $error['login'] ?>
                <input class="form-control login"  type="password" placeholder="Введите пароль" name="pass">
                <?= $error['pass'] ?>
                <?= $error['entry'] ?>
              </div>
            </div>
            <div class="row w-50">
              <div class="col">
                <button class="form-control submit" type="submit" name="reg" value="reg">Регистрация</button>
              </div>
              <div class="col">
                <button class="form-control submit" type="submit" name="entry" value="entry">Вход</button>
              </div>
              
            </div>
          </form>
          <?php
          require "inc/table.inc.php";
          ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>