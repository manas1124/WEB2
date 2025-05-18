<?php
require_once __DIR__ . '/database.php';

class SurveyModel
{
    private $db;
    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function isExistUserDaLamKhaoSat($user_id, $ks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM kq_khao_sat WHERE nguoi_lamks_id = ? and ks_id = ? ");
        $stmt->bind_param("ss", $user_id, $ks_id);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllSurveys()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT ks.*, nks.ten_nks
                                        FROM khao_sat ks
                                        JOIN nhom_khao_sat nks ON ks.nks_id = nks.nks_id
                                        WHERE ks.status = 1
                                        ORDER BY ks.ks_id DESC;");
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

    public function getSurveyFieldAndQuestion($mksParentId, $isParent = false)
    {
        $conn = $this->db->getConnection();
        $column = $isParent ? 'mks.parent_mks_id' : 'mks.mks_id';
        $stmt = $conn->prepare("SELECT mks.mks_id, mks.ten_muc, ch.noi_dung, ch.ch_id 
                                FROM khao_sat ks 
                                JOIN muc_khao_sat mks ON ks.ks_id = mks.ks_id 
                                JOIN cau_hoi ch ON mks.mks_id = ch.mks_id
                                WHERE $column = ? AND mks.status = 1 AND ch.status = 1 AND ks.status = 1");
        $stmt->bind_param("i", $mksParentId);
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

    


    public function getAllParent($ksId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM muc_khao_sat 
                                WHERE ks_id = ? AND status = 1");
        $stmt->bind_param("i", $ksId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $this->db->closeConnection();
        return json_encode($data);
        
    }

    public function isExistsParent($mksId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM muc_khao_sat 
                                WHERE parent_mks_id = ? AND status = 1");
        $stmt->bind_param("i", $mksId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
