<?php

require_once __DIR__ . '/database.php';

class NganhModel
{

    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                FROM nganh
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

    public function getAllpaging($page, $status = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();
        $sql = "SELECT * 
                                        FROM nganh
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

    public function getById($nganh_id)
    {
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

    public function create($ten_nganh, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO nganh (ten_nganh, status) VALUES (?, ?)");
        $stmt->bind_param("si", $ten_nganh, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($nganh_id, $ten_nganh, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE nganh SET ten_nganh = ?, status = ? WHERE nganh_id = ?");
        $stmt->bind_param("sii", $ten_nganh, $status, $nganh_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function toggleStatus($nganh_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE nganh SET status = NOT status WHERE nganh_id = ?");
        $stmt->bind_param("i", $nganh_id);

        return $stmt->execute();
    }


}
