<?php

require_once __DIR__ . '/database.php';

class ChuKyModel
{
    private $db; // Kết nối database

    public function __construct()
    {
        $this->db = new MyConnection(); // Tạo một kết nối database
    }

    // Thêm dữ liệu
    public function create($ten_chu_ky, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO chu_ky (ten_chu_ky, status) VALUES (?, ?)");
        $stmt->bind_param("si", $ten_chu_ky, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                FROM chu_ky
                WHERE status = 1";
        $stmt = $conn->prepare($sql);
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

    // Lấy tất cả chu kỳ
    public function getAllpaging($page, $status = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                                        FROM chu_ky
                                        WHERE 1=1";
        $params = [];
        $types = "";
        if ($status !== null) {
            $sql .= " AND status = ?";
            $params[] = $status;
            $types .= "i";
        }
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
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



    // Lấy thông tin chu kỳ theo ID
    public function getById($ck_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM chu_ky WHERE ck_id = ?");
        $stmt->bind_param("i", $ck_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        } else {
            return false;
        }
    }

    // Cập nhật thông tin chu kỳ
    public function update($ck_id, $ten_chu_ky, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE chu_ky SET ten_chu_ky = ?, status = ? WHERE ck_id = ?");
        $stmt->bind_param("sii", $ten_chu_ky, $status, $ck_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function toggleStatus($ck_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE chu_ky SET status = NOT status WHERE ck_id = ?");
        $stmt->bind_param("i", $ck_id);

        return $stmt->execute();
    }
}
