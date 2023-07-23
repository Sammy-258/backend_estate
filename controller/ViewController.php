<?php

require_once("app/controller.php");
require_once("model/user.php");
require_once("model/transaction.php");

class ViewController extends controller
{
    public function Publicshow($file){
        echo "working";
    }

    public function privateshow($file){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            if($role=="admin"){

            }else{

            }
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );

            echo json_encode($result);
        }
    }

    public function allUsers($file){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];
            
            if($role=="admin"){
                $getallusers = new user($this->pdo);
                $getallusers = $getallusers->getallusers();

                echo json_encode($getallusers);
               
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

    public function getUser($file, $data, $id){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $getuser = new user($this->pdo);
                $getuser= $getuser->getuser($id);
        
                echo json_encode($getuser);
               
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

    // public function deleteUser($file, $data, $id){
    //     session_start();

    //     if(isset($_SESSION["user_data"])){
    //         $this->user_data = $_SESSION["user_data"];
    //         $role = $this->user_data["role"];

    //         if($role=="admin"){
    //             $deleteuser = new user($this->pdo);
    //             $deleteuser= $deleteuser->deleteuser($id);
        
    //             echo json_encode($deleteuser);
               
    //         }else{
    //             $response = array(
    //                 'success' => 'failed',
    //                 'message' => 'you are not authorized to take this action'
    //             );
    //             echo json_encode($response);
    //         }
 
    //     }else{
    //         $result = array(
    //             'success'=>'failed',
    //             'message'=> 'You are not an authenticated user'
    //         );
    //         echo json_encode($result);
    //     }
    // }

    public function getTransaction($file, $data, $id){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $getTransaction = new transaction($this->pdo);
                $getTransaction= $getTransaction->getTransaction($id);
        
                echo json_encode($getTransaction);
               
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

    public function getProfile($file, $data){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $response = array(
                    'success' => 'failed',
                    'message' => 'you are not authorized to take this action'
                );
                echo json_encode($response);
               
            }else{
                echo json_encode($this->user_data);

            }
 
        }else{
            $result = array(
                'success'=>'failed',
                'message'=> 'You are not an authenticated user'
            );
            echo json_encode($result);
        }
    }

    public function approveTransaction($file, $data, $id){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){
                $approveTransaction = new transaction($this->pdo);
                $approveTransaction = $approveTransaction->approveTransaction($id);

                echo json_encode($approveTransaction);
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

    public function getuserTransaction(){
        session_start();

        if(isset($_SESSION["user_data"])){
            $this->user_data = $_SESSION["user_data"];
            $role = $this->user_data["role"];

            if($role=="admin"){

                $response = array(
                    'success' => 'failed',
                    'message' => 'you are not authorized to take this action'
                );
                echo json_encode($response);

              
            }else{
                $email = $this->user_data["email"];
                $getuserTransaction = new transaction($this->pdo);
                $getuserTransaction = $getuserTransaction->getuserTransaction($email);

                echo json_encode($getuserTransaction);
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