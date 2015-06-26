<?php
/*
  Include the httpful library
  http://phphttpclient.com/
*/
require('httpful.phar');

// Funções utilitárias
function printLn($theString) {
  echo $theString . '<br>';
}
function miniLoop($theObj, $return_key = false) {
  if ($return_key) {
    foreach ($theObj as $key => $value) {
      return $key;
    }
  } else {
    foreach ($theObj as $value) {
      return $value;
    }
  }
}

/* SEMRUSH API
   http://www.semrush.com/br/api-projects/
*/

// Definições para a URL
$definitions = (object) [
  "today" => date("Ymd"),
  "project_id_desktop" => "678943379902456",
  "project_id_mobile" => "10745",
  "display_limit" => "300",
  "key" => "c4249aa0503e765120994ed75acea252"
];
// Definições para o database (AWS RDS)
$dbConfig = (object) [
  'host' => 'net-reports.cseowh1mvysv.sa-east-1.rds.amazonaws.com',
  'user' => 'netreports',
  'pass' => 'Escale2015',
  'name' => 'net_reports'
];

/*
  Essas URLs tem o objetivo de pegar os seguintes dados para o database:
  - id (int, 11, auto-generated when the row is created)
  - sorting (tinyint, 3)
  - keyword_id (int, 25)
  - keyword (char, 50)
  - tag (char, 50)
  - position (char, 3)
  - position_diff1 (char, 3)
  - position_diff7 (char, 3)
  - position_diff30 (char, 3)
  - position_date (date, YYYYMMDD)
  - created_at (timestamp, auto-generated when the row is created)
  - updated_at (timestamp, auto-generated if the row is modified)
*/
$APIurl = (object) [
  'mobile' => 'http://api.semrush.com/reports/v1/projects/'. $definitions->project_id_mobile .'/tracking/?key='. $definitions->key .'&action=report&type=tracking_position_organic&display_offset=0&url=*.combomultinet.com%2F*&display_filter=-Cp|-Nq|+Ph&display_sort=nq_desc&display_limit='. $definitions->display_limit .'&date_begin='. $definitions->today .'&date_end='. $definitions->today,
  'desktop' => 'http://api.semrush.com/reports/v1/projects/'. $definitions->project_id_desktop .'/tracking/?key='. $definitions->key .'&action=report&type=tracking_position_organic&display_offset=0&url=*.combomultinet.com%2F*&display_filter=-Cp|-Nq|+Ph&display_sort=nq_desc&display_limit='. $definitions->display_limit .'&date_begin='. $definitions->today .'&date_end='. $definitions->today
];

/*
  The response is an object
  {} = object identification
  <> = field in the database

  $response->body->data format for the database above:

  Pi => <keyword_id>
  Ph => <keyword>
  Tg =>
    { x => <tag> }
  Dt =>
    {
      DATE (format: YYYYMMDD) =>
      {
        [*.combomultinet.com/*] => <position>
      }
    }
  Diff =>
    { [*.combomultinet.com/*] => <position_diff1> }
  Diff7 =>
    { [*.combomultinet.com/*] => <position_diff7> }
  Diff30 =>
    { [*.combomultinet.com/*] => <position_diff30> }
*/
$response = \Httpful\Request::get($APIurl->mobile)
    ->expectsType('json')
    ->send();

$db = new PDO('mysql:host='. $dbConfig->host .';dbname='. $dbConfig->name, $dbConfig->user, $dbConfig->pass);
$db->exec("set names utf8");
$stmt = $db->prepare("INSERT INTO semrush_mobile SET sort = ?, keyword_id = ?, keyword = ?, tag = ?, position = ?, position_diff1 = ?, position_diff7 = ?, position_diff30 = ?, position_date = ?");
$dataToAdd = [];
foreach ($response->body->data as $key => $value) {
  // printLn('sort: ' . $key); // sort
  // // printLn(property_exists($value, 'Pi') ? $value->Pi : '');
  // printLn('keyword_id: ' . $value->Pi); // keyword_id
  // printLn('keyword: ' . $value->Ph); // keyword
  // printLn('tag: ' . miniLoop($value->Tg)); // tag
  // printLn('position: ' . miniLoop(miniLoop($value->Dt)));// position
  // printLn('position_diff1: ' . miniLoop($value->Diff1)); // position_diff1
  // printLn('position_diff7: ' . miniLoop($value->Diff7)); // position_diff7
  // printLn('position_diff30: ' . miniLoop($value->Diff30)); // position_diff30
  // printLn('position_date: ' . miniLoop($value->Dt, true));
  $dataToAdd[] = [
    (int) $key,
    $value->Pi,
    $value->Ph,
    miniLoop($value->Tg),
    miniLoop(miniLoop($value->Dt)),
    miniLoop($value->Diff1),
    miniLoop($value->Diff7),
    miniLoop($value->Diff30),
    miniLoop($value->Dt, true)
  ];
}
foreach($dataToAdd as $value) {
  $stmt->execute($value);
}

$response = \Httpful\Request::get($APIurl->desktop)
    ->expectsType('json')
    ->send();

$db = new PDO('mysql:host='. $dbConfig->host .';dbname='. $dbConfig->name, $dbConfig->user, $dbConfig->pass);
$db->exec("set names utf8");
$stmt = $db->prepare("INSERT INTO semrush_desktop SET sort = ?, keyword_id = ?, keyword = ?, tag = ?, position = ?, position_diff1 = ?, position_diff7 = ?, position_diff30 = ?, position_date = ?");
$dataToAdd = [];
foreach ($response->body->data as $key => $value) {
  // printLn('sort: ' . $key); // sort
  // // printLn(property_exists($value, 'Pi') ? $value->Pi : '');
  // printLn('keyword_id: ' . $value->Pi); // keyword_id
  // printLn('keyword: ' . $value->Ph); // keyword
  // printLn('tag: ' . miniLoop($value->Tg)); // tag
  // printLn('position: ' . miniLoop(miniLoop($value->Dt)));// position
  // printLn('position_diff1: ' . miniLoop($value->Diff1)); // position_diff1
  // printLn('position_diff7: ' . miniLoop($value->Diff7)); // position_diff7
  // printLn('position_diff30: ' . miniLoop($value->Diff30)); // position_diff30
  // printLn('position_date: ' . miniLoop($value->Dt, true));
  $dataToAdd[] = [
    (int) $key,
    $value->Pi,
    $value->Ph,
    miniLoop($value->Tg),
    miniLoop(miniLoop($value->Dt)),
    miniLoop($value->Diff1),
    miniLoop($value->Diff7),
    miniLoop($value->Diff30),
    miniLoop($value->Dt, true)
  ];
}
foreach($dataToAdd as $value) {
  $stmt->execute($value);
}




?>
