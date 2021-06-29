
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



    $stmt = $user->getnames();

    if ($stmt == false) {
        echo "error";
        return http_response_code(422);
        // output data of each row

    } else {
        
        $names = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $array =  array(
                'nameid' => $row["nameid"],
                'name' => $row["name"],
              
            );

            array_push($names, $array);
        }


        /* while($row = $stmt->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["firstname"]." ".$row["lastname"]."</td></tr>";
        }
        */
        echo json_encode($names);
        return http_response_code(200);
    }
} else {
    return http_response_code(422);
}
