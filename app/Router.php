<?php

class Router
{
    public static function handle($method="", $path="", $controller="", $action=""){
        $current_method = $_SERVER["REQUEST_METHOD"];
        $current_uri = $_SERVER["REQUEST_URI"];
        // echo $path;
        if($current_method !== $method){
            return false;
            
        }else{
           
            $parent_uri="/BACKEND_ESTATE";
            $local_uri = '#^'.$parent_uri.$path.'/(?:([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})|([0-9]+))$#siD';
            $other_local_uri = '#^'.$parent_uri.$path.'$#siD';
            if(preg_match($local_uri,$current_uri, $id)){
                $url_pram = !empty($id[1]) ? $id[1] : (!empty($id[2]) ? $id[2] : null);
                $id = $url_pram; 
                if ($method=="PATCH") {
                    
                    $patchData = json_decode(file_get_contents('php://input'), true);
                    // require_once("controller/$controller.php");
                    // $controller = new $controller;
                    // $controller->$action($path, $patchData, $id); 
                    var_dump($patchData);
                    exit();
                    
                }elseif ($method=="DELETE") {
                    $patchData = json_decode(file_get_contents('php://input'), true);
                    require_once("controller/$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $patchData, $id); 
                    exit();
                }else{
                    require_once("controller/$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $_POST, $id); 
                    exit();
                }
                exit();
            }elseif (preg_match($other_local_uri, $current_uri)) {
                if($path=="/login" && $method=="POST"){
                    require_once("$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $_POST); 
                    exit();
                }elseif ($path=="/register" && $method=="POST") {
                    require_once("controller/$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $_POST); 
                    exit();
                }elseif ($path=="/logout" && $method=="GET") {
                    require_once("$controller.php");
                    $controller = new $controller;
                    $controller->$action(); 
                    exit();
                }elseif (isset($_FILES['image'])) {
                    require_once("controller/$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $_POST, $_FILES["image"]); 
                    // var_dump();
                    exit();
                }else{
                    require_once("controller/$controller.php");
                    $controller = new $controller;
                    $controller->$action($path, $_POST, $id); 
                    exit();
                }
            }
            
        }
    }


    public static function post($path="", $controller="", $action=""){
        return self::handle("POST",$path,$controller,$action);
    } 

    public static function get($path="", $controller="", $action=""){
        return self::handle("GET",$path,$controller,$action);
    }

    public static function patch($path="", $controller="", $action=""){
        return self::handle("PATCH",$path,$controller,$action);
    }

    public static function delete($path="", $controller="", $action=""){
        return self::handle("DELETE",$path,$controller,$action);
    }

}