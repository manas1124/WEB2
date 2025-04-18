<?php
    require_once __DIR__ . '/../models/AccountModel.php';
    require_once __DIR__ . '/../utils/JwtUtil.php';
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;

    session_start();

    const SECRET_KEY = '15ccbe8c9d449a9b63a4a4e5c8f7f087';

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
        if(isValidAccount($account, $password)) {
            $accessToken = generateToken($account);
            $_SESSION['accessToken'] = $accessToken;
            echo json_encode([
                'status' => 'success',
                'accessToken' => $accessToken,
            ]);

        }
        else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mật khẩu không đúng'
            ]);
        }
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