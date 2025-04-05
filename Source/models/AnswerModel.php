<?php
    class AnswerModel {
        private $db;
        public function __construct()
        {
            $this->db = new MyConnection();
        }
        public function createAnswer($data) {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("INSERT INTO tra_loi (ket_qua, ch_id, kq_ks_id, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $data['ket_qua'], $data['ch_id'], $data['kqks_id'], $data['status']);
            if ($stmt->execute()) {
                return [
                    'id' => $conn->insert_id,
                    'ket_qua' => $data['ket_qua'],
                    'ch_id' => $data['ch_id'],
                    'kq_ks_id' => $data['kqks_id'],
                    'status' => $data['status'],
                ];
            } else {
                return null;
            }
        }
    }

?>