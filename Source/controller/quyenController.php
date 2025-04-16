<?php
require_once __DIR__ . '/../models/quyenModel.php';

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    $quyenModel = new QuyenModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $quyenModel->getAll();
            break;

        case "getAllpaging":
            $page = isset($_GET["page"]) && $_GET["page"] !== '' ? $_GET["page"] : 1;
            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
            $response = $quyenModel->getAllpaging($page, $status);
            break;

        case "getById":
            if (isset($_GET["quyen_id"]) && $_GET["quyen_id"] !== '') {
                $quyen_id = $_GET["quyen_id"];
                $response = $quyenModel->getById($quyen_id);
            }
            break;

        case "create":
            if (isset($_GET["ten_quyen"]) && $_GET["ten_quyen"] !== '') {
                $ten_quyen = $_GET["ten_quyen"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $quyenModel->create($ten_quyen, $status);
            }
            break;

        case "update":
            if (
                isset($_GET["quyen_id"]) && $_GET["quyen_id"] !== '' &&
                isset($_GET["ten_quyen"]) && $_GET["ten_quyen"] !== ''
            ) {
                $quyen_id = $_GET["quyen_id"];
                $ten_quyen = $_GET["ten_quyen"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $quyenModel->update($quyen_id, $ten_quyen, $status);
            }
            break;
        case "quyen-sua":
            ob_start();
            $filePath = "../views/admin/quyen-sua.php";
            require_once($filePath);
            $response["html"] = ob_get_clean();
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Lỗi quyền controller.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
