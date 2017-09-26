<?php

// error_reporting(E_ALL);
require_once('../../init.php');

function p($s){
  echo '<xmp>',print_r($s, true),'</xmp>';
}

function m($a){
  return str_pad($a, 7, ' ', STR_PAD_LEFT);
}

define('baseURL', 'https://www.pricecharting.com/game/');
define('regex', '/.*<td id="(?P<condition>[a-z]+)_price">\s.*>\s*\$(?P<price>[0-9.]+)\s+<\/span>/');

 
function checkLink ($console, $game) {
  $url = baseURL.$console.'/'.$game;
  preg_match_all(regex, file_get_contents($url),$m);

  echo str_pad($console.'/'.$game, 60, ' ', STR_PAD_LEFT), ': ';

  if(count($m['price']) == 3){
    foreach($m['price'] as $i => $p)
      $m['price'][$i] = m($p);
    echo implode(' | ', $m['price']);
  }else{
    echo '<a href="',$url,'" target="_game">Price error</a>';
  }
  echo "\n";
}

$i = 0;

$gamesInventory = $db->query(
  "SELECT `itemID`,`itemLink`,`conLink`
  FROM `item` 
  LEFT JOIN `console` 
    ON(`itemConsole` = `conID`) 
  WHERE `itemLink` != '' ");
if($db->error) die($db->error);

foreach($gamesInventory as $row){
  echo str_pad($i, 4, ' ', STR_PAD_LEFT),') ';
  $id = $row['itemID'];

  checkLink( $row['conLink'], $row['itemLink']);
  $i++;
}

echo "\nFin.";


?>