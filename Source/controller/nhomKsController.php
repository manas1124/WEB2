<?php

require_once __DIR__ . '/../models/nhomKsModel.php';
// header('Content-Type: application/json'); 
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

if (isset($_POST['func']) || isset($_GET['func'])) {
    $func = $_POST['func'] ?? $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $ksModel = new NhomKsModel();

    switch ($func) {
        case 'getAllNhomKs':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $response = $ksModel->getAllNhomKs();
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case 'addNhomks':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'create.target');
                if ($isVaid) {
                    $ten = $_POST['ten_nks'] ?? '';
                    if (!empty($ten)) {
                        $response = $ksModel->addNhomks($ten);
                    } else {
                        $response = ['success' => false, 'message' => 'Tên nhóm không được để trống'];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case 'updateNhomKs':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'edit.target');
                if ($isVaid) {
                    $data = json_decode($_POST['data'], true);
                    $id = $data['id'] ?? '';
                    $ten_nks = $data['ten_nks'] ?? '';
                    if (!empty($id) && !empty($ten_nks)) {
                        $response = $ksModel->updateNhomKs($id, $ten_nks);
                    } else {
                        $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case 'getNhomKsById':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $id = $_POST['id'] ?? '';
                    if (!empty($id)) {
                        $response = $ksModel->getNhomKsById($id);
                    } else {
                        $response = null;
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "deletenks":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'delete.target');
                if ($isVaid) {
                    $id = $_POST['id'];
                    $response = $ksModel->deletenks($id);
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
                'message' => 'nhom Loi khao sat model.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}

// $ksModel = new NhomKsModel();
// $a = $ksModel->getAllNhomKs();
// echo  json_encode($a[1]);
