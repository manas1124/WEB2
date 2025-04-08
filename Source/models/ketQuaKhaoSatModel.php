<?php

require_once __DIR__ . '/database.php';

class ketQuaKhaoSatModel
{

    // kq_khao_sat
    // `kqks_id` int NOT NULL,
    // `nguoi_lamks_id` int DEFAULT NULL,
    // `ks_id` int DEFAULT NULL COMMENT 'id cua bai khao sat',
    // `status` tinyint(1) DEFAULT NULL,
    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                FROM kq_khao_sat";
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

    public function getAllpaging($page, $status = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                                        FROM kq_khao_sat
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

    public function getById($kqks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM kq_khao_sat WHERE kqks_id = ?");
        $stmt->bind_param("i", $kqks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        } else {
            return false;
        }
    }
}
