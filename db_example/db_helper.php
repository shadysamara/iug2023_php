<?php
class DbHelper{


    private $conn;
//    public function __construct()
//    {
//        createDbConnection();
//    }

    function createDbConnection(){
try{
    $this->conn = new mysqli("localhost","root","","iugphp");
}catch (Exception $error){
    echo $error->getMessage();

}
    }
    function insertNewStudent($name,$email,$image){
      try{
          $current_date = date('Y-m-d H:i:s');
          $file_link = $this->saveImage($image);
          $sql = "INSERT INTO students (name,email,image,created_at)VALUES ('$name','$email','$file_link','$current_date')";
          $result =  $this->conn->query($sql);
          if($result==true){
              $this->createResponse(true,
                  $this->createStudentResponse($this->conn->insert_id,
                      $name,
                  $email,
                      $file_link,
                      $current_date
                      )
                  );
              }else{
              $this->createResponse(false,"data has not been inserted");

          }

      }catch (Exception $error){
          $this->createResponse(false,$error->getMessage());


      }
    }
    function getAllStudents(){
     try{
         $sql = "select * from students";
         $result = $this->conn->query($sql);

         $count =  $result->num_rows;
         if($count >0){
             $all_students_array = array();
             while ($row = $result->fetch_assoc()){
                 $id = $row["id"];
                 $name = $row["name"];
                 $email = $row["email"];
                 $image = $row["image"];
                 $date = $row["created_at"];
                 // create associative array for the student
                 $student_array = $this->createStudentResponse($id,$name,$email,$image,$date);
                 array_push($all_students_array,$student_array);
             }
             $this->createResponse(true,$count,$all_students_array);
         }
         else{
           throw  Exception("No Data Found");
         }
     }catch (Exception $exception){
         $this->createResponse(false,0,array("error"=>$exception->getMessage()));
     }


    }
    function getStudentById($id){
        $sql = "select * from students where id = $id";
        $result = $this->conn->query($sql);
        try{
            if($result->num_rows ==0){
                throw new Exception("there are no students with the passed id");
            }
            else{
                $row =   $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];
                $email = $row["email"];
                $image = $row["image"];
                $date = $row["created_at"];
                // create associative array for the student
                $student_array = $this->createStudentResponse($id,$name,$email,$image,$date);
                $this->createResponse(true,1,$student_array);

            }
        }
        catch (Exception $exception){
            http_response_code(400);
            $this->createResponse(false,0,array("error"=>$exception->getMessage()));
        }

    }
    function deleteStudent($id){
try{
    $sql = "delete from students where id = $id";
    $result = $this->conn->query($sql);

    if( mysqli_affected_rows($this->conn)>0){
        $this->createResponse(true,1,array("data"=>"student has been deleted"));
    }else{
        throw new Exception("There are no students with the passed id");
    }
}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }
    function updateStudent($id,$name,$email){
try{}
catch (Exception $exception){
    $this->createResponse(false,0,array("error"=>$exception->getMessage()));
}
    }
function saveImage($file){
    $dir_name = "images/";
    $fullPath = $dir_name.$file["name"];
    move_uploaded_file($file["tmp_name"],$fullPath);
    $file_link = "http://localhost/db_example/$fullPath";
    return $file_link;
}

function createResponse($isSuccess,$count,$data){
        echo json_encode(array(
            "success"=>$isSuccess,
            "count"=>$count,
            "data"=>$data
        ));
}
function createStudentResponse($id,$name,$email,$image_url,$created_date){
        return array(
            "id"=>$id,
            "name"=>$name,
            "email"=>$email,
            "image"=>$image_url,
            "created_at"=>$created_date
        );
}
}
?>