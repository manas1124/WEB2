<?php

require_once '../models/UserModel.php';
require_once '../../vendor/autoload.php';
require_once __DIR__ . '/../utils/JwtUtil.php';

session_start();

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['func'])) {
    $func = $_POST['func'];

    $ksModel = new UserModel();

    switch ($func) {
        case "getAllUser":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $search = isset($_POST['search']) ? $_POST['search'] : '';
                    $nhomKsId = $_POST['nhomKsId'] ?? '';

                    $response = $ksModel->getAllUser($search, $nhomKsId);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "deleteUser":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $id = $_POST['id'];
                    $response = $ksModel->deleteUser($id);
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "getUserById":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $id = isset($_POST["id"]) ? $_POST["id"] : null;
                    if ($id) {
                        $user = $ksModel->getUserById($id); // Gọi đến model để lấy dữ liệu
                        if ($user) {
                            $response = ['success' => true, 'data' => $user];
                        } else {
                            $response = ['error' => 'Không tìm thấy người dùng'];
                        }
                    } else {
                        $response = ['error' => 'Thiếu ID người dùng'];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "updateUser":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $data = isset($_POST['data']) ? $_POST['data'] : null;
                    if ($data) {
                        $data = json_decode($data, true);
                        $success = $ksModel->updateUser(

                            $data["email"],
                            $data["ho_ten"],

                            $data["diachi"],
                            $data["dien_thoai"],
                            $data["nhom_ks"],
                            $data["loai_dt_id"],
                            $data["ctdt_id"]
                        );
                        if ($success) {
                            $response = ['success' => true];
                        } else {
                            $response = ['success' => false, 'message' => 'Failed to update user'];
                        }
                        echo json_encode($response);
                    }
                } else {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ]);
                }
            }
            break;

        case "addUser":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    $data = isset($_POST['data']) ? $_POST['data'] : null;
                    if ($data) {
                        $data = json_decode($data, true);
                        $idNewKs = $ksModel->addUser(
                            $data["ho_ten"],
                            $data["email"],
                            $data["diachi"],
                            $data["dien_thoai"],
                            $data["nhom_ks"],
                            $data["loai_dt_id"],
                            $data["ctdt_id"]
                        );
                        if ($idNewKs) {
                            $response = ['success' => true, 'id' => $idNewKs];
                        } else {
                            $response = ['error' => 'Failed to add new user.'];
                        }
                    } else {
                        $response = ['error' => 'Data is missing'];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Bạn không có quyền để thực hiện việc này'
                    ];
                }
            }
            break;

        case "importExcel":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'view.target');
                if ($isVaid) {
                    if (isset($_FILES['file'])) {
                        $fileTmpPath = $_FILES['file']['tmp_name'];
                        try {
                            $spreadsheet = IOFactory::load($fileTmpPath);
                            $sheet = $spreadsheet->getActiveSheet();
                            $rows = $sheet->toArray();

                            $isHeader = true;
                            foreach ($rows as $row) {
                                if ($isHeader) {
                                    $isHeader = false;
                                    continue;
                                }
                                if (count($row) == 7) {
                                    $ho_ten = $row[0];
                                    $email = $row[1];
                                    $diachi = $row[2];
                                    $dien_thoai = $row[3];
                                    $nhom_ks = $row[4];
                                    $loai_dt_id = $row[5];
                                    $ctdt_id = $row[6];

                                    $ksModel->addUser(
                                        $ho_ten,
                                        $email,
                                        $diachi,
                                        $dien_thoai,
                                        $nhom_ks,
                                        $loai_dt_id,
                                        $ctdt_id
                                    );
                                } else {
                                    // Nếu số cột không đúng, có thể bỏ qua dòng hoặc ghi lỗi
                                    echo "Dòng không hợp lệ: " . implode(', ', $row) . "\n";
                                }
                            }
                            $response = ['success' => true, 'message' => 'Import completed'];
                        } catch (Exception $e) {
                            $response = ['success' => false, 'message' => 'Error reading file: ' . $e->getMessage()];
                        }
                    } else {
                        $response = ['success' => false, 'message' => 'No file uploaded'];
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
                'message' => 'Invalid function name.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
