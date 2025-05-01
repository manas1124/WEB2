<?php

require_once __DIR__ . '/../models/LoaidtModel.php'; 
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
  
    $ksModel = new LoaidtModel();

    switch ($func) {
        case 'getAllLoaidt':
            
            $response = $ksModel->getAllLoaidt();
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'nhom Loi khao sat model.'
            ];
            http_response_code(404); // Set a 404 status code for not found
        break;
    }

    echo json_encode($response);
}


?>