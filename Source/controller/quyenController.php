<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once __DIR__ . '/../models/quyenModel.php';

if (isset($_POST['func'])) {
    $func = $_POST['func'];
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
        case "create":
            if (isset($_POST["ten_quyen"]) && $_POST["ten_quyen"] !== '') {
                $ten_quyen = $_POST["ten_quyen"];
                $status = isset($_POST["status"]) && $_POST["status"] !== '' ? $_POST["status"] : null;

                $response = $quyenModel->create($ten_quyen, $status);
            } else {
                $response = [
                    "status" => false,
                    "message" => "Thiếu dữ liệu đầu vào"
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;

        case "updateQuyen":
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
        case "checkExistQuyen":
            if (!isset($_POST['data'])) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Thiếu dữ liệu quyen'
                ]);
                exit;
            }
            $data = json_decode($_POST['data'], true);
            if (!is_array($data)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Dữ liệu không hợp lệ'
                ]);
                exit;
            }
            $quyen_id = $data['quyen_id'] ?? null;
            $ten_quyen = $data['ten_quyen'] ?? null;

            if (empty($quyen_id) && empty($ten_quyen)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Thiếu quyen_id hoặc ten_quyen'
                ]);
                exit;
            }
            $quyens = $quyenModel->searchQuyen($quyen_id, $ten_quyen);
            $response = !empty($quyens);
            echo json_encode([
                'status' => $response,
                'message' => $response ? 'Quyền đã tồn tại' : 'Quyền chưa tồn tại'
            ]);
            exit;
            break;
        case "getChiTietQuyenById":
            $id = $_POST['id'];
            $response = $accountModel->getQuyenById($id);
            break;
        case "delete":
            $quyen_id = $_POST['quyen_id'] ?? null;
            if (!$quyen_id) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Thiếu quyen_id'
                ]);
                exit;
            }
            $result = $quyenModel->delete($quyen_id);
            echo json_encode([
                'status' => $result,
                'message' => $result ? "Xóa thành công" : "Xóa thất bại"
            ]);
            exit;
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
