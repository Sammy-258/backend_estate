<?php

class model
{
    protected $pdo;
    protected $user_table;
    protected $user_transaction;
    protected $properties_table;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function register($data){
        

        if(empty($data["name"]) || empty($data["email"]) || empty($data["number"]) || empty($data["password"]) || empty($data["ref_code"])){
            $data = array(
                'success'=>'fail',
                'message'=>'all feilds are required'
            );

            return $data;
        }else{
            $name = $data["name"];
            $email = $data["email"];
            $number = $data["number"];
            $password = $data["password"];
            $ref_code = $data["ref_code"];

            $stn = $this->pdo->prepare("SELECT * FROM $this->user_table WHERE email = '$email'");
            $stn->execute();
            $result = $stn->fetch(PDO::FETCH_ASSOC);

            if($result){
                $data = array(
                    'success'=>'success',
                    'message'=>'this email has already been registered'
                );

                return $data;
            }else{

                $stn = $this->pdo->prepare("INSERT INTO $this->user_table (name, email, number, password, ref_code) VALUES ('$name','$email','$number','$password','$ref_code')");
                $stn->execute();

                

                $data = array(
                    'success'=>'success',
                    'message'=>'You Are Successfully Registered'
                );

                return $data;
            }

        }


        
    }

    public function login($data){
        if(empty($data["email"]) || empty($data["password"])){
            $data = array(
                'success'=>'fail',
                'message'=>'all feilds are required please'
            );

            return $data;
        }elseif ($data["email"]=="admin@gmail.com" && $data["password"]=="1234567890") {
            $result = array(
                'email'=>'admin@gmail.com',
                'password'=>'1234567890',
                'role'=>'admin'
            );

            return $result;
        }else{
            $email = $data["email"];
            $password = $data["password"];

            $stn = $this->pdo->prepare("SELECT * FROM $this->user_table WHERE email = '$email' And password = '$password'");
            $stn->execute();

            $result = $stn->fetch(PDO::FETCH_ASSOC);

            if($result){
                $result['role'] = 'user';
            }

            return $result;
        }
    }

    public function getallusers(){
        $stn = $this->pdo->prepare("SELECT * FROM $this->user_table");
        $stn->execute();

        $result  =$stn->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function edituser($data,$id){
        $stn = $this->pdo->prepare("SELECT * FROM $this->user_table WHERE id = '$id'");
        $stn->execute();

        $result  =$stn->fetch(PDO::FETCH_ASSOC);

       

        if($result){
            $patchdata = $data;
            function fetchUserDataFromDatabase($pdo, $table, $userid){
                $stn = $pdo->prepare("SELECT * FROM $table WHERE id = '$userid'");
                $stn->execute();
        
                $result  =$stn->fetch(PDO::FETCH_ASSOC);
        
                return $result;
            }
            $userid = $id;
            $existingdata = fetchUserDataFromDatabase($this->pdo, $this->user_table, $userid);

            foreach ($patchdata as $feild => $value){
                $existingdata[$feild] = $value;
            }

            function updateUserDataInDatabase($pdo, $table, $userId, $updateData) {
                $query = "UPDATE $table SET";
                $values = [];
                foreach ($updateData as $field => $value) {
                    $query .= " $field = :$field, ";
                    $values[":$field"] = $value;
                }
                $query = rtrim($query, ", ");
                $query .= " WHERE id = :userId";
                $values[':userId'] = $userId;
            
                $statement = $pdo->prepare($query);
                $success = $statement->execute($values);
            
                if($success){
                    $response = array(
                        "success"=>"true",
                        "message"=>"you have successfully updated this user details"
                    );

                    return $response;
                }else{
                    $response = array(
                        "success"=>"false",
                        "message"=>"internal error, failed to update user details"
                    );

                    return $response;
                }
            }
            
            $result = updateuserdataindatabase($this->pdo, $this->user_table, $userid, $existingdata);

            return $result;
        }else{
            $response = array(
                'success'=>'failed',
                'message'=>'this user does not exist in our records'
            );

            return $response;
        }
    }

    public function getuser($id){
        $stn = $this->pdo->prepare("SELECT * FROM $this->user_table WHERE id = '$id'");
        $stn->execute();

        $result  =$stn->fetch(PDO::FETCH_ASSOC);

        if($result){
            return $result;
        }else{
            $response = array(
                'success'=>'failed',
                'message'=>'this user does not exist in our record'
            );

            return $response;
        }
    }

    public function deleteuser($id){
        $stn = $this->pdo->prepare("DELETE FROM $this->user_table WHERE id = '$id'");
        $stn->execute();

        $result  = $stn;

        if($result){
            $response = array(
                'success' => 'true',
                'message' => 'user deleted successfully'
            );

            return $response;
        }else{
            $response = array(
                'success' => 'flase',
                'message' => 'failed to delete user from database'
            );

            return $response;
        }
    }

    public function getTransaction($id) {
       $sql = "SELECT * FROM `transaction` WHERE email = '$id'";
       $result=mysqli_query(mysqli_connect("localhost", "root", "", "estate"), $sql);

       $result = mysqli_fetch_assoc($result);

        if($result){
            return $result;
        }else{
            $response = array(
                'success' => 'flase',
                'message' => 'user is not found'
            );

            return $response;
       }
    }
    
    public function editProfile($data,$email){
        $stn = $this->pdo->prepare("SELECT * FROM $this->user_table WHERE email = '$email'");
        $stn->execute();

        $result  =$stn->fetch(PDO::FETCH_ASSOC);

       

        if($result){
            $patchdata = $data;
            function fetchUserDataFromDatabase($pdo, $table, $useremail){
                $stn = $pdo->prepare("SELECT * FROM $table WHERE email = '$useremail'");
                $stn->execute();
        
                $result  =$stn->fetch(PDO::FETCH_ASSOC);
        
                return $result;
            }
            $useremail = $email;
            $existingdata = fetchUserDataFromDatabase($this->pdo, $this->user_table, $useremail);

            foreach ($patchdata as $feild => $value){
                $existingdata[$feild] = $value;
            }

            function updateUserDataInDatabase($pdo, $table, $useremail, $updateData) {
                $query = "UPDATE $table SET";
                $values = [];
                foreach ($updateData as $field => $value) {
                    $query .= " $field = :$field, ";
                    $values[":$field"] = $value;
                }
                $query = rtrim($query, ", ");
                $query .= " WHERE email = :useremail";
                $values[':useremail'] = $useremail;
            
                $statement = $pdo->prepare($query);
                $success = $statement->execute($values);
            
                if($success){
                    $response = array(
                        "success"=>"true",
                        "message"=>"you have successfully updated this user details"
                    );

                    return $response;
                }else{
                    $response = array(
                        "success"=>"false",
                        "message"=>"internal error, failed to update user details"
                    );

                    return $response;
                }
            }
            
            $result = updateuserdataindatabase($this->pdo, $this->user_table, $useremail, $existingdata);

            return $result;
        }else{
            $response = array(
                'success'=>'failed',
                'message'=>'this user does not exist in our records'
            );

            return $response;
        }
    }

    public function approveTransaction($id){
        $stn = $this->pdo->prepare("UPDATE  `transaction` SET `status` ='1' WHERE `id`='$id'");
        $stn->execute();

        if($stn){
            $response = array(
                "status"=>"success",
                "message"=>"you have sucessfully approved this transaction"
            );
            return $response;
        }else{
            $response = array(
                "status"=>"failed",
                "message"=>"failed to approve transaction"
            );
            return $response; 
        }
    }
    
    public function editbankdetails($data, $email){

        if(empty($data["bank"]) || empty($data["account_number"])){
            $response = array(
                "status"=>"failed",
                "message"=>"All feields are mandatory"
            );
            return $response;
        }else{
            $bank_name = $data["bank"];
            $account_number = $data["account_number"];
            $stn = $this->pdo->prepare("UPDATE `user` SET `bank_name`='$bank_name',`account_number`='$account_number' WHERE `email`='$email'");
            $stn->execute();

            if($stn){
                $response = array(
                    "status"=>"success",
                    "message"=>"you have successfully updated your bank details"
                );

                return $response;
            }else{
                $response = array(
                    "status"=>"failed",
                    "message"=>"failed to update your bank details"
                );

                return $response;
            }
        }
        
    }

    public function withdrawrequest($data, $email){
        if(empty($data["bank"]) || empty($data["account_number"]) || empty($data["amount"])){
            $response = array(
                "status"=>"failed",
                "message"=>"All feields are mandatory"
            );
            return $response;
        }else{
            $bank_name = $data["bank"];
            $account_number = $data["account_number"];
            $amount = $data["amount"];
            $stn = $this->pdo->prepare("INSERT INTO `transaction`   (`email`,`bank_name`, `account_number`, `amount`) VALUES ('$email','$bank_name','$account_number','$amount')");
            $stn->execute();

            if($stn){
                $response = array(
                    "status"=>"success",
                    "message"=>"you have successfully requested for a withdrawal request"
                );

                return $response;
            }else{
                $response = array(
                    "status"=>"failed",
                    "message"=>"failed to update your bank details"
                );

                return $response;
            }
        }
    }

    public function getuserTransaction($email){
        $stn = $this->pdo->prepare("SELECT * FROM `transaction` WHERE `email`='$email'");
        $stn->execute();
        
        $result = $stn->fetchAll(PDO::FETCH_ASSOC);

        if($result){
            return $result;
        }else{
            $response = array(
                "status"=>"failed",
                "message"=>"no deatils to fetch for this user"
            );

            return $response;
        }
    }

    public function uploadProduct($data, $imagesData){
        if(empty($data["name"]) || empty($data["price"]) || empty($data["location"]) ){
            $response = array(
                "status"=>"failed",
                "message"=>"all fields are mandatory to fill"
            );
            return $response;
        }else{

            // Set the storage directory path
            $storagePath = __DIR__ . '/../storage';
            
            // Create the storage directory if it doesn't exist
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            

            $name = $data["name"];
            $type = $data["type"];
            $description = $data["description"];
            $location = $data["location"];
            $price = $data["price"];
            $fileName = $imagesData['name'];
            $fileTmpPath = $imagesData['tmp_name'];

            $destination = $storagePath . '/' . $fileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                $stn = $this->pdo->prepare("INSERT INTO `properties` (`name`, `type`, `description`, `location`, price, `image`) VALUES ('$name', '$type', '$description', '$location', '$price', '$fileName')");
                $stn->execute();
    
                if($stn){
                    $response = array(
                        "status"=>"success",
                        "message"=>"you have successfully added a new property successfully"
                    );
                    return $response;
                }else{
                    $response = array(
                        "status"=>"failed",
                        "message"=>"failed to insert property to the database"
                    );
                    return $response;
                }
            }else{
                $response = array(
                    "status"=>"failed",
                    "message"=>"was unable to save the image."
                );
                return $response;
            }


        }
    }
}