<?php
require_once __DIR__ . '/../models/ketQuaKhaoSatModel.php';
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    $KqKhaoSatModel = new KqKhaoSatModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $KqKhaoSatModel->getAll();
            break;

        case "getAllByKsId":
            $ks_id = $_GET['ks_id'] ?? null;
            $page = $_GET['page'] ?? 1;

            if ($ks_id === null) {
                $response = ['error' => 'Thiếu tham số ks_id'];
            } else {
                $response = $KqKhaoSatModel->getAllByKsId((int)$page, (int)$ks_id);
            }
            break;

        case "getById":
            $id = $_GET['kqks_id'] ?? null;
            if ($id === null) {
                $response = ['error' => 'Thiếu tham số kqks_id'];
            } else {
                $response = $KqKhaoSatModel->getById((int)$id);
            }
            break;

        case "create":
            // Nếu nhận dữ liệu từ GET
            $nguoi_lamks_id = $_GET['nguoi_lamks_id'] ?? null;
            $ks_id = $_GET['ks_id'] ?? null;

            if ($nguoi_lamks_id === null || $ks_id === null) {
                $response = ['error' => 'Thiếu thông tin người làm khảo sát hoặc mã khảo sát'];
            } else {
                $success = $KqKhaoSatModel->create((int)$nguoi_lamks_id, (int)$ks_id);
                $response = $success ? ['success' => true] : ['error' => 'Tạo kết quả khảo sát thất bại'];
            }
            break;
        case "getIdKhaoSat":
            $response = $KqKhaoSatModel->getIdKhaoSat();
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Lỗi không xác định trong khảo sát.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
