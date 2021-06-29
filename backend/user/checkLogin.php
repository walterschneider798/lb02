<?php
//Req headers
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");



//Include db and object
include_once '../config/database.php';
include_once '../objects/user.php';

ini_set('display_errors', 1);

//New instances
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {

  if(!$object = json_decode($postdata)) {
    return http_response_code(400);
  }

  $error = false;


  if (strlen($object->email) < 1) {
    echo "email cant be emtpy<br>";
    $error = true;
  } else if (strlen($object->email) > 100) {
    echo "email is too long<br>";
    $error = true;
  }elseif (!filter_var($object->email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format<br>";
    $error = true;
  }


if(strlen($object->password) < 8 ) {
    echo "password must contain at least 8 characters<br>";
    $error = true;
}



if ($error == true) {
  return http_response_code(422);
  
}

  $user->email      = $object->email;

  if($object->hashed == false) {
    $user->password = md5($object->password);
} else {
    $user->password = $object->password;
}

  //Query users
  $stmt = $user->checkLogin();


  if ($stmt == false) {
    echo "login failed";
    return http_response_code(502);
  }
  else {
  
    foreach ($stmt as $row) {
          echo json_encode(
              array(
              "userid"       => $row["userid"],
              "firstname" => $row["firstname"],
              "lastname"  => $row["lastname"],
              "password"  => $row["password"],
              "email"     => $row["email"]
          ));
          return http_response_code(200);

  }
  }

} else {
  return http_response_code(422);
} 
