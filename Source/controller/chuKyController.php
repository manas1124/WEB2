<?php
require_once __DIR__ . '/../models/chuKyModel.php';
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $chukyModel = new ChuKyModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $chukyModel->getAll();
            break;
        case "getAllpaging":
            $page = isset($_GET["page"]) && $_GET["page"] !== '' ? $_GET["page"] : 1;
            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
            $response = $chukyModel->getAllpaging($page, $status);
            break;
        case "getById":
            if (isset($_GET["ck_id"]) && $_GET["ck_id"] !== '') {
                $ckId = $_GET["ck_id"];
                $response = $chukyModel->getById($ckId);
            }
            break;
        case "create":
            if (isset($_GET["ten_ck"]) && $_GET["ten_ck"] !== '') {
                $ten_ck = $_GET["ten_ck"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $chukyModel->create($ten_ck, $status);
            }
            break;
        case "update":
            if (
                isset($_GET["ck_id"]) && $_GET["ck_id"] !== '' &&
                isset($_GET["ten_ck"]) && $_GET["ten_ck"] !== ''
            ) {
                $ck_id = $_GET["ck_id"];
                $ten_ck = $_GET["ten_ck"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $chukyModel->update($ck_id, $ten_ck, $status);
            }
            break;
        case "toggleStatus":
            if (isset($_GET["ck_id"]) && $_GET["ck_id"] !== '') {
                $ck_id = $_GET["ck_id"];
                $response = $chukyModel->toggleStatus($ck_id);
            }
            break;
        case "chuky-sua":
            ob_start();
            $filePath = "../views/admin/chuky-sua.php";
            require_once($filePath);
            $response["html"] = ob_get_clean();
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
