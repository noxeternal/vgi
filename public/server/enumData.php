<?php

require_once('../../init.php');

$o = [
  'categories'  => [],
  'consoles'    => [],
  'conditions'  => [],
  'styles'      => [],
  'games'       => []
];

$sql = "SELECT * FROM `category` ORDER BY catText";
$result = $db->query($sql);
foreach($result as $row){
  $o['categories'][] = [
    'id'  => floatval($row['catID']),
    'text'  => $row['catText']
  ];
}

$sql = "SELECT `console`.*,COUNT(`itemID`) AS `conCount` FROM `console` LEFT JOIN `item` ON (`conText` = `itemConsole`) WHERE `item`.`itemDeleted` = 0 GROUP BY `item`.`itemConsole` ORDER BY `console`.`conOrderBy`";
$result = $db->query($sql);
foreach($result as $row){
  $o['consoles'][] = [
    'id'  => floatval($row['conID']),
    'text'  => $row['conText'], 
    'link'  => $row['conLink'],
    'count' => $row['conCount'],
    'order' => floatval($row['conOrderBy'])
  ];
}

$sql = "SELECT * FROM `condition` ORDER BY condText";
$result = $db->query($sql);
foreach($result as $row){
  $o['conditions'][] = [
    'id'  => floatval($row['condID']),
    'text'  => $row['condText']
  ];
}

$sql = "SELECT * FROM `style` ORDER BY styleName";
$result = $db->query($sql);
foreach($result as $row){
  $o['styles'][] = [
    'id'  => floatval($row['styleID']),
    'name'  => $row['styleName'],
    'text'  => $row['styleText']
  ];
}


$sql = "SELECT * FROM item WHERE itemDeleted = 0 ORDER BY itemName";
$result = $db->query($sql);
foreach($result as $row){
  $o['games'][] = [
    'id'        => floatval($row['itemID']),
    'name'      => $row['itemName'],
    'link'      => $row['itemLink'],
    'console'   => ($row['itemConsole']),
    'category'  => ($row['itemCat']),
    'condition' => ($row['itemCond']),
    'box'       => floatval($row['itemBox']),
    'manual'    => floatval($row['itemManual']),
    'style'     => ($row['itemStyle'])
  ];
}

$sql = "SELECT valID,itemID,valAmount,MAX(valLastCheck) as valLastCheck FROM value LEFT JOIN item USING(itemID) WHERE item.itemDeleted = 0 GROUP BY itemID";
$result = $db->query($sql);
foreach($result as $row){
  $o['values'][] = [
    'id'        => floatval($row['valID']),
    'item'      => floatval($row['itemID']),
    'value'     => floatval($row['valAmount']),
    'lastCheck' => $row['valLastCheck']
  ];
}

$sql = "SELECT * FROM extra";
$result = $db->query($sql);
foreach($result as $row){
  $o['extras'][] = [
    'id'   => floatval($row['extraID']),
    'item' => floatval($row['itemID']),
    'text' => $row['extraText']
  ];
}

// echo json_encode($thisItem, JSON_PRETTY_PRINT);
header('Content-type:application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($o, JSON_PRETTY_PRINT);

?>