<?php
require_once __DIR__ . '/../models/doiTuongModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    $doiTuongModel = new DoiTuongModel();
    $response = null;

    switch ($func) {
        case "getAll":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $response = $doiTuongModel->getAll();
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
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $response = $doiTuongModel->getAllpaging($page, limit: 10);
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
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $response = $doiTuongModel->getById($dt_id);
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
                $isVaid = isAuthorization($accessToken, 'create.target');
                if ($isVaid) {
                    if (
                        isset($_GET['ho_ten']) && isset($_GET['email']) && isset($_GET['diachi'])
                        && isset($_GET['dien_thoai']) && isset($_GET['nhom_ks'])
                        && isset($_GET['loai_dt_id']) && isset($_GET['ctdt_id'])
                    ) {
                        $ho_ten = $_GET['ho_ten'];
                        $email = $_GET['email'];
                        $diachi = $_GET['diachi'];
                        $dien_thoai = $_GET['dien_thoai'];
                        $nhom_ks = $_GET['nhom_ks'];
                        $loai_dt_id = $_GET['loai_dt_id'];
                        $ctdt_id = $_GET['ctdt_id'];
                        $response = $doiTuongModel->create($ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id);
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'Không thể thêm đối tượng'
                        ];
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
                $isVaid = isAuthorization($accessToken, 'edit.target');
                if ($isVaid) {
                    if (
                        isset($_GET['dt_id']) && isset($_GET['ho_ten']) && isset($_GET['email']) && isset($_GET['diachi'])
                        && isset($_GET['dien_thoai']) && isset($_GET['nhom_ks'])
                        && isset($_GET['loai_dt_id']) && isset($_GET['ctdt_id'])
                    ) {
                        $dt_id = $_GET['dt_id'];
                        $ho_ten = $_GET['ho_ten'];
                        $email = $_GET['email'];
                        $diachi = $_GET['diachi'];
                        $dien_thoai = $_GET['dien_thoai'];
                        $nhom_ks = $_GET['nhom_ks'];
                        $loai_dt_id = $_GET['loai_dt_id'];
                        $ctdt_id = $_GET['ctdt_id'];
                        $status = isset($_GET['status']) ? $_GET['status'] : 1;
                        $response = $doiTuongModel->update($dt_id, $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id, $status);
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'Không thể thêm đối tượng'
                        ];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "getByIds":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    if (isset($_GET['dt_ids'])) {
                        $dt_ids = $_GET['dt_ids'];
                        $response = $doiTuongModel->getByIds($dt_ids);
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
                'message' => 'Lỗi đối tượng controller.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
