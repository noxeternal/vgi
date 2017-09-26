<?php

// error_reporting(E_ALL);
require_once('../../init.php');

function p($s){
  echo '<xmp>',print_r($s, true),'</xmp>';
}


class priceGuide{
  public  $game,
          $console,
          $condition;

  function __construct($game, $console, $condition){
    $this->game = $game;
    $this->console = $console;
    $this->condition = $condition;
  }
  
  function getPrice($format = 'json'){
    return $this->getAllPrices()[$this->condition];
  }

  function getAllPrices(){
    $url = baseURL.$this->console.'/'.$this->game;

    preg_match_all(regex, file_get_contents($url),$m);

    // p($m);

    if(count($m['price']) == 3){
      for($i=0;$i<3;$i++){
        $o[$m['condition'][$i]] = (float)$m['price'][$i];
      }
      return $o;
    }else{
      echo 'Price error for ',$url,"\n";
    }

  }
}

$i = 0;

$gamesInventory = $db->query(
  "SELECT `itemID`,`itemLink`,`conLink`,`condText` 
  FROM `item` 
  LEFT JOIN `console` 
    ON(`itemConsole` = `conID`) 
  LEFT JOIN `condition` 
    ON(`itemCond` = `condID`) 
  WHERE itemLink != ''
    AND itemDeleted = 0");
if($db->error) die($db->error);

foreach($gamesInventory as $row){
  echo $i,"\n";
  $id = $row['itemID'];

  $c[$id] = new priceGuide($row['itemLink'], $row['conLink'], $row['condText']);
  $price = $c[$id]->getPrice();

  if($price){
    $sql = "INSERT INTO value (itemID,valAmount) VALUES ({$id},{$price})";
    echo $sql,"\n";
    $db->query($sql);
    if($db->error) die($db->error);
  }else{
    echo 'Price not found for item ',$id,"\n";
  }

  $i++;
  // if($i%10 == 0) echo '+';
  echo "\n";
}

echo "\nFin.";


?>