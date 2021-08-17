<?php 
$action = $_REQUEST['action'];

if (!empty($action)) {
  require_once 'classes/Player.php';
  $player_obj = new Player();
}

if ($action == 'adduser' && !empty($_POST)) {
  $pname = $_POST['username'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $photo = $_FILES['photo'];
  $playerId = (!empty($_POST['userid'])) ? $_POST['userid'] : '';

  //validations
  //file upload
  $image_name = '';
  if (!empty($photo['name'])) {
    $image_name = $player_obj->upload_Photo($photo);
    $playerData = [
      'pname' => $pname,
      'email' => $email,
      'phone' => $phone,
      'photo' => $image_name
    ];
  }else {
    $playerData = [
      'pname' => $pname,
      'email' => $email,
      'phone' => $phone
    ];
  }
  if($playerId) {
    $player_obj->update($playerData, $playerId);
  } else {
    $playerId = $player_obj->add($playerData);
  }
  if (!empty($playerId)) {
    $player = $player_obj->getRow('id', $playerId);
    echo json_encode($player);
    exit();
  }
}

if ($action == 'getusers') {
  $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
  $limit = 4;
  $start = ($page - 1) * $limit;
  $players = $player_obj->getRows($start, $limit);
  if (!empty($players)) {
    $playersList = $players;
  } else {
    $playersList = [];
  }
  $total = $player_obj->getCount();
  $playerArr = [
    'count' => $total,
    'players' => $playersList
  ];
  echo json_encode($playerArr);
  exit();
}

if ($action == 'getuser') {
  $playerID = (!empty($_GET['id'])) ? $_GET['id'] : '';

  if(!empty($playerID)) {
    $player = $player_obj->getRow('id', $playerID);
    echo json_encode($player);
    exit();
  }
}

if ($action == 'deleteuser') {
  $playerID = (!empty($_GET['id'])) ? $_GET['id'] : '';

  if(!empty($playerID)) {
    $isDeleted = $player_obj->deleteRow($playerID);
    if ($isDeleted) {
      $message = ['deleted' => 1];
    } else {
      $message = ['deleted' => 0];
    }
  }
  echo json_encode($message);
  exit();
}

if ($action == 'search') {
  $QueryString = (!empty($_GET['searchQuery'])) ? $_GET['searchQuery'] : '';
  $results = $player_obj->searchPlayer($QueryString);
  echo json_encode($results);
  exit();
}


?>