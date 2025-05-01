<?php

require_once __DIR__ . '/../models/nhomKsModel.php'; 
// header('Content-Type: application/json'); 

if (isset($_POST['func']) || isset($_GET['func'])) {
    $func = $_POST['func'] ?? $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $ksModel = new NhomKsModel();

    switch ($func) {
        case 'getAllNhomKs':
            
            $response = $ksModel->getAllNhomKs();
            break;
            case 'addNhomks':
                $ten = $_POST['ten_nks'] ?? '';
                if (!empty($ten)) {
                    $response = $ksModel->addNhomks($ten);
                } else {
                    $response = ['success' => false, 'message' => 'Tên nhóm không được để trống'];
                }
            break;
            case 'updateNhomKs':
                $data = json_decode($_POST['data'], true);
                $id = $data['id'] ?? '';
                $ten_nks = $data['ten_nks'] ?? '';
                if (!empty($id) && !empty($ten_nks)) {
                    $response = $ksModel->updateNhomKs($id, $ten_nks);
                } else {
                    $response = ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
                }
            break;
            case 'getNhomKsById':
                $id = $_POST['id'] ?? '';
                if (!empty($id)) {
                    $response = $ksModel->getNhomKsById($id);
                } else {
                    $response = null;
                }
                break;

            case "deletenks":
            $id = $_POST['id'];
            $response = $ksModel->deletenks($id);
            break;
        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'nhom Loi khao sat model.'
            ];
            http_response_code(404); 
        break;
    }

    echo json_encode($response);
}

// $ksModel = new NhomKsModel();
// $a = $ksModel->getAllNhomKs();
// echo  json_encode($a[1]);

?>