<?php

require_once("./app/init.php");

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Extract the data from the request body
//     $data = json_decode(file_get_contents('php://input'), true);

//     // Perform any necessary processing or validation
//     // ...

//     // Prepare the response data
//     $response = array('message' => 'Success', 'data' => $data);

//     // Set the response headers
//     header('Content-Type: application/json');

//     // Send the response
//     echo json_encode($response);
//     exit;
// }