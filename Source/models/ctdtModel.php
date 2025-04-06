<?php

require_once __DIR__ . '/database.php';

class CtdtDauraModel
{
    private $db; // Kết nối database

    public function __construct()
    {
        $this->db = new MyConnection(); // Tạo một kết nối database
    }

    // Thêm dữ liệu
    public function create($file_path, $nganh_id, $ck_id, $la_ctdt, $status)
    {
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
    public function getAll()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.*, n.ten_nganh, ck.ten_ck 
                                FROM ctdt_daura c
                                LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                                LEFT JOIN chuyen_khoa ck ON c.ck_id = ck.ck_id
                                WHERE c.status = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    "ctdt_id" => $row['ctdt_id'],
                    "file_path" => $row['file_path'],
                    "nganh_id" => $row['nganh_id'],
                    "ten_nganh" => $row['ten_nganh'],
                    "ck_id" => $row['ck_id'],
                    "ten_ck" => $row['ten_ck'],
                    "la_ctdt" => $row['la_ctdt'],
                    "status" => $row['status']
                ];
            }
        }
        return json_encode($data);
    }

    public function getAllpaging($page, $nganh_id = null, $ck_id = null, $la_ctdt = null, $status = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $conn = $this->db->getConnection();

        $sql = "SELECT c.*, n.ten_nganh, ck.ten_ck 
                FROM ctdt_daura c
                LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                LEFT JOIN chuyen_khoa ck ON c.ck_id = ck.ck_id
                WHERE 1=1";

        $params = [];
        $types = "";

        // Thêm điều kiện nếu có
        if ($nganh_id !== null) {
            $sql .= " AND c.nganh_id = ?";
            $params[] = $nganh_id;
            $types .= "i";
        }

        if ($ck_id !== null) {
            $sql .= " AND c.ck_id = ?";
            $params[] = $ck_id;
            $types .= "i";
        }

        if ($la_ctdt !== null) {
            $sql .= " AND c.la_ctdt = ?";
            $params[] = $la_ctdt;
            $types .= "i";
        }

        if ($status !== null) {
            $sql .= " AND c.status = ?";
            $params[] = $status;
            $types .= "i";
        }

        // Thêm phân trang
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt = $conn->prepare($sql);

        // Gán tham số
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    "ctdt_id" => $row['ctdt_id'],
                    "file_path" => $row['file_path'],
                    "nganh_id" => $row['nganh_id'],
                    "ten_nganh" => $row['ten_nganh'],
                    "ck_id" => $row['ck_id'],
                    "ten_ck" => $row['ten_ck'],
                    "la_ctdt" => $row['la_ctdt'],
                    "status" => $row['status']
                ];
            }
        }

        return json_encode($data);
    }

    public function getFilteredCount($nganh_id = null, $ck_id = null, $la_ctdt = null, $status = null)
    {
        $conn = $this->db->getConnection();

        $sql = "SELECT COUNT(*) as total FROM ctdt_daura WHERE 1=1";
        $params = [];
        $types = "";

        if ($nganh_id !== null) {
            $sql .= " AND nganh_id = ?";
            $params[] = $nganh_id;
            $types .= "i";
        }

        if ($ck_id !== null) {
            $sql .= " AND ck_id = ?";
            $params[] = $ck_id;
            $types .= "i";
        }

        if ($la_ctdt !== null) {
            $sql .= " AND la_ctdt = ?";
            $params[] = $la_ctdt;
            $types .= "i";
        }

        if ($status !== null) {
            $sql .= " AND status = ?";
            $params[] = $status;
            $types .= "i";
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Lấy dữ liệu theo ID
    public function getById($ctdt_id)
    {
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
                "nganh_id" => $row['nganh_id'],
                "ten_nganh" => $row['ten_nganh'],
                "ck_id" => $row['ck_id'],
                "ten_ck" => $row['ten_ck'],
                "la_ctdt" => $row['la_ctdt'],
                "status" => $row['status']
            ]);
        } else {
            return false;
        }
    }

    // Cập nhật dữ liệu
    public function update($ctdt_id, $file_path, $nganh_id, $ck_id, $la_ctdt, $status)
    {
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
    public function toggleStatus($ctdt_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE ctdt_daura SET status = NOT status WHERE ctdt_id = ?");
        $stmt->bind_param("i", $ctdt_id);

        return $stmt->execute();
    }
}
