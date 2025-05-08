<?php
require_once __DIR__ . '/../models/loaiDoiTuongModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    $loaiDoiTuongModel = new LoaiDoiTuongModel();
    $response = null;

    switch ($func) {
        case "getAll":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
            $response = $loaiDoiTuongModel->getAll();} else {
                $response = [
                    'status' => false,
                    'message' => 'Bạn không có quyền để thực hiện việc này'
                ];
            }
        }
            break;

        case "getAllpaging":if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
            $accessToken = $_SESSION['accessToken'];
            $isVaid = isAuthorization($accessToken, 'view.target');
            if ($isVaid) {
            $page = isset($_GET["page"]) && $_GET["page"] !== '' ? $_GET["page"] : 1;
            $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
            $response = $loaiDoiTuongModel->getAllpaging($page, $status);} else {
                $response = [
                    'status' => false,
                    'message' => 'Bạn không có quyền để thực hiện việc này'
                ];
            }
        }
            break;

        case "getById":if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
            $accessToken = $_SESSION['accessToken'];
            $isVaid = isAuthorization($accessToken, 'view.target');
            if ($isVaid) {
            if (isset($_GET["dt_id"]) && $_GET["dt_id"] !== '') {
                $dt_id = $_GET["dt_id"];
                $response = $loaiDoiTuongModel->getById($dt_id);
            }} else {
                $response = [
                    'status' => false,
                    'message' => 'Bạn không có quyền để thực hiện việc này'
                ];
            }
        }
            break;

        case "create":if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
            $accessToken = $_SESSION['accessToken'];
            $isVaid = isAuthorization($accessToken, 'create.target');
            if ($isVaid) {
            if (isset($_GET["ten_dt"]) && $_GET["ten_dt"] !== '') {
                $ten_dt = $_GET["ten_dt"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $loaiDoiTuongModel->create($ten_dt, $status);
            }} else {
                $response = [
                    'status' => false,
                    'message' => 'Bạn không có quyền để thực hiện việc này'
                ];
            }
        }
            break;

        case "update":if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
            $accessToken = $_SESSION['accessToken'];
            $isVaid = isAuthorization($accessToken, 'edit.target');
            if ($isVaid) {
            if (
                isset($_GET["dt_id"]) && $_GET["dt_id"] !== '' &&
                isset($_GET["ten_dt"]) && $_GET["ten_dt"] !== ''
            ) {
                $dt_id = $_GET["dt_id"];
                $ten_dt = $_GET["ten_dt"];
                $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;
                $response = $loaiDoiTuongModel->update($dt_id, $ten_dt, $status);
            }} else {
                $response = [
                    'status' => false,
                    'message' => 'Bạn không có quyền để thực hiện việc này'
                ];
            }
        }
            break;
        case "loai-doi-tuong-sua":
            ob_start();
            $filePath = "../views/admin/loai-doi-tuong-sua.php";
            require_once($filePath);
            $response["html"] = ob_get_clean();
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Lỗi loại đối tượng controller.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
