<?php

require_once __DIR__ . '/database.php';

class QuyenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM quyen WHERE status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getAllpaging($page, $status = null)
    {
        $limit = 10;
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM quyen WHERE 1=1";
        $countSql = "SELECT COUNT(*) as total FROM quyen WHERE 1=1";

        $params = [];
        $types = "";

        if ($status !== null) {
            $sql .= " AND status = ?";
            $countSql .= " AND status = ?";
            $params[] = $status;
            $types .= "i";
        }

        $countStmt = $conn->prepare($countSql);
        if (!empty($params)) {
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRow = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRow / $limit);
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'data' => $data
        ];
    }

    public function getById($quyen_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM quyen WHERE quyen_id = ?");
        $stmt->bind_param("i", $quyen_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function create($ten_quyen, $status = 1)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO quyen (ten_quyen, status) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ten_quyen, $status);

        return $stmt->execute();
    }

    public function update($quyen_id, $ten_quyen, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE quyen SET ten_quyen = ?, status = ? WHERE quyen_id = ?");
        $stmt->bind_param("sii", $ten_quyen, $status, $quyen_id);

        return $stmt->execute();
    }
}
