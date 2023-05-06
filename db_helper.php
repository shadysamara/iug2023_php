<?php
class DbHelper{


    private $conn;
    function createDbConnection(){
try{
    $this->conn = new mysqli("localhost","root","","iugphp");
}catch (Exception $error){
    echo $error->getMessage();

}
    }
    function insertNewStudent($name,$email){
      try{
          $sql = "INSERT INTO students (name,email)VALUES ('$name','$email')";
          $result =  $this->conn->query($sql);
          if($result==true){
              echo json_encode(array("success"=>true,
                  "message"=>"new user has been addedd"
              )) ;
          }else{
              echo json_encode(array("success"=>false,
                  "message"=>"new user has not been addedd"
              )) ;
          }

      }catch (Exception $error){
          echo $error->getMessage();

      }
    }
    function getAllStudents(){}
    function getStudentById($id){}
    function deleteStudent($id){}
    function updateStudent($id,$name,$email){}
}
?>