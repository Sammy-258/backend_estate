<?php

require_once("app/controller.php");
require_once("model/user.php");
require_once("model/properties.php");

class PostController extends controller
{
    public function login($file, $data)
    {
        $user = new user($this->pdo);
        $user->login($data);

        echo json_encode($data);
    }

    public function register($file, $data)
    {
       $user = new user($this->pdo);
       $user=$user->register($data);

       echo json_encode($user) ;
    }

    public function editProfile($file, $data){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            if($role=="admin"){
                $result = array(
                    'success'=>'failed',
                    'message'=> 'You are an admin and so you cannot access this route'
                );
    
                echo json_encode($result);
            }else{
                $email= $this->user_data["email"];
                $user = new user($this->pdo);
                $user=$user->editProfile($data, $email);
         
                echo json_encode($user) ;
            }
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );

            echo json_encode($result);
        }
    }

    public function editbankdetails($file, $data){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            if($role=="admin"){
                $result = array(
                    'success'=>'failed',
                    'message'=> 'You are an admin and so you cannot access this route'
                );
    
                echo json_encode($result);
            }else{
                $email= $this->user_data["email"];
                $editbankdetails = new user($this->pdo);
                $editbankdetails= $editbankdetails->editbankdetails($data, $email);
         
                echo json_encode($editbankdetails) ;
            }
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );

            echo json_encode($result);
        }
    }

    public function withdrawrequest($file, $data){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            if($role=="admin"){
                $result = array(
                    'success'=>'failed',
                    'message'=> 'You are an admin and so you cannot access this route'
                );
    
                echo json_encode($result);
            }else{
                $email= $this->user_data["email"];
                $withdrawrequest = new user($this->pdo);
                $withdrawrequest= $withdrawrequest->withdrawrequest($data, $email);
         
                echo json_encode($withdrawrequest) ;
            }
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );

            echo json_encode($result);
        }
    }

    public function uploadProduct($file, $data, $imagesData){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            if($role=="admin"){
                $uploadProduct = new properties($this->pdo);
                $uploadProduct = $uploadProduct->uploadProduct($data, $imagesData);

                echo json_encode($uploadProduct);
            }else{
                $result = array(
                    'success'=>'failed',
                    'message'=> 'You are not an admin and so you cannot access this route'
                );
    
                echo json_encode($result);
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
