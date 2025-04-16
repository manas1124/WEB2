<?php

require_once __DIR__ . '/../models/AccountModel.php';
// header('Content-Type: application/json'); 
header('Content-Type: application/json');

if (isset($_POST['func'])) {
    $func = $_POST['func'];
    $accountModel = new AccountModel();
    $response = null;
    switch ($func) {
        case "getAllTaiKhoan":
            $response = $accountModel->getAllTaiKhoan();
            break;

        // case "create":
        //     if (isset($_GET["password"]) && isset($_GET["dt_id"]) && isset($_GET["quyen_id"]) && isset($_GET["username"])) {
        //         $username = $_GET["username"];
        //         $password = $_GET["password"];
        //         $dt_id = $_GET["dt_id"];
        //         $quyen_id = $_GET["quyen_id"];
        //         $status = isset($_GET["status"]) ? $_GET["status"] : null;

        //         $response = $accountModel->create($username, $password, $dt_id, $quyen_id, $status);
        //     }
        //     break;
        case "create":
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
            echo json_encode($response);
            exit;
        case "updateAccount":
            $data = json_decode($_POST['data'], true);
            $response = $accountModel->update(
                $data['tk_id'],
                $data['username'],
                $data['password'],
                $data['dt_id'],
                $data['quyen_id'],
                $data['status']
            );
            break;

        case "softDeleteAccount":
            $tk_id = $_POST['tk_id'];
            $response = $accountModel->softDelete($tk_id);
            break;

        case "searchAccount":
            $keyword = $_POST['keyword'];
            $response = $accountModel->searchAccount($keyword);
            break;

        case "getAccount":
            $username = $_POST['username'];
            $response = $accountModel->getAccount($username);
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Không tìm thấy hàm trong account controller.',
                'html' => 'Lỗi gọi API tài khoản'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
// $ksModel = new KhaoSatModel();
// echo $ksModel->getAllKhaoSat();
