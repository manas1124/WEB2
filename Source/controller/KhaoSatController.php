<?php

require_once __DIR__ . '/../models/khaoSatModel.php';
require_once __DIR__ . '/../models/cauHoiModel.php';
require_once __DIR__ . '/../models/mucKhaoSatModel.php';
  
  
 header('Content-Type: application/json'); 

if (isset($_POST['func'])) {
    $func = $_POST['func'];
    
    $ksModel = new KhaoSatModel();
    $mucKhaoSatModel = new MucKhaoSatModel();
    $cauHoiModel = new CauHoiModel();

    
    switch ($func) {
        case "getAllKhaoSat":
            $response = $ksModel->getAllKhaoSat();
            break;
        case "getKhaoSatById":
           $id = $data['ks_id']; //lay id tu json

           $response = $ksModel->getKhaoSatById($id);
           break;
        case 'createKhaoSat':
            $data = $_POST['data'];
            $data = json_decode($data,true);
            
            $idNewKs= $ksModel->create(
                $data["ten-ks"],
                $data["date-start"],
                $data["date-end"],
                0,
                $data["nhomks-id"],
                $data["loai-tra-loi"],
                $data["ctdt-id"],
                1
            );

            // tao ra bai khao sat moi thanh cong thi moi tao nội dung
            if ($idNewKs >= 0) {
                $mucArray = $data["content"];
                foreach ( $mucArray as $mucItem ) {
                    $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], 1);
                    $cauHoiArray = $mucItem["questions"];
                    foreach ( $cauHoiArray as $cauHoiItem) {
                        $cauHoiModel->create($cauHoiItem, $newMucId);
                    }
                }
            }
            
            $response =true;
            // $response["test"] =$data["ten-ks"];
            break;
        case "checkExistCtdt":
            $data = $_POST['data'];
            $data = json_decode($data,true);
            $arr = $ksModel->searchCtdt($data["nganh_id"],$data["chu_ki_id"],$data["is_ctdt_daura"]);
            $response = $arr[0]["ctdt_id"]; // tra ve ctdt tim duoc
           
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


/*


*/