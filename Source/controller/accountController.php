<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once __DIR__ . '/../models/AccountModel.php';
// header('Content-Type: application/json'); 
if (isset($_POST['func'])) {
    $func = $_POST['func'];
    $accountModel = new AccountModel();
    $response = null;
    switch ($func) {
        case "getAllTaiKhoan":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.account');
                if ($isVaid) {
                    $response = $accountModel->getAllTaiKhoan();
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
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    if (
                        isset($_POST["username"]) &&
                        isset($_POST["password"]) &&
                        isset($_POST["dt_id"]) &&
                        isset($_POST["quyen_id"])
                    ) {
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $dt_id = $_POST["dt_id"];
                        $quyen_id = $_POST["quyen_id"];
                        $status = isset($_POST["status"]) ? $_POST["status"] : null;

                        $response = $accountModel->create($username, $password, $dt_id, $quyen_id, $status);
                    } else {
                        $response = [
                            "status" => false,
                            "message" => "Thiếu dữ liệu đầu vào"
                        ];
                    }
                    header('Content-Type: application/json');
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            echo json_encode($response);
            exit;
        case "updateAccount":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    $required = ['tk_id', 'username', 'password', 'dt_id', 'quyen_id', 'status'];
                    $data = [];

                    foreach ($required as $field) {
                        if (!isset($_POST[$field]) || $_POST[$field] === '') {
                            echo json_encode([
                                'status' => false,
                                'message' => "Thiếu trường {$field}"
                            ]);
                            exit;
                        }
                        $data[$field] = $_POST[$field];
                    }

                    // Kiểm tra tài khoản tồn tại
                    $existing = $accountModel->getAccountById($data['tk_id']);
                    if (!$existing) {
                        echo json_encode([
                            'status' => false,
                            'message' => "Tài khoản không tồn tại"
                        ]);
                        exit;
                    }

                    // Mã hóa mật khẩu
                    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

                    $isSuccess = $accountModel->update(
                        $data['tk_id'],
                        $data['username'],
                        $hashedPassword,
                        $data['dt_id'],
                        $data['quyen_id'],
                        $data['status']
                    );

                    echo json_encode([
                        'status' => $isSuccess,
                        'message' => $isSuccess ? "Cập nhật thành công" : "Cập nhật thất bại"
                    ]);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            exit;
        case "checkExistAccount":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $username = $data["username"];

            // Tìm tất cả tài khoản có username chứa từ khóa (LIKE %keyword%)
            $accounts = $accountModel->searchAccount($username);
            // Nếu có ít nhất 1 tài khoản khớp => tồn tại
            $response = (!empty($accounts)) ? true : false;
            break;
            $tk_id = $_POST['tk_id'] ?? null;
            if (!$tk_id) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Thiếu tk_id'
                ]);
                exit;
            }

            $response = $accountModel->softDelete($tk_id);
            echo json_encode([
                'status' => $response,
                'message' => $response ? 'Xóa tài khoản thành công' : 'Xóa tài khoản thất bại'
            ]);
            exit;

        case "searchAccount":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    $keyword = $_POST['keyword'];
                    $response = $accountModel->searchAccount($keyword);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "getAccount":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    $username = $_POST['username'];
                    $response = $accountModel->getAccount($username);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "getChiTietAccountById":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    $id = $_POST['id'];
                    $response = $accountModel->getAccountById($id);
                    // $response = $ksModel->getAllKhaoSat();} else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;
        case "softDeleteAccount":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, '.account');
                if ($isVaid) {
                    $tk_id = $_POST['tk_id'] ?? null;

                    if (!$tk_id) {
                        echo json_encode([
                            'status' => false,
                            'message' => 'Thiếu tk_id'
                        ]);
                        exit;
                    }

                    $result = $accountModel->softDelete($tk_id);

                    echo json_encode([
                        'status' => $result,
                        'message' => $result ? "Xóa thành công" : "Xóa thất bại"
                    ]);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            exit;
        default:
            echo json_encode([
                "error" => "Page not found",
                "message" => "Không tìm thấy hàm trong account controller.",
                "html" => "Lỗi gọi API tài khoản"
            ]);
            break;
    }

    echo json_encode($response);
}
// $ksModel = new KhaoSatModel();
// echo $ksModel->getAllKhaoSat();
