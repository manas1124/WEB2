<?php

require_once __DIR__ . '/../models/khaoSatModel.php';
require_once __DIR__ . '/../models/cauHoiModel.php';
require_once __DIR__ . '/../models/mucKhaoSatModel.php';
require_once __DIR__ . '/../models/SurveyModel.php';
require_once __DIR__ . '/../utils/JwtUtil.php';
header('Content-Type: application/json');

if (isset($_POST['func'])) {
    session_start();
    $func = $_POST['func'];
    $ksModel = new KhaoSatModel();
    $mucKhaoSatModel = new MucKhaoSatModel();
    $cauHoiModel = new CauHoiModel();
    $surveyModel = new SurveyModel();

    switch ($func) {
        case "getAllKhaoSat":
            $response = $ksModel->getAllKhaoSat();
            break;
        case "getChiTietKsById":
            $id = $_POST['id'];
            $response = $ksModel->getKhaoSatById($id);
            // $response = $ksModel->getAllKhaoSat();
            break;
        case "getKhaoSatByPageNumber":
            $page = $_POST["number"] ;
            $searchKeyWord = $_POST["keyword"];
            
            $response = $ksModel->getKhaoSatByPageNumber($page,null,$searchKeyWord);
            break;
        case 'createKhaoSat':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'create.survey');
                $isCreateKsSuccess = false;
                if ($isVaid) {
                    $tenKhaoSat = $_POST['ten-ks'];
                    $nhomKsId = $_POST['nhomks-id'];
                    $dateStart = $_POST['date-start'];
                    $dateEnd = $_POST['date-end'];
                    $loaiTraLoi = $_POST['loai-tra-loi'];
                    $isSuDung = $_POST['su-dung'];
                    $ctdtId = $_POST['ctdt-id'];

                    //xử lý tạo khảo sát thủ công hoặc nhập file
                    if (isset($_FILES['excelFile'])) {
                        $tmpExcelPath = $_FILES['excelFile']['tmp_name'];
                        require 'xuly_import.php';
                        $convertResult = survey_content_excel_to_json($tmpExcelPath);             
                        if ($convertResult["status"] == "error") {
                            $response = [
                                "status" => 'error',
                                "message" =>'Lỗi file import'. $convertResult["message"]
                            ];
                            echo json_encode($response);
                            exit;
                        }
                        $content = $convertResult["data"];
                    }
                    else {
                        $content = json_decode($_POST['content'], true);
                    }

                    $idNewKs = $ksModel->create(
                        $tenKhaoSat,
                        $dateStart,
                        $dateEnd,
                        $isSuDung,
                        $nhomKsId,
                        $loaiTraLoi,
                        $ctdtId,
                        1
                    );
                    // tao ra bai khao sat moi thanh cong thi moi tao nội dung
                    if ($idNewKs >= 0) {
                        $mucArray = $content;
                        foreach ($mucArray as $mucItem) {
                            $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $idNewKs);
                            $cauHoiArray = $mucItem["questions"];
                            foreach ($cauHoiArray as $cauHoiItem) {
                                $cauHoiModel->create($cauHoiItem, $newMucId);
                            }
                        }
                        echo json_encode([
                                "status" => "success",
                                "message" => "Tạo khảo sát thành công"
                            ]);
                        exit;
                    } else {
                        echo json_encode([
                                "status" => "error",
                                "message" => "Tạo khảo sát lỗi, model tạo câu hỏi, mục"
                            ]);
                        exit;
                    } 
                }else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "không có quyền tạo khảo sát"
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "chưa có đăng nhập hoặc không lấy được accessToken trong session :".$_SESSION['accessToken']
                ]);
                exit;
            }
        case "checkExistCtdt":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $arr = $ksModel->searchCtdt($data["nganh_id"], $data["chu_ki_id"], $data["is_ctdt_daura"]);
            $response = $arr[0]["ctdt_id"]; // tra ve ctdt tim duoc

            break;
        case "deleteKs" : 
            $id = $_POST['id'];
            $response = $ksModel->delete($id);
            break;
        case "getSurveyFieldAndQuestion":
            $id = $_POST['id'];
            $response = json_decode($surveyModel->getsurveyFieldAndQuestion($id));
            break;
        case "updateKhaoSat":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $isUpdateSuccess = $ksModel->update(
                $data["ks-id"],
                $data["ten-ks"],
                $data["date-start"],
                $data["date-end"],
                $data["su-dung"],
                $data["nhomks-id"],
                $data["loai-tra-loi"],
                $data["ctdt-id"],
                1
            );
            if ($isUpdateSuccess) {
                //delete old section and question
                $oldMucKs = $mucKhaoSatModel->getMucKhaoSatByKsId($data["ks-id"]);
                foreach ($oldMucKs as $oldMucKsItem) {
                    $mucKhaoSatModel->delete($oldMucKsItem["mks_id"]);
                    $cauHoiModel->deleteByMksId($oldMucKsItem["mks_id"]);
                }
                //tao lại nội dung mới
                $mucArray = $data["content"];
                foreach ($mucArray as $mucItem) {
                    $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $data["ks-id"]);
                    $cauHoiArray = $mucItem["questions"];
                    foreach ($cauHoiArray as $cauHoiItem) {
                        $cauHoiModel->create($cauHoiItem, $newMucId);
                    }
                }
                
            }
            $response = $isUpdateSuccess;
            break;
        case "updateTrangThaiSuDungKhaoSat":
            $ksId = $_POST['ks-id'];
            $suDungStatus = $_POST['su-dung-status'];

            if (!isset($_POST['ks-id']) || !isset($_POST['su-dung-status'])) {
                 echo json_encode( 
                [
                    'status' => 'error',
                    'message' => "Lỗi khi nhận thông tin cập nhật trạng thái sử dụng của khảo sát '$ksId $suDungStatus'",
                ]);
                exit;
            }
            $isUpdateSuccess = $ksModel->updateSurveyTrangThaiSuDung(
                $ksId,
                $suDungStatus,
            );
            if ($isUpdateSuccess) {
                echo json_encode( 
                [
                    'status' => 'success',
                    'message' => 'Cập nhật trạng thái sử dụng thành công',
                ]);   
                exit;
            } else {
                echo json_encode( 
                [
                    'status' => 'error',
                    'message' => 'Lỗi cập nhật trạng thái sử dụng',
                ]);
            }
            break;
        case "getAllKhaoSatFilter":
            if (isset($_POST['ks_ids'])) {
                $filters = [
                    'txt_search'        => !empty($_POST['txt_search']) ? $_POST['txt_search'] : null,
                    'ngay_bat_dau'  => !empty($_POST['ngay_bat_dau']) ? $_POST['ngay_bat_dau'] : null,
                    'ngay_ket_thuc' => !empty($_POST['ngay_ket_thuc']) ? $_POST['ngay_ket_thuc'] : null,
                    'nks_id'        => isset($_POST['nks_id']) && $_POST['nks_id'] !== '' ? (int)$_POST['nks_id'] : null,
                    'nganh'        => isset($_POST['nganh']) && $_POST['nganh'] !== '' ? (int)$_POST['nganh'] : null,
                    'chuky'       => isset($_POST['chuky']) && $_POST['chuky'] !== '' ? (int)$_POST['chuky'] : null,
                ];

                $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
                $ks_ids = isset($_POST['ks_ids']) ? json_decode($_POST['ks_ids'], true) : null;
                $data = $ksModel->getAllKhaoSatFilter($filters, $page, $ks_ids);
                $response = [
                    'status' => true,
                    'data' => $data
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => "khong nhan duoc ks_ids"
                ];
            }
            break;
        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'khong tìm thấy hàm trong khao sat model.',
                'html' => "Loi tạo khảo sat"
            ];
            http_response_code(404); // Set a 404 status code for not found
            break;
    }
    echo json_encode($response);
}