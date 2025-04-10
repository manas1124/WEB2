<?php
require_once __DIR__ . '/../models/ctdtModel.php';
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $CtdtDauraModel = new CtdtDauraModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $CtdtDauraModel->getAll();
            break;
        case "getAllpaging":
            $page = $_GET["page"] ? $_GET["page"] : null;
            $nganh_id = $_GET["nganh_id"] ? $_GET["nganh_id"] : null;
            $ck_id = $_GET["ck_id"] ? $_GET["ck_id"] : null;
            $la_ctdt = $_GET["la_ctdt"] ? $_GET["la_ctdt"] : null;
            $status = $_GET["status"] ? $_GET["status"] : null;
            $response = $CtdtDauraModel->getAllpaging($page, $nganh_id, $ck_id, $la_ctdt, $status);
            break;
        case "getById":
            if ($_GET["ctdt_id"]) {
                $ctdt_id = $_GET["ctdt_id"];
                $response = $CtdtDauraModel->getById($ctdt_id);
            }
            break;
        case "create":
            if ($_GET["nganh_id"] && $_GET["ck_id"] && $_GET["la_ctdt"] && $_GET["file"]) {
                $nganh_id = $_GET["nganh_id"] ? $_GET["nganh_id"] : null;
                $ck_id = $_GET["ck_id"] ? $_GET["ck_id"] : null;
                $la_ctdt = $_GET["la_ctdt"] ? $_GET["la_ctdt"] : null;
                $file = $_GET["file"] ? $_GET["file"] : null;
                $status = $_GET["status"] ? $_GET["status"] : null;
                $response = $CtdtDauraModel->create($file, $nganh_id, $ck_id, $la_ctdt, $status);
            }
            break;
        case "update":
            if ($_GET["ctdt_id"] && $_GET["nganh_id"] && $_GET["ck_id"] && $_GET["la_ctdt"] && $_GET["file"]) {
                $ctdt_id = $_GET["ctdt_id"];
                $nganh_id = $_GET["nganh_id"] ? $_GET["nganh_id"] : null;
                $ck_id = $_GET["ck_id"] ? $_GET["ck_id"] : null;
                $la_ctdt = $_GET["la_ctdt"] ? $_GET["la_ctdt"] : null;
                $status = $_GET["status"] ? $_GET["status"] : null;
                $response = $CtdtDauraModel->update($ctdt_id, $file, $nganh_id, $ck_id, $la_ctdt, $status);
            }
            break;
        case "toggleStatus":
            if ($_GET["ctdt_id"]) {
                $ctdt_id = $_GET["ctdt_id"];
                $response = $CtdtDauraModel->toggleStatus($ctdt_id);
            }
            break;
        case "ctdt-sua":
            ob_start();
            $filePath = "../views/admin/ctdtPage-sua.php";
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
