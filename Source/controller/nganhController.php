<?php
require_once __DIR__ . '/../models/nganhModel.php';
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $nganhModel = new NganhModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $nganhModel->getAll();
            break;
        case "getAllpaging":
            $page = isset($_GET["page"]) && $_GET["page"] !== '' ? $_GET["page"] : 1;
            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
            $response = $nganhModel->getAllpaging($page, $status);
            break;
        case "getById":
            if (isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '') {
                $nganhId = $_GET["nganh_id"];
                $response = $nganhModel->getById($nganhId);
            }
            break;
        case "create":
            if (isset($_GET["ten_nganh"]) && $_GET["ten_nganh"] !== '') {
                $ten_nganh = $_GET["ten_nganh"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $nganhModel->create($ten_nganh, $status);
            }
            break;
        case "update":
            if (
                isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '' && isset($_GET["ten_nganh"]) && $_GET["ten_nganh"] !== ''
            ) {
                $nganh_id = $_GET["nganh_id"];
                $ten_nganh = $_GET["ten_nganh"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $nganhModel->update($nganh_id, $ten_nganh, $status);
            }
            break;
        case "toggleStatus":
            if (isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '') {
                $nganh_id = $_GET["nganh_id"];
                $response = $nganhModel->toggleStatus($nganh_id);
            }
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
