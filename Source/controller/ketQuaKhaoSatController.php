<?php
require_once __DIR__ . '/../models/ketQuaKhaoSatModel.php';
require_once __DIR__ . '/../models/mucKhaoSatModel.php';
require_once __DIR__ . '/../models/cauHoiModel.php';
require_once __DIR__ . '/../models/traLoiModel.php';

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    $KqKhaoSatModel = new KqKhaoSatModel();
    $mucKhaoSatModel = new MucKhaoSatModel();
    $cauHoiModel = new CauHoiModel();
    $traloiModel = new TraLoiModel();
    $response = null;

    switch ($func) {
        case "getAll":
            $response = $KqKhaoSatModel->getAll();
            break;

        case "getAllByKsId":
            $ks_id = $_GET['ks_id'] ?? null;
            if ($ks_id === null) {
                $response = ['error' => 'Thiếu tham số ks_id'];
            } else {
                $response = $KqKhaoSatModel->getAllByKsId($ks_id);
            }
            break;

        case "getById":
            $id = $_GET['kqks_id'] ?? null;
            if ($id === null) {
                $response = ['error' => 'Thiếu tham số kqks_id'];
            } else {
                $response = $KqKhaoSatModel->getById((int)$id);
            }
            break;
        case "getMucKhaoSat":
            $ks_id = isset($_GET['ks_id']) ? $_GET['ks_id'] : null;
            if ($ks_id != null) {
                $response = $mucKhaoSatModel->getMucKhaoSatByKsId($ks_id);
            }
            break;
        case "getCauHoi":
            $mks_id = isset($_GET['mks_ids']) ? $_GET['mks_ids'] : null;
            $response = $cauHoiModel->getByMucCauHois($mks_id);
            break;
        case "getTraLoi":
            $kqks_ids = $_GET['kqks_ids'];
            $response = $traloiModel->getByKqksIds($kqks_ids);
            break;
        case "create":
            $nguoi_lamks_id = $_GET['nguoi_lamks_id'] ?? null;
            $ks_id = $_GET['ks_id'] ?? null;

            if ($nguoi_lamks_id === null || $ks_id === null) {
                $response = ['error' => 'Thiếu thông tin người làm khảo sát hoặc mã khảo sát'];
            } else {
                $success = $KqKhaoSatModel->create((int)$nguoi_lamks_id, (int)$ks_id);
                $response = $success ? ['success' => true] : ['error' => 'Tạo kết quả khảo sát thất bại'];
            }
            break;
        case "getIdKhaoSat":
            $response = $KqKhaoSatModel->getIdKhaoSat();
            break;
        case "xuatExel":
            if (isset($_GET['ks_id'])) {
                $ks_id = $_GET['ks_id'];
                $spreadsheet = $KqKhaoSatModel->exportSurveyToExcel($ks_id);
            
                if ($spreadsheet) {
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="survey_export_' . $ks_id . '.xlsx"');
                    header('Cache-Control: max-age=0');
            
                    $writer = new Xlsx($spreadsheet);
                    $writer->save('php://output');
                    exit;
                } else {
                    http_response_code(404);
                    echo "Không tìm thấy khảo sát.";
                }
            }
            break;
        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'Lỗi không xác định trong khảo sát.'
            ];
            http_response_code(404);
            break;
    }

    echo json_encode($response);
}
