<?
// Конвертируем

$count = $_GET["count"];
$name_from = $_GET["select_from"];
$name_into = $_GET["select_into"];

require "cache.inc.php";

function getValue($data, $name)
{
  $nominal = $data["Valute"][$name]["Nominal"];
  $value = round($data["Valute"][$name]["Value"] / $nominal, 3);
  return $value;
}

function getNewDate($data)
{
  $old_date_timestamp = strtotime($data["Timestamp"]);
  $new_date = date('d.m', $old_date_timestamp);
  return $new_date;
}

$value_from = getValue($data, $name_from);
$value_into = getValue($data, $name_into);

$result = round($count * ($value_from / $value_into), 3);


$url = "https:" . $data["PreviousURL"];

$value_one[0] = $value_from;
$value_two[0] = $value_into;

$period[0] = getNewDate($data);

for ( $i = 1; $i < 7; $i++ ) {

  $data = $cache[$i];

  $value_one[$i] = getValue($data, $name_from);
  $value_two[$i] = getValue($data, $name_into);
  
  $period[$i] = getNewDate($data);

  $url = "https:" . $data["PreviousURL"]; //сменяем урл
}

header('Content-Type: application/json');
$value_two = array_reverse($value_two);
$value_one = array_reverse($value_one);

$period = array_reverse($period);

$res = array(
  'text'  => $result,
  'value_one' => $value_one,
  'value_two' => $value_two,
  'period' => $period,
);

echo json_encode($res);
