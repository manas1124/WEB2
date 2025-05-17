<?php
require_once __DIR__ . '/../models/loaiTraLoiModel.php';
// header('Content-Type: application/json'); 
require_once __DIR__ . '/../utils/JwtUtil.php';

header('Content-Type: application/json');

session_start();

$model = new LoaiTraLoiModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['func'])) {
        $func = $_POST['func'];

        switch ($func) {
            case "create":
                if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                    $accessToken = $_SESSION['accessToken'];
                    $isVaid = isAuthorization($accessToken, 'create.survey');
                    if ($isVaid) {
                        $moTa = $_POST['mo-ta'] ?? '';
                        $thangDiem = $_POST['thang-diem'] ?? '';
                        $chiTietJson = $_POST['chi-tiet'] ?? '[]';
                        $chiTietArray = json_decode($chiTietJson, true);
                        $chiTietString = implode(',', $chiTietArray);
                        $result = $model->create($thangDiem, $moTa, $chiTietString);

                        $response = [
                            'status' => $result ? true : false,
                            'message' => $result ? 'Tạo thành công' : 'Tạo thất bại'
                        ];
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
                    $isVaid = isAuthorization($accessToken, 'edit.survey');
                    if ($isVaid) {
                        $ltl_id = isset($_POST['ltl_id']) ? intval($_POST['ltl_id']) : -1;
                        $moTa = isset($_POST['mo-ta']) ? ($_POST['mo-ta']) : '';
                        $thangDiem = isset($_POST['thang-diem']) ? intval($_POST['thang-diem']) : 2;
                        $chiTietJson = isset($_POST['chi-tiet']) ? $_POST['chi-tiet'] : '[]';
                        $status = isset($_POST["status"]) && $_POST["status"] !== '' ? intval($_POST["status"]) : 0;

                        $chiTietArray = json_decode($chiTietJson, true);
                        $chiTietString = is_array($chiTietArray) ? implode(',', $chiTietArray) : '';

                        $result = $model->update($ltl_id, $thangDiem, $moTa, $chiTietString, $status);
                        // var_dump($ltl_id);
                        // var_dump($thangDiem);
                        // var_dump($moTa);
                        // var_dump($chiTietString);
                        // var_dump($status);
                        $response = [
                            'status' => $result ? true : false,
                            'message' => $result ? 'Chỉnh sửa thành công' : 'Chỉnh sửa thất bại'
                        ];
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
                    $isVaid = isAuthorization($accessToken, 'edit.survey');
                    if ($isVaid) {
                        if (isset($_POST['ltl_id'])) {
                            $ltl_id = $_POST['ltl_id'];
                            $result = $model->toggleStatus($ltl_id);
                            $response = [
                                'status' => $result,
                                'message' => 'Đã cập nhật trạng thái'
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
            default:
                $response = [
                    'error' => 'Page not found',
                    'message' => 'Loi tra loi model.'
                ];
                http_response_code(404); // Set a 404 status code for not found
                break;
        }
        echo json_encode($response);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['func'])) {
        $func = $_GET['func'];

        switch ($func) {
            case "getAllTraLoi":
                if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                    $accessToken = $_SESSION['accessToken'];
                    $isVaid = isAuthorization($accessToken, 'view.survey');
                    if ($isVaid) {
                        $response = $model->getAllTraLoi();
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'Bạn không có quyền để thực hiện việc này'
                        ];
                    }
                }
                break;
            case "getAllPaging":
                if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                    $accessToken = $_SESSION['accessToken'];
                    $isVaid = isAuthorization($accessToken, 'view.survey');
                    if ($isVaid) {
                        $page = isset($_GET['page']) ? ($_GET['page']) : 1;
                        $txt_search = isset($_GET['txt_search']) ? $_GET['txt_search'] : '';
                        $status = isset($_GET["status"]) && $_GET["status"] !== '' ? $_GET["status"] : null;

                        $response = $model->getAllPaging($page, $txt_search, $status);
                    } else {
                        $response = [
                            'status' => false,
                            'message' => 'Bạn không có quyền để thực hiện việc này'
                        ];
                    }
                }
                break;
            case "getLoaiTraLoiById":
                if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                    $accessToken = $_SESSION['accessToken'];
                    $isVaid = isAuthorization($accessToken, 'view.survey');
                    if ($isVaid) {
                        $ltl_id = isset($_GET['ltl_id']) ? ($_GET['ltl_id']) : -1;
                        $loaiTraLoi = $model->getLoaiTraLoiById($ltl_id);
                        if ($loaiTraLoi) {
                            $response = [
                                'status' => true,
                                'message' => 'Lấy thông tin loại trả lời thành công',
                                'data' => $loaiTraLoi
                            ];
                        } else {
                            $response = [
                                'status' => false,
                                'message' => 'Không tìm thấy loại trả lời tương ứng',
                                'data' => null
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
            default:
                $response = [
                    'error' => 'Page not found',
                    'message' => 'Loi tra loi model.'
                ];
                http_response_code(404); // Set a 404 status code for not found
                break;
        }
        echo json_encode($response);
    }
} else {
    $response = [
        'error' => 'Page not found',
        'message' => 'Loi tra loi model.'
    ];
    http_response_code(404);
}
