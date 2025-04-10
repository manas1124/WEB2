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
        $stmt = $conn->prepare("INSERT INTO chu_ki (ten_ck, status) VALUES (?, ?)");
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
                FROM chu_ki
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

    public function getAllpaging($page = 1, $status = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM chu_ki WHERE 1=1";

        // Đếm tổng số dòng (để tính tổng số trang)
        $countSql = "SELECT COUNT(*) as total FROM chu_ki WHERE 1=1";
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

        // Truy vấn dữ liệu trang hiện tại

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
        $finaldata = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'data' => $data
        ];
        return $finaldata;
    }



    // Lấy thông tin chu kỳ theo ID
    public function getById($ck_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM chu_ki WHERE ck_id = ?");
        $stmt->bind_param("i", $ck_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // Cập nhật thông tin chu kỳ
    public function update($ck_id, $ten_chu_ky, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE chu_ki SET ten_ck = ?, status = ? WHERE ck_id = ?");
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
        $stmt = $conn->prepare("UPDATE chu_ki SET status = NOT status WHERE ck_id = ?");
        $stmt->bind_param("i", $ck_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
