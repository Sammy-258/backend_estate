<?php

require_once("app/controller.php");
require_once("model/user.php");

class deleteController extends controller
{
    public function deleteUser($file, $data, $id){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $deleteuser = new user($this->pdo);
                $deleteuser= $deleteuser->deleteuser($id);
        
                echo json_encode($deleteuser);
               
            }else{
                $response = array(
                    'success' => 'failed',
                    'message' => 'you are not authorized to take this action'
                );
                echo json_encode($response);
            }
 
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );
            echo json_encode($result);
        }
    }
}