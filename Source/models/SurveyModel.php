<?php
require_once __DIR__ . '/database.php';

class SurveyModel
{
    private $db;
    public function __construct()
    {
        $this->db = new MyConnection();
    }


    public function getAllSurveys()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat ");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $this->db->closeConnection();
        // return data as string json
        return json_encode($data);
    }

    public function getsurveyFieldAndQuestion($id) {
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("SELECT mks.mks_id, mks.ten_muc, ch.noi_dung, ch.ch_id 
                            FROM khao_sat ks 
                            JOIN muc_khao_sat mks ON ks.ks_id = mks.ks_id 
                            JOIN cau_hoi ch ON mks.mks_id = ch.mks_id
                            WHERE ks.ks_id = ? AND mks.status = 1 AND ch.status = 1 AND ks.status = 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mks_id = $row['mks_id'];

            // Nếu chưa có $mks_id trong mảng, tạo phần tử mới
            if (!isset($data[$mks_id])) {
                $data[$mks_id] = [
                    'ten_muc' => $row['ten_muc'],
                    'cau_hoi' => []
                ];
            }

            // Thêm câu hỏi vào danh sách "cau_hoi"
            $data[$mks_id]['cau_hoi'][] = [
                'ch_id' => $row['ch_id'],
                'noi_dung' => $row['noi_dung'],
            ];
        }
    }

    $this->db->closeConnection();
    return json_encode($data);
}

}
