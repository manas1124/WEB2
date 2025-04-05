<?php
    require_once __DIR__ . '/database.php';
    class SurveyResultModel {
        private $db;
        public function __construct()
        {
            $this->db = new MyConnection();
        }

        public function createResult($data) {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("INSERT INTO kq_khao_sat (nguoi_lamks_id, ks_id, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $data['dt_id'], $data['ks_id'], $data['status']);
            if ($stmt->execute()) {
                return [
                    'id' => $conn->insert_id,
                    'nguoi_lamks_id' => $data['dt_id'],
                    'ks_id' => $data['ks_id'],
                    'status' => $data['ks_id'],    
                ];
            } else {
                return null;
            }
        }
    }

?>