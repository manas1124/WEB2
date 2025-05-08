<?php

require_once __DIR__ . '/../models/LoaidtModel.php'; 
// header('Content-Type: application/json');
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

if (isset($_GET['func'])) {
    $func = $_GET['func'];
  
    $ksModel = new LoaidtModel();

    switch ($func) {
        case 'getAllLoaidt':if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
            $accessToken = $_SESSION['accessToken'];
            $isVaid = isAuthorization($accessToken, 'view.target');
            if ($isVaid) {
            
            $response = $ksModel->getAllLoaidt();} else {
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
                'message' => 'nhom Loi khao sat model.'
            ];
            http_response_code(404); // Set a 404 status code for not found
        break;
    }

    echo json_encode($response);
}


?>