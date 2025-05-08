<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once __DIR__ . '/../models/chuKyModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

// var_dump($_SESSION);

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $chukyModel = new ChuKyModel();
    $response = null;

    switch ($func) {
        case "getAll":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.program');
                if ($isVaid) {
                    $response = $chukyModel->getAll();
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
                    $response = $chukyModel->getAllpaging($page, $status, $txt_search);
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
                    if (isset($_GET["ck_id"]) && $_GET["ck_id"] !== '') {
                        $ckId = $_GET["ck_id"];
                        $response = $chukyModel->getById($ckId);
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
                    if (isset($_GET["ten_ck"]) && $_GET["ten_ck"] !== '') {
                        $ten_ck = $_GET["ten_ck"];
                        if ($chukyModel->isExist($ten_ck, null)) {
                            $response = [
                                'status' => false,
                                'message' => 'Chu kỳ đã tồn tại'
                            ];
                        } else {
                            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                            $data = $chukyModel->create($ten_ck, $status);
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
                        isset($_GET["ck_id"]) && $_GET["ck_id"] !== '' &&
                        isset($_GET["ten_ck"]) && $_GET["ten_ck"] !== ''
                    ) {
                        $ck_id = $_GET["ck_id"];
                        $ten_ck = $_GET["ten_ck"];
                        if ($chukyModel->isExist($ten_ck, $ck_id)) {
                            $response = [
                                'status' => false,
                                'message' => 'Chu kỳ đã tồn tại'
                            ];
                        } else {
                            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                            $data = $chukyModel->update($ck_id, $ten_ck, $status);
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
                $isVaid = isAuthorization($accessToken, 'edit.program');
                if ($isVaid) {
                    if (isset($_GET["ck_id"]) && $_GET["ck_id"] !== '') {
                        $ck_id = $_GET["ck_id"];
                        $response = $chukyModel->toggleStatus($ck_id);
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
