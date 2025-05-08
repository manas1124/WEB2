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
        return $data;
    }

    public function getAllpaging($page = 1, $status = null, $txt_search = null)
    {
        $limit = 8;
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM nganh WHERE 1=1";
        $countSql = "SELECT COUNT(*) as total FROM nganh WHERE 1=1";

        $params = [];
        $types = "";

        if ($status !== null) {
            $sql .= " AND status = ?";
            $countSql .= " AND status = ?";
            $params[] = $status;
            $types .= "i";
        }

        if (!empty($txt_search)) {
            $sql .= " AND (nganh_id LIKE ? OR ten_nganh LIKE ?)";
            $countSql .= " AND (nganh_id LIKE ? OR ten_nganh LIKE ?)";
            $like_search = "%" . $txt_search . "%";
            $params[] = $like_search;
            $params[] = $like_search;
            $types .= "ss";
        }

        // Đếm tổng số dòng
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

        // Truy vấn dữ liệu trang hiện tại
        $sql .= " ORDER BY nganh_id DESC LIMIT ?, ?";
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


    public function getById($nganh_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM nganh WHERE nganh_id = ?");
        $stmt->bind_param("i", $nganh_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function create($ten_nganh, $status = 1)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO nganh (ten_nganh, status) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
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

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isExist($ten_nganh, $nganh_id = null)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT 1 FROM nganh WHERE ten_nganh = ?";
        if ($nganh_id != null) {
            $sql .= " AND nganh_id != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $ten_nganh, $nganh_id);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $ten_nganh);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
