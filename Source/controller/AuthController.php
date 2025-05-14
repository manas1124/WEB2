<?php
require_once __DIR__ . '/../models/AccountModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';
require_once __DIR__ . '/../models/ObjectModel.php';
require_once __DIR__ . '/../models/quyenModel.php';


use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

session_start();

const SECRET_KEY = '15ccbe8c9d449a9b63a4a4e5c8f7f087';

if (isset($_POST['action']) && $_POST['action'] === 'register') {
        require_once __DIR__ . '/../models/AccountModel.php';
        require_once __DIR__ . '/../models/ObjectModel.php';
        require_once __DIR__ . '/../utils/JwtUtil.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $fullName = $_POST['fullName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $ctdtId = $_POST['ctdtId'];
        $loaiDoiTuongId = $_POST['loaiDoiTuongId'];

        $accountModel = new AccountModel();
        if ($accountModel->usernameIsExist($username)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tài khoản đã tồn tại!'
            ]);
            exit;
        }


        $doiTuongModel = new ObjectModel();
        $doiTuongId = $doiTuongModel->create($fullName, $email, $address, $phone, $loaiDoiTuongId, $ctdtId);
        if ($doiTuongId == -1) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Đăng ký không thành công!'
            ]);
            exit;
        } 
        else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $isSuccess = $accountModel->create($username, $hashedPassword, $doiTuongId);
            if ($isSuccess) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Đăng ký thành công!'
                ]);
              
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Đăng ký không thành công!'
                ]);
             
            }
            
        }
}
if (isset($_POST['func']) && $_POST['func'] === "updatePersonalInfor") {
    $hoTen = $_POST['ho_ten'] ?? '';
    $email = $_POST['email'] ?? '';
    $dienThoai = $_POST['dien_thoai'] ?? '';
    $diaChi = $_POST['diachi'] ?? '';

    if (!isset($_SESSION['accessToken']) || empty($_SESSION['accessToken'])) {
        echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập!']);
        exit;
    }

    $userInfor = validateToken($_SESSION['accessToken']);
    if (!$userInfor || !isset($userInfor->dtId)) {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy thông tin người dùng!']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Email không hợp lệ!']);
        exit;
    }

    if (!preg_match('/^[0-9\-\+]{9,15}$/', $dienThoai)) {
        echo json_encode(['status' => 'error', 'message' => 'Số điện thoại không hợp lệ!']);
        exit;
    }

    $objectModel = new ObjectModel();
    $isSuccess = $objectModel->update($userInfor->dtId, $hoTen, $email, $dienThoai, $diaChi);

    echo json_encode([
        'status' => $isSuccess ? 'success' : 'error',
        'message' => $isSuccess ? 'Cập nhật thông tin thành công!' : 'Cập nhật thông tin thất bại!'
    ]);
    exit;
}


//update tai khoan - cap nhat thong tin tai khoan
if (isset($_POST['action']) && $_POST['action'] == 'updateAccount') {
    $tk_id = $_POST['tk_id'];
    $previousPassword = $_POST['previousPassword'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accountModel = new AccountModel();
    
    $account = $accountModel->getAccount($username);
    if (!$account) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lấy thông tin tài khoản ở php lỗi'
        ]);
        exit;
    }
    $isCorrectPreviousPassword = isValidAccount($account, $previousPassword);
    
    if ( $isCorrectPreviousPassword == false ) {
        echo json_encode([
            'status' => 'error',
            'message' => "Mật khẩu cũ không đúng!"]);
        exit;
    }
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $isSuccess = $accountModel->updatePassword($tk_id, $hashedPassword,);
    if ($isSuccess) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Cập nhật thành công!'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Cập nhật không thành công!'
        ]);
        exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $accountModel = new AccountModel();

    //luc mới tạo tài khoản dùng quyền mặc định là 3
    $isExistAccount = $accountModel->usernameIsExist($username);
    if (!$isExistAccount) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username không tồn tại'
        ]);
        exit;
    }

    $account = $accountModel->getAccount($username);
    if (!$account) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lấy thông tin tài khoản ở php lỗi'
        ]);
        exit;
    }
    // var_dump($account);
    $isSuccess = false;
    if (isValidAccount($account, $password)) {
        $accessToken = generateToken($account);
        $_SESSION['accessToken'] = $accessToken;
        $isSuccess = true;
    }
    $quyenModel = new QuyenModel();
    $quyen = $quyenModel->getQuyenById($account['quyen_id']);
    echo json_encode([
        'status' => $isSuccess ? 'success' : 'error',
        'message' => $isSuccess ? 'Đăng nhập thành công!' : 'Mật khẩu không đúng!',
        'accessToken' => $isSuccess ? $accessToken : 'chưa có access token',
        'role' => $isSuccess ? $quyen['ten_quyen'] : 'error'
    ]);
}

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    $_SESSION = array();
    session_destroy();
    echo json_encode([
        'status' => 'success',
        'message' => 'Đăng xuất thành công',
    ]);
}

if (isset($_POST['func']) && $_POST['func'] == "getCurrentLoginUser") {
    // if (!isset($_SESSION['accessToken']) &&  $_SESSION['accessToken'] == "") {
    //     echo json_encode([
    //         'status' => 'error',
    //         'message' => 'Chưa đăng nhập để lấy thông tin tài khoản !',
    //     ]);
    //     exit;
    // }



    $userInfor = validateToken($_SESSION['accessToken']);
    if (!$userInfor) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Chưa đăng nhập !',
        ]);
        exit;
    }
    echo json_encode([
        'status' => "success",
        'message' => "get user infor sucess",
        'userInfor' => $userInfor,
    ]);
    exit;
}

function isValidAccount($account, $password)
{
    return $account != null && isValidPassword($password, $account);
}

function isValidPassword($password, $account)
{
    return password_verify($password, $account['password']);
}
