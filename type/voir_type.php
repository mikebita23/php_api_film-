<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/type.php';
 
// instantiate database and type object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$type = new Type($db);
 
// query type
$stmt = $type->voir_tous();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // type array
    $types_arr=array();
    $types_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $type_item=array(
            "t_id" => $t_id,
            "t_nom" => $t_nom
        );
 
       	if($t_id!=null){
			array_push($types_arr, $type_item);
		}
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show type data in json format
    echo json_encode($types_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No type found.")
    );
}