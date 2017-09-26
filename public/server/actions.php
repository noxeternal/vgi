<? 
fail(0,'Currently disabled'); die();

// header('Access-Control-Allow-Origin: http://192.168.0.116');
// header('Access-Control-Allow-Headers: Content-type');

// if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
//   http_response_code(200);
//   exit;
// }

function success($result){
  header('content-type: application/json');
  die(json_encode([
    'success' =>  true,
    'result'  =>  $result,
    'error'   =>  null
  ]));
}

function fail($code,$msg,$data=null){
  header('content-type: application/json');
  die(json_encode([
    'success' =>  false,
    'result'  =>  null,
    'error'   =>  [
      'code'  =>  $code,
      'msg' =>  $msg,
      'data'  =>  $data
    ]
  ]));
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);


require_once('../../init.php');

$map = [
  // 'id'   => 'itemID',
  'name'    => 'itemName',
  'link'    => 'itemLink',
  'console'   => 'itemConsole',
  'category'  => 'itemCat',
  'condition' => 'itemCond',
  'box'     => 'itemBox',
  'manual'  => 'itemManual',
  'extras'  => 'itemExtras',
  'style'   => 'itemStyle',
  'delete'  => 'itemDeleted'
];

foreach($data as $k => $v)
  if(isset($map[$k])){
    $v = esc($v);
    $queryItems[] = "`{$map[$k]}` = '$v'";
  }
if(isset($queryItems) && count($queryItems) > 0)
  $queryString = implode(',',$queryItems);

// header('Content-type:text/plain');

switch($data['action']){
  case 'find':
    if(isset($data['id']) && $data['id'] > 0){
      require_once('vgItem.class.php');
      $game = new vgItem($data['id']);
      success($game);
    }else{
      fail(0,'No game ID provided',$data);
    }
    break;
  case 'add':
    $addQuery = "INSERT INTO `item` SET {$queryString}";
    $db->query($addQuery);
    if($db->error)
      fail(0,'Error',($db->error."\n".$addQuery));
    else
      success('Query: '.$addQuery);
    break;
  case 'edit':
    $editQuery =  "UPDATE `item` SET {$queryString} WHERE `itemID` = {$data[id]}";
    success($editQuery);
    break;
  case 'delete':
    $deleteQuery = "UPDATE `item` SET `itemDeleted` = true WHERE `itemID` = {$data[id]}";
    success($deleteQuery);
    break;
  default:
    fail(0,'No action provided',$data);
}



?>