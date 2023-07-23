<?php

require_once("Router.php");

// Router::get("/login", "PostController", "login");

Router::post("/register", "PostController", "register");
Router::post("/login", "controller", "login");
Router::post("/user/profile/edit", "PostController", "editProfile");
Router::post("/user/bankdetails", "PostController", "editbankdetails");
Router::post("/user/withdrawrequest", "PostController", "withdrawrequest");
Router::post("/admin/uploadProduct", "PostController", "uploadProduct");



Router::get("/logout", "controller", "logout");
Router::get("/admin/users", "ViewController", "allUsers");
Router::get("/admin/user", "ViewController", "getUser");
Router::get("/admin/user", "ViewController", "getUser");
Router::get("/admin/user/transaction", "ViewController", "getTransaction");
Router::get("/user/profile", "ViewController", "getProfile");
Router::get("/transaction/approve", "ViewController", "approveTransaction");
Router::get("/user/transactionhistory", "ViewController", "getuserTransaction");



Router::delete("/admin/user/delete", "deleteController", "deleteUser");


Router::patch("/admin/users/edit", "PatchController", "edituser");
Router::patch("/user/profile/edit", "PatchController", "editProfile");


header("HTTP/1.0 404 Not Found");
$response = array(
    'success' => 'failed',
    'message' => 'You are on a wrong route'
);
echo json_encode($response);
exit();