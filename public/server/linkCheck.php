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

  echo str_pad($console.'/'.$game, 60, ' ', STR_PAD_RIGHT);

  if(count($m['price']) == 3){
    foreach($m['price'] as $i => $p)
      $prices[$i] = m($p);
    echo implode(' | ', $prices);
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
  WHERE `itemLink` != '' 
  ORDER BY `conID`");
if($db->error) die($db->error);

echo "<html>\n<head>\n<title>LinkCheck</title>\n</head>\n<body style=\"white-space:pre;font-family:monospace;\">\n";

foreach($gamesInventory as $row){
  echo str_pad($i, 4, ' ', STR_PAD_LEFT),') ';
  $id = $row['itemID'];

  checkLink( $row['conLink'], $row['itemLink']);
  $i++;
}

echo "\nFin.\n</body></html>";


?>