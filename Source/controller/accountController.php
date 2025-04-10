<?php

require_once __DIR__ . '/../models/AccountModel.php';
// header('Content-Type: application/json'); 
header('Content-Type: application/json');

if (isset($_POST['func'])) {
    $func = $_POST['func'];
    $accountModel = new AccountModel();

    switch ($func) {
        case "getAllTaiKhoan":
            $response = $accountModel->getAllTaiKhoan();
            break;

        case "createAccount":
            $data = json_decode($_POST['data'], true);
            $response = $accountModel->create(
                $data['tk_id'],
                $data['username'],
                $data['password'],
                $data['dt_id'],
                $data['quyen_id'],
                $data['status']
            );
            break;

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


?>

