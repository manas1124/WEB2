<?php

require_once __DIR__ . '/database.php';

class NganhModel {
    private $db; // Kết nối database

    public function __construct() {
        $this->db = new MyConnection(); // Tạo một kết nối database
    }

    // Thêm dữ liệu
    public function create($ten_nganh, $mo_ta, $status) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO nganh (ten_nganh, status) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $ten_nganh, $mo_ta, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Lấy tất cả ngành
    public function getAll() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM nganh");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return json_encode($data);
    }

    // Lấy thông tin ngành theo ID
    public function getById($nganh_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM nganh WHERE nganh_id = ?");
        $stmt->bind_param("i", $nganh_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        } else {
            return false;
        }
    }

    // Cập nhật thông tin ngành
    public function update($nganh_id, $ten_nganh, $mo_ta, $status) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE nganh SET ten_nganh = ?, status = ? WHERE nganh_id = ?");
        $stmt->bind_param("ssii", $ten_nganh, $mo_ta, $status, $nganh_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Xóa ngành theo ID
    public function delete($nganh_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM nganh WHERE nganh_id = ?");
        $stmt->bind_param("i", $nganh_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
