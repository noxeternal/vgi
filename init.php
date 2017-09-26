<?php

$db = getenv('DBINFO');
$db = json_decode($db);

$db = new mysqli($db->host, $db->user, $db->pass, $db->name);
if($db->connect_error)
  die($db->connect_error);
if($db->error)
  die($db->error);

function esc($s){
  return $GLOBALS['db']->real_escape_string($s);
}

define('baseURL', 'https://www.pricecharting.com/game/');
// define('regex', '/.*<td id="(?P<condition>[a-z]+)_price">\s.*>\s*\$(?P<price>[0-9.]+)\s+<\/span>/');
define('regex', '/.*<td id="(?P<condition>[a-z]+)_price">\s.*>\s*\$*(?P<price>([0-9.]+|N\/A))\s+<\/span>/');


?>