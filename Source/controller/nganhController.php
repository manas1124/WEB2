<?php
require_once __DIR__ . '/../models/nganhModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';
// header('Content-Type: application/json'); 
session_start();

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $nganhModel = new NganhModel();
    $response = null;

    switch ($func) {
        case "getAll":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.program');
                if ($isVaid) {
                    $response = $nganhModel->getAll();
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "getAllpaging":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.program');
                if ($isVaid) {
                    $page = isset($_GET["page"]) && $_GET["page"] !== '' ? $_GET["page"] : 1;
                    $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                    $txt_search = isset($_GET["txt_search"]) ? $_GET["txt_search"] : '';
                    $response = $nganhModel->getAllpaging($page, $status, $txt_search);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "getById":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.program');
                if ($isVaid) {
                    if (isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '') {
                        $nganhId = $_GET["nganh_id"];
                        $response = $nganhModel->getById($nganhId);
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "create":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'create.program');
                if ($isVaid) {
                    if (isset($_GET["ten_nganh"]) && $_GET["ten_nganh"] !== '') {
                        $ten_nganh = $_GET["ten_nganh"];
                        if ($nganhModel->isExist($ten_nganh)) {
                            $response = [
                                'status' => false,
                                'message' => 'Ngành đã tồn tại'
                            ];
                        } else {
                            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                            $data = $nganhModel->create($ten_nganh, $status);
                            $response = [
                                'status' => true,
                                'data' => $data
                            ];
                        }
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "update":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'edit.program');
                if ($isVaid) {
                    if (
                        isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '' && isset($_GET["ten_nganh"]) && $_GET["ten_nganh"] !== ''
                    ) {
                        $nganh_id = $_GET["nganh_id"];
                        $ten_nganh = $_GET["ten_nganh"];
                        if ($nganhModel->isExist($ten_nganh)) {
                            $response = [
                                'status' => false,
                                'message' => 'Ngành đã tồn tại'
                            ];
                        } else {
                            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                            $data = $nganhModel->update($nganh_id, $ten_nganh, $status);
                            $response = [
                                'status' => true,
                                'data' => $data
                            ];
                        }
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "toggleStatus":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'delete.program');
                if ($isVaid) {
                    if (isset($_GET["nganh_id"]) && $_GET["nganh_id"] !== '') {
                        $nganh_id = $_GET["nganh_id"];
                        $response = $nganhModel->toggleStatus($nganh_id);
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
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
