<?php

require_once __DIR__ . '/database.php';

class CtdtDauraModel {
    private $db; // Kết nối database

    public function __construct() {
        $this->db = new MyConnection(); // Tạo một kết nối database
    }

    // Thêm dữ liệu
    public function create($file_path, $nganh_id, $ck_id, $la_ctdt, $status) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO ctdt_daura (file_path, nganh_id, ck_id, la_ctdt, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiii", $file_path, $nganh_id, $ck_id, $la_ctdt, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Lấy tất cả dữ liệu
    public function getAll() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.*, n.ten_nganh, ck.ten_ck 
                                FROM ctdt_daura c
                                LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                                LEFT JOIN chuyen_khoa ck ON c.ck_id = ck.ck_id");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    "ctdt_id" => $row['ctdt_id'],
                    "file_path" => $row['file_path'],
                    "nganh" => [
                        "nganh_id" => $row['nganh_id'],
                        "ten_nganh" => $row['ten_nganh']
                    ],
                    "chuyen_khoa" => [
                        "ck_id" => $row['ck_id'],
                        "ten_ck" => $row['ten_ck']
                    ],
                    "la_ctdt" => $row['la_ctdt'],
                    "status" => $row['status']
                ];
            }
        }
        return json_encode($data);
    }

    // Lấy dữ liệu theo ID
    public function getById($ctdt_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.*, n.ten_nganh, ck.ten_ck 
                                FROM ctdt_daura c
                                LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                                LEFT JOIN chuyen_khoa ck ON c.ck_id = ck.ck_id
                                WHERE c.ctdt_id = ?");
        $stmt->bind_param("i", $ctdt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return json_encode([
                "ctdt_id" => $row['ctdt_id'],
                "file_path" => $row['file_path'],
                "nganh" => [
                    "nganh_id" => $row['nganh_id'],
                    "ten_nganh" => $row['ten_nganh']
                ],
                "chuyen_khoa" => [
                    "ck_id" => $row['ck_id'],
                    "ten_ck" => $row['ten_ck']
                ],
                "la_ctdt" => $row['la_ctdt'],
                "status" => $row['status']
            ]);
        } else {
            return false;
        }
    }

    // Cập nhật dữ liệu
    public function update($ctdt_id, $file_path, $nganh_id, $ck_id, $la_ctdt, $status) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE ctdt_daura 
                                SET file_path = ?, nganh_id = ?, ck_id = ?, la_ctdt = ?, status = ? 
                                WHERE ctdt_id = ?");
        $stmt->bind_param("siiiii", $file_path, $nganh_id, $ck_id, $la_ctdt, $status, $ctdt_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Xóa dữ liệu
    public function delete($ctdt_id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM ctdt_daura WHERE ctdt_id = ?");
        $stmt->bind_param("i", $ctdt_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
