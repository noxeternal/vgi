<?php

// error_reporting(E_ALL);
require_once('../../init.php');

function p($s){
  echo '<xmp>',print_r($s, true),'</xmp>';
}


define('baseURL', 'https://www.pricecharting.com/game/');
define('regex', '/.*<td id="(?P<condition>[a-z]+)_price">\s.*>\s*\$(?P<price>[0-9.]+)\s+<\/span>/');

 
function checkLink ($console, $game) {
  $url = baseURL.$console.'/'.$game;
  preg_match_all(regex, file_get_contents($url),$m);

  echo str_pad($console.'/'.$game, 50, ' ', STR_PAD_LEFT), ': ';

  if(count($m['price']) == 3){
    echo implode(' | ', $m['price']);
  }else{
    echo 'Price error';
  }
  echo "\n";
}

$i = 0;

$gamesInventory = $db->query(
  "SELECT `itemID`,`itemLink`,`conLink`,`condText` 
  FROM `item` 
  LEFT JOIN `console` 
    ON(`itemConsole` = `conID`) 
  LEFT JOIN `condition` 
    ON(`itemCond` = `condID`) 
  WHERE `itemLink` != '' ");
if($db->error) die($db->error);

foreach($gamesInventory as $row){
  echo $i,') ';
  $id = $row['itemID'];

  checkLink( $row['conLink'], $row['itemLink']);
  $i++;
}

echo "\nFin.";


?>