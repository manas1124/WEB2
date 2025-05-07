<?php
require_once __DIR__ . '/../models/ctdtModel.php';
require_once __DIR__ . '/../models/khaoSatModel.php';
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $CtdtDauraModel = new CtdtDauraModel();
    $khaoSatModel = new KhaoSatModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $CtdtDauraModel->getAll();
            break;
        case "getAllpaging":
            $page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $txt_search = isset($_GET["txt_search"]) ? $_GET["txt_search"] : '';
            $nganh_id = isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '' ? $_GET["nganh_id"] : null;
            $ck_id = isset($_GET["ck_id"]) && $_GET["ck_id"] !== '' ? $_GET["ck_id"] : null;
            $la_ctdt = isset($_GET["la_ctdt"]) && $_GET["la_ctdt"] !== '' ? $_GET["la_ctdt"] : null;
            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;

            $response = $CtdtDauraModel->getAllpaging($page, $nganh_id, $ck_id, $la_ctdt, $status, $txt_search);
            break;
        case "getById":
            if (isset($_GET["ctdt_id"])) {
                $ctdt_id = $_GET["ctdt_id"];
                $response = $CtdtDauraModel->getById($ctdt_id);
            }
            break;
        case "create":
            if (isset($_GET["nganh_id"]) && isset($_GET["ck_id"]) && isset($_GET["la_ctdt"]) && isset($_GET["file"])) {
                $file = $_GET["file"];
                $nganh_id = $_GET["nganh_id"];
                $ck_id = $_GET["ck_id"];
                $la_ctdt = $_GET["la_ctdt"];
                $status = isset($_GET["status"]) ? $_GET["status"] : null;
                if ($CtdtDauraModel->isExist($nganh_id, $ck_id, $la_ctdt)) {
                    $response = [
                        'status' => false,
                        'message' => 'CTDT_CDR đã tồn tại'
                    ];
                } else {
                    $data = $CtdtDauraModel->create($file, $nganh_id, $ck_id, $la_ctdt, $status);
                    $response = [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            break;
        case "update":
            if (isset($_GET["ctdt_id"])) {
                $ctdt_id = $_GET["ctdt_id"];
                $isInUse = $khaoSatModel->isCTDTInUse($ctdt_id);
            }
            if ($isInUse) {
                $response = [
                    'status' => false,
                    'message' => 'CTDT đang sử dụng trong bài khảo sát'
                ];
            } else if (isset($_GET["ctdt_id"]) && isset($_GET["nganh_id"]) && isset($_GET["ck_id"]) && isset($_GET["la_ctdt"]) && isset($_GET["file"])) {
                $ctdt_id = $_GET["ctdt_id"];
                $file = $_GET["file"];
                $nganh_id = $_GET["nganh_id"];
                $ck_id = $_GET["ck_id"];
                $la_ctdt = $_GET["la_ctdt"];
                $status = isset($_GET["status"]) ? $_GET["status"] : null;
                if ($CtdtDauraModel->isExist($nganh_id, $ck_id, $la_ctdt)) {
                    $response = [
                        'status' => false,
                        'message' => 'CTDT_CDR đã tồn tại'
                    ];
                } else {
                    $data = $CtdtDauraModel->update($ctdt_id, $file, $nganh_id, $ck_id, $la_ctdt, $status);
                    $response = [
                        'status' => true,
                        'data' => $data
                    ];
                }
            }
            break;
        case "toggleStatus":
            if (isset($_GET["ctdt_id"])) {
                $ctdt_id = $_GET["ctdt_id"];
                $isInUse = $khaoSatModel->isCTDTInUse($ctdt_id);
            }
            if ($isInUse) {
                $response = [
                    'status' => false,
                    'message' => 'CTDT đang sử dụng trong bài khảo sát'
                ];
            } else if (isset($_GET["ctdt_id"])) {
                $ctdt_id = $_GET["ctdt_id"];
                $data = $CtdtDauraModel->toggleStatus($ctdt_id);
                $response = [
                    'status' => true,
                    'data' => $data
                ];
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
