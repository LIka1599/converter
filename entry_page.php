<?
error_reporting(E_ERROR | E_PARSE);
ob_start();
//начало сессии
session_start();

if ($_SESSION['login']) {
  require "inc/cache.inc.php";
  $cookie = $_COOKIE["cookie"]["login"];
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="css/style.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title>Конвертер валют</title>

  </head>

  <body>
    <div class="container pt-5 pb-5">
      <div class="row justify-content-center">
        <div class="">
          <!-- Content -->
          <div class="card p-3">
            <h4 class="h4 welcome">Добро пожаловать, <?= $_COOKIE["cookie"]["login"] ?>
              <a href="index.php" class="form-exit submit" name="exit" value="exit">Выход</a>
            </h4>
            <form id="convert" method="get" onsubmit="return false">
              <h1 class="h2 mb-4">Конвертер валют</h1>
              <div class="row mb-1">
                <div class="col">
                  <label for="name">Отдаю:</label>
                  <select id="select_from" class="form-control" name="select_from">
                    <option disabled>Выберите</option>
                    <?php
                    foreach ($data["Valute"] as $row) {
                      if ($row["CharCode"] == "USD") {
                    ?>
                        <option selected value="<?= $row["CharCode"] ?>"><?= $row["CharCode"] ?> — <?= $row["Name"] ?></option>
                      <?
                      } else {
                      ?>
                        <option value="<?= $row["CharCode"] ?>"><?= $row["CharCode"] ?> — <?= $row["Name"] ?></option>
                    <?
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="name">Получаю:</label>
                  <select id="select_into" class="form-control" name="select_into">
                    <option disabled>Выберите</option>
                    <?php
                    foreach ($data["Valute"] as $row) {
                      if ($row["CharCode"] == "RUB") {
                    ?>
                        <option selected value="<?= $row["CharCode"] ?>"><?= $row["CharCode"] ?> — <?= $row["Name"] ?></option>
                      <?
                      } else {
                      ?>
                        <option value="<?= $row["CharCode"] ?>"><?= $row["CharCode"] ?> — <?= $row["Name"] ?></option>
                    <?
                      }
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="row">
                <div class="col">
                  <input name="count" id="input" type="number" class="form-control" id="name" value="0" />
                </div>
                <div class="col">
                  <div id="result" class="form-control"></div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <input id="converter" type="submit" value="Рассчитать" class="form-control submit" name="go">
                </div>
              </div>
              <div id="container" style="width:100%; height:400px;"></div>
              <?
              require "inc/table.inc.php";
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {

        function test(value_one, value_two, period, select_from, select_into) {
          const chart = Highcharts.chart('container', {
            chart: {
              type: 'line'
            },
            title: {
              text: 'График курса за неделю'
            },
            xAxis: {
              categories: period
            },
            yAxis: {
              title: {
                text: 'Цена относительно рубля'
              }
            },
            series: [{
              name: select_from,
              data: value_one,
            }, {
              name: select_into,
              data: value_two,
            }]
          });
        }
        $('#convert').on("submit", function() {

          // собираем данные с формы
          var count = $('#input').val();
          var select_from = $('#select_from').val();
          var select_into = $('#select_into').val();
          // отправляем данные
          $.ajax({
            url: "/inc/action.php", // куда отправляем
            type: "get", // метод передачи
            dataType: "json", // тип передачи данных
            data: {
              "count": count,
              "select_from": select_from,
              "select_into": select_into,
            },
            // после получения ответа сервера
            success: function(data) {
              $('#result').html(data.text); // выводим ответ сервера
              let value_one = data.value_one;
              let value_two = data.value_two;
              let period = data.period;
              test(value_one, value_two, period, select_from, select_into);
              //console.log(data.usd);
            }
          });
        });
      });
    </script>
  </body>

  </html>
<?
} else header('Location: ' . 'index.php');
