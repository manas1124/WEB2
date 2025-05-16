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
            $page = $_POST["number"];
            $searchKeyWord = $_POST["keyword"];

            $response = $ksModel->getKhaoSatByPageNumber($page, null, $searchKeyWord);
            break;
        case 'createKhaoSat':
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isValid = isAuthorization($accessToken, 'create.survey'); // Typo corrected: $isVaid to $isValid
                $isCreateKsSuccess = false;
                if ($isValid) {
                    // Check if $_POST keys exist before accessing them
                    $tenKhaoSat = isset($_POST['ten-ks']) ? $_POST['ten-ks'] : '';
                    $nhomKsId = isset($_POST['nhomks-id']) ? $_POST['nhomks-id'] : '';
                    $dateStart = isset($_POST['date-start']) ? $_POST['date-start'] : '';
                    $dateEnd = isset($_POST['date-end']) ? $_POST['date-end'] : '';
                    $loaiTraLoi = isset($_POST['loai-tra-loi']) ? $_POST['loai-tra-loi'] : '';
                    $isSuDung = isset($_POST['su-dung']) ? $_POST['su-dung'] : '';
                    $ctdtId = isset($_POST['ctdt-id']) ? $_POST['ctdt-id'] : '';

                    //xử lý tạo khảo sát thủ công hoặc nhập file
                    if (isset($_FILES['excelFile'])) {
                        $tmpExcelPath = $_FILES['excelFile']['tmp_name'];
                        require 'xuly_import.php';
                        $convertResult = survey_content_excel_to_json($tmpExcelPath);
                        if ($convertResult["status"] == "error") {
                            $response = [
                                "status" => 'error',
                                "message" => 'Lỗi file import' . $convertResult["message"]
                            ];
                            echo json_encode($response);
                            exit;
                        }
                        $content = $convertResult["data"];
                    } else {
                        $content = json_decode(isset($_POST['content']) ? $_POST['content'] : '[]', true); // Ensure content is an array even if $_POST['content'] is not set
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

                    if ($idNewKs >= 0) {
                        $parentMucArray = $content;
                        foreach ($parentMucArray as $mucItem) {
                            //neu muc cha co cau hoi thi tao cau hoi, nguoc lai neu khong co thi kiem tra muc con
                            $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $idNewKs);
                            $cauHoiArray = $mucItem["questions"];
                            if (count($cauHoiArray) > 0) {
                                foreach ($cauHoiArray as $cauHoiItem) {
                                    $cauHoiModel->create($cauHoiItem, $newMucId);
                                }
                            } else {
                                $subSectionsArray = $mucItem["subSections"];
                                foreach ($subSectionsArray as $subSectionItem) {
                                    $newSubSectionId = $mucKhaoSatModel->create($subSectionItem["sectionName"] ?? '', $idNewKs, $newMucId); // Assuming subSectionItem might have a name
                                    $cauHoiArray = $subSectionItem["questions"];
                                    foreach ($cauHoiArray as $cauHoiItem) {
                                        $cauHoiModel->create($cauHoiItem, $newSubSectionId);
                                    }
                                }
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
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "không có quyền tạo khảo sát"
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "chưa có đăng nhập hoặc không lấy được accessToken trong session :" . ($_SESSION['accessToken'] ?? '') // Use null coalescing operator to avoid potential undefined index for $_SESSION
                ]);
                exit;
            }

        case "checkExistCtdt":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $arr = $ksModel->searchCtdt($data["nganh_id"], $data["chu_ki_id"], $data["is_ctdt_daura"]);
            $response = $arr[0]["ctdt_id"]; // tra ve ctdt tim duoc

            break;
        case "deleteKs":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'delete.survey');
                $isCreateKsSuccess = false;
                if ($isVaid) {
                    $id = $_POST['id'];
                    $response = $ksModel->delete($id);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "chưa có đăng nhập hoặc không lấy được accessToken trong session :" . $_SESSION['accessToken']
                    ]);
                    exit;
                }
            }
            break;
        case "getSurveyFieldAndQuestion":
            $id = $_POST['id'];
            $response = json_decode($surveyModel->getsurveyFieldAndQuestion($id));
            break;

        case "getSurveyContentBySurveyId":
            $ksId = $_POST['ksId'];
            if (!isset($ksId)) {
                echo json_encode([
                    "status" => "error",
                    "message" =>"Don't have right input"]);
                exit;
            }
            $sections = $mucKhaoSatModel->getMucKhaoSatByKsId(22);
            $questions = $mucKhaoSatModel->getQuestionsByKsId(22);

            //map tat ca section theo mau sau
            $sectionMap = [];
            foreach ($sections as $section) {
                $sectionMap[$section['mks_id']] = [
                    'sectionId' => $section['mks_id'],
                    'sectionParentId' => $section['parent_mks_id'],
                    'sectionName' => $section['ten_muc'],
                    'questions' => [],
                    'subSections' => []
                ];
            }

            //map cau hoi vao section
            foreach ($questions as $question) {
                $sectionId = $question['sectionId'];
                if (isset($sectionMap[$sectionId])) {
                    $sectionMap[$sectionId]['questions'][] = [
                        'questionId' => $question['questionId'],
                        'sectionId' => $sectionId,
                        'questionContent' => $question['questionContent']
                    ];
                }
            }
            //create hierarchy for parent-child section json
            $mockSurveyContent = [];
            foreach ($sectionMap as $mks_id => $section) {
                if ($section['sectionParentId'] === null) {
                    $mockSurveyContent[] = &$sectionMap[$mks_id];
                } else {
                    $parentId = $section['sectionParentId'];
                    if (isset($sectionMap[$parentId])) {
                        $sectionMap[$parentId]['subSections'][] = &$sectionMap[$mks_id];
                    }
                }
            }

            // Output the JSON
            // echo json_encode($mockSurveyContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $response = $mockSurveyContent;
            if ($mockSurveyContent == null) {
                echo json_encode([
                    "status" => "error",
                    "message" => "error in getSurveyContentBySurveyId khaosatcontroller"
                ]);
            } else {
                echo json_encode([
                    "status" => "success",
                    "data" => $mockSurveyContent
                ]);

            }
            exit;
        case "updateKhaoSat":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'edit.survey');
                $isCreateKsSuccess = false;
                if ($isVaid) {
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
                        $parrentMucArray = $data["content"];
                        foreach ($parrentMucArray as $mucItem) {
                            $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $data["ks-id"]);
                            $cauHoiArray = $mucItem["questions"];
                            foreach ($cauHoiArray as $cauHoiItem) {
                                $cauHoiModel->create($cauHoiItem, $newMucId);
                            }
                        }

                    }
                    $response = $isUpdateSuccess;
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "chưa có đăng nhập hoặc không lấy được accessToken trong session :" . $_SESSION['accessToken']
                    ]);
                    exit;
                }
            }
            break;
        case "updateTrangThaiSuDungKhaoSat":
            if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                $accessToken = $_SESSION['accessToken'];
                $isVaid = isAuthorization($accessToken, 'delete.survey');
                $isCreateKsSuccess = false;
                if ($isVaid) {
                    $ksId = $_POST['ks-id'];
                    $suDungStatus = $_POST['su-dung-status'];

                    if (!isset($_POST['ks-id']) || !isset($_POST['su-dung-status'])) {
                        echo json_encode(
                            [
                                'status' => 'error',
                                'message' => "Lỗi khi nhận thông tin cập nhật trạng thái sử dụng của khảo sát '$ksId $suDungStatus'",
                            ]
                        );
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
                            ]
                        );
                        exit;
                    } else {
                        echo json_encode(
                            [
                                'status' => 'error',
                                'message' => 'Lỗi cập nhật trạng thái sử dụng',
                            ]
                        );
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "chưa có đăng nhập hoặc không lấy được accessToken trong session :" . $_SESSION['accessToken']
                    ]);
                    exit;
                }
            }
            break;
        case "getAllKhaoSatFilter":
            if (isset($_POST['ks_ids'])) {
                $filters = [
                    'txt_search' => !empty($_POST['txt_search']) ? $_POST['txt_search'] : null,
                    'ngay_bat_dau' => !empty($_POST['ngay_bat_dau']) ? $_POST['ngay_bat_dau'] : null,
                    'ngay_ket_thuc' => !empty($_POST['ngay_ket_thuc']) ? $_POST['ngay_ket_thuc'] : null,
                    'nks_id' => isset($_POST['nks_id']) && $_POST['nks_id'] !== '' ? (int) $_POST['nks_id'] : null,
                    'nganh' => isset($_POST['nganh']) && $_POST['nganh'] !== '' ? (int) $_POST['nganh'] : null,
                    'chuky' => isset($_POST['chuky']) && $_POST['chuky'] !== '' ? (int) $_POST['chuky'] : null,
                ];

                $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
                $ks_ids = json_decode($_POST['ks_ids'], true);
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