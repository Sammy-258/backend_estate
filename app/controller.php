<?php

require_once("model/user.php");

class controller
{
    protected $pdo;

    public function __construct(){
        $this->pdo= new PDO('mysql:host=localhost;dbname=estate', 'root', "");
    }

    public function login($file, $data){

        $user = new user($this->pdo);
        $user= $user->login($data);

        if($user){
            session_start();
            $_SESSION["user_data"]=$user;
            $this->user_data=$_SESSION["user_data"];
            echo json_encode($user);
        }else{
            $response = array(
                'success'=>'failed',
                'message'=>'record do not exist'
            );

            echo json_encode($response);
        }

    }

    public function logout(){
        session_start();

        if(isset($_SESSION["user_data"])){
            unset($_SESSION["user_data"]);
        }

        session_destroy();

        $response = array(
            'success'=>'sucsess',
            'message'=>'you have successfully logout'
        );

        echo json_encode($response);
    }
}