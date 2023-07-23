<?php

require_once("app/controller.php");
require_once("model/user.php");

class PatchController extends controller
{
    public function edituser($path, $data, $id){

        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $edituser = new user($this->pdo);
                $edituser = $edituser->edituser($data,$id);
        
                echo json_encode($edituser);
               
            }else{
                $response = array(
                    'success' => 'failed',
                    'message' => 'you are not authorized to access this route'
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