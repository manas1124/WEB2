<?php
require_once __DIR__ . '/../models/nganhModel.php'; 
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $ckModel = new NganhModel();
    
    switch ($func) {
        case "getAllNganh":
            $response = $ckModel->getAllNganh();
            break;
        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Loi khao sat model.'
            ];
            http_response_code(404); // Set a 404 status code for not found
        break;
    }
    echo json_encode($response);
}


// $ksModel = new KhaoSatModel();
// echo $ksModel->getAllKhaoSat();


?>

