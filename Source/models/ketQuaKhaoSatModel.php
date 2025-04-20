<?php

require_once __DIR__ . '/database.php';

class KqKhaoSatModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM kq_khao_sat";
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

    public function getAllByKsId($page = 1, $ks_id)
    {
        if ($ks_id === null) {
            return [
                'error' => 'Thiếu tham số ks_id',
                'data' => [],
                'totalPages' => 0,
                'currentPage' => $page
            ];
        }
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();

        $condition = "WHERE status = 1 AND ks_id = ?";

        // Đếm tổng số dòng
        $countSql = "SELECT COUNT(*) AS total FROM kq_khao_sat " . $condition;
        $countStmt = $conn->prepare($countSql);
        $countStmt->bind_param("i", $ks_id);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRecords = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRecords / $limit);
        $countStmt->close();

        // Lấy dữ liệu có phân trang
        $sql = "SELECT * FROM kq_khao_sat " . $condition . " LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $ks_id, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return [
            'data' => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function getById($kqks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM kq_khao_sat WHERE kqks_id = ?");
        $stmt->bind_param("i", $kqks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function create($nguoi_lamks_id, $ks_id, $status = 1)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO kq_khao_sat (nguoi_lamks_id, ks_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $nguoi_lamks_id, $ks_id, $status);

        return $stmt->execute();
    }


    public function totalKQKhaoSat($ks_id)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT COUNT(*) as total FROM kq_khao_sat WHERE ks_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }
}
