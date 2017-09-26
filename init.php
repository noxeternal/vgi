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

?>