<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
include_once '../config/database.php';
include_once '../objects/student.php';
 
// instantiate database and student object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$student = new Student($db);
 
$stmt = $student->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // students array
    $students_arr=array();
    $students_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);
 
        $student_item=array(
            "id" => $id,
            "student_name" => $student_name,
            "student_number" => $student_number,
            "student_age" => $student_age,
        );
 
        array_push($students_arr["records"], $student_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show students data in json format
    echo json_encode($students_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no students found
    echo json_encode(
        array("message" => "No students found.")
    );
}

