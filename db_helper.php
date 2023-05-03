<?php
class DbHelper{


    private $conn;
    function createConnectionWithDatabase(){
       try{
           $conn = new mysqli("localhost","root","","phpdb");
       }catch (Exception $e){
           echo "some error occured during create connection";
       }
    }
    function createNewStudent($name,$email){
// create
        $this->conn->query("Insert");
    }
    function getAllStudents(){}
    function getOneStudent($id){}
    function deleteStudent($id){}
    function updateStudent($name = "",$email = ""){}
}
?>