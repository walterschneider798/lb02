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

$error = false;





if (isset($postdata) && !empty($postdata)) {

  if (!$object = json_decode($postdata)) {
    return http_response_code(400);
  }

  if (trim($object->firstname) == "") {
    echo "Firstname can't be empty<br>";
    $error = true;
  }
  if (trim($object->lastname) == "") {
    echo "Lastname can't be empty<br>";
    $error = true;
  }


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

  if (
    $object->password !== $object->repeatedpassword ||
    trim($object->password) == ''
  ) {
    echo "invalid password <br>";
    $error = true;
  }elseif (strlen($object->password) < 8 || strlen($object->repeatedpassword) < 8) {
    echo "password must be more than 8 characters<br>";
    $error = true;
  }



  if ($object->password !== $object->repeatedpassword) {
    echo "passwords dont match<br>";
    $error = true;
  }

  if ($error == true) {
    return http_response_code(422);
  }

  $emailUsedQuery = "SELECT * FROM user WHERE email = '$object->email'";
  $stmtUsedQuery = $user->con->prepare($emailUsedQuery);
  $stmtUsedQuery->execute();
  $usedMailCount = $stmtUsedQuery->rowCount();

  if ($usedMailCount !== 0) {
    echo "Email already used<br>";
    return http_response_code(422);
  }



  $user->firstname        = $object->firstname;
  $user->lastname         = $object->lastname;
  $user->email            = $object->email;
  $user->password         = md5($object->password);

  

  if ($user->create()) {
    return http_response_code(200);
   } else {
  return http_response_code(403);
}
}