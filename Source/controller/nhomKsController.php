<?php

require_once '../models/nhomKsModel.php'; 
header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_POST['func'];
    $data = $_POST['data'];
    // $data = json_decode($data);
    $ksModel = new NhomKsModel();

    switch ($func) {
        case 'getAllNhomKs':

            $response = $ksModel->getAllNhomKs();
            
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Loi khao sat model.'
            ];
            http_response_code(404); // Set a 404 status code for not found
        break;
    }

    echo json_encode($reponse);
}