<?php
    require_once __DIR__ . '/../models/AccountModel.php';
    require_once __DIR__ . '/../utils/JwtUtil.php';
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;

    session_start();

    const SECRET_KEY = '15ccbe8c9d449a9b63a4a4e5c8f7f087';

    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        require_once __DIR__ . '/../models/AccountModel.php';
        require_once __DIR__ . '/../models/ObjectModel.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $fullName = $_POST['fullName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $ctdtId = $_POST['ctdtId'];
        $loaiDoiTuongId = $_POST['loaiDoiTuongId'];

        
        

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
            $accountModel = new AccountModel();
            if ($accountModel->usernameIsExist($username)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Tài khoản đã tồn tại!'
                ]);
                exit;
            }
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $isSuccess = $accountModel->create($username, $hashedPassword, $doiTuongId);
            if ($isSuccess) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Đăng ký thành công!'
                ]);
                exit;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Đăng ký không thành công!'
                ]);
                exit;
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Đăng ký thành công!'
        ]);
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $accountModel = new AccountModel();
        $account = $accountModel->getAccount($username);
        if (!$account) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tài khoản không tồn tại'
            ]);
            exit;
        }
        // var_dump($account);
        $isSuccess = false;
        if(isValidAccount($account, $password)) {
            $accessToken = generateToken($account);
            $_SESSION['accessToken'] = $accessToken;
            $isSuccess = true;
        }
        echo json_encode([
            'status' => $isSuccess ? 'success' : 'error',
            'message' => $isSuccess ? 'Đăng nhập thành công!' : 'Mật khẩu không đúng!',
        ]);
    }


    function isValidAccount($account, $password) {
        if ($account != null && isValidPassword($password, $account)) {
            return true;
        } 
        return false;
    }

    function isValidPassword($password, $account) {
        return password_verify($password, $account['password']);
    }

?>