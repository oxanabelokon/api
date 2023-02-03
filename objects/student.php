<?php
class Student{
 
    // database connection and table name
    private $conn;
    private $table_name = "student";
 
    // object properties
    public $id;
    public $student_name;
    public $student_number;
    public $student_age;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read students
   function read(){
 
    // select all query
    $query = "SELECT
                student_name, id, student_number, student_age
            FROM
                " . $this->table_name . " 
                
            ORDER BY
                id ASC";
                // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// update the student
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                student_name = :student_name,
                student_number = :student_number,
                student_age = :student_age,
                id = :id
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->student_name=htmlspecialchars(strip_tags($this->student_name));
    $this->student_number=htmlspecialchars(strip_tags($this->student_number));
    $this->student_age=htmlspecialchars(strip_tags($this->student_age));
    $this->id=htmlspecialchars(strip_tags($this->id));
   
 
    // bind new values
    $stmt->bindParam(':student_name', $this->student_name);
    $stmt->bindParam(':student_number', $this->student_number);
    $stmt->bindParam(':student_age', $this->student_age);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the student
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}
//http://localhost/api/student/read.php
?> 


