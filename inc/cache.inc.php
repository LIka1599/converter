<?php
//cache
require "config.inc.php";
$cacheFile = __DIR__ . '/' . 'cache.txt';

$flag = true; // флаг, что нужна полная обработка


if (file_exists($cacheFile)) {

  $cache = file_get_contents($cacheFile); //
  $cache = unserialize($cache);
  if ($cache && is_array($cache)) {

    $data = $cache[0]; //

    $timecache = $data["Timestamp"]; // дата обновления в ЦБ

    //$timecache = "2022-11-25T11:30:00+03:00";

    $d = date(DATE_ATOM); //текущая дата

    // Процедурный стиль
    $date = date_create_from_format(DATE_ATOM, $d);
    date_sub($date, date_interval_create_from_date_string('1 day')); //текущая дата минус день(обновление на ЦБ раз в день)
    $new_day = date_format($date, DATE_ATOM);

    $flag = ($new_day < $timecache) ? false : true; // если текущая дата меньше даты обновления на ЦБ, то обновлять кэш не нужно.
    // if ($new_day < $timecache) {
    //   $flag = false;
    // }
  }
}

// требуется полная обработка данных
if ($flag) {

  $object = [];

  for ($i = 0; $i < 7; $i++) {

    // Создаём запрос
    $ch = curl_init();
    // Настройки запроса
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Отправка и декодинг ответа
    $data = json_decode(curl_exec($ch), $assoc = true);
    // Закрытие запроса
    curl_close($ch);
    $data["Valute"]["RUB"]["Value"] = 1;
    $data["Valute"]["RUB"]["Nominal"] = 1;
    $data["Valute"]["RUB"]["CharCode"] = "RUB";
    $data["Valute"]["RUB"]["Name"] = "Рубли";

    $object[$i] = $data;

    $url = "https:" . $data["PreviousURL"]; //сменяем урл
  }

  $data = $object[0];

  // сохраняем в кэш
  file_put_contents($cacheFile, serialize($object));
}
