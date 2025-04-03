<?php

require_once '../models/khaoSatModel.php'; 
// header('Content-Type: application/json'); 

if (isset($_POST['func'])) {
    $func = $_POST['func'];
    // $data = $_POST['data'];
    // $data = json_decode($data);
    $ksModel = new KhaoSatModel();
    
    switch ($func) {
        case "getAllKhaoSat":
            $response = $ksModel->getAllKhaoSat();
            break;
        case "getKhaoSatById":
           $id = $data['ks_id']; //lay id tu json

            $response = $ksModel->getKhaoSatById($id);
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

elseif  (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_POST['data'];
    
    echo "test";
}

?>

