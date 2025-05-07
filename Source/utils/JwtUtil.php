<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    const KEY = 'fe9d1a2c66ae41321df755e206ab7a34835331cb001cdca05c9e5e999a0dbee4';


    function generateToken($account) {
        $payload = [
            'userId' =>$account['tk_id'],
            'dtId' =>$account['dt_id'],
            'sub' => $account['username'],
            'iat' => time(), 
            'exp' => time() + (60 * 15),  // 15 mins
            'permission' => $account['keys'] 
        ];
        return JWT::encode($payload, KEY, 'HS256');
    }

    function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(KEY, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }

    function isAuthorization($token, $permission) {
        $decoded = validateToken($token);
        if ($decoded) {
            $listPermission = $decoded->permission;
            foreach ($listPermission as $item) {
                if ($item == $permission) {
                    return true;
                }
            }
        }
        return false;
    }
    function getObjectId($token) {
        $decoded = validateToken($token);
        if ($decoded) {
            return $decoded->dtId;
        }
        return null;
    }

    
?>
