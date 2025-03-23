<?php

require_once '../models/khaoSatModel.php'; 


if (isset($_POST['func'])) {
    $func = $_POST['func'];
    $data = $_POST['data'];
    // $data = json_decode($data);
    $ksModel = new KhaoSatModel();
    
    switch ($func) {
        case "getAllKhaoSat":
            $result = $ksModel->getAllKhaoSat();
       
            break;
        case "getKhaoSatById":
           $id = $data['ks_id']; //lay id tu json

            $result = $ksModel->getKhaoSatById($id);
            break;
        default:
            $data = [
                'error' => 'Page not found',
            ];
            $response = null;
            http_response_code(404); // Set a 404 status code for not found
        break;
    }
    echo $result;
}

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_POST['data'];
    

    switch ($func) {

    }
}
?>
