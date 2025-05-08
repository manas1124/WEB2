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
    public function create($file, $nganh_id, $ck_id, $la_ctdt, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO ctdt_daura (file, nganh_id, ck_id, la_ctdt, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiii", $file, $nganh_id, $ck_id, $la_ctdt, $status);

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
                                LEFT JOIN chu_ki ck ON c.ck_id = ck.ck_id
                                WHERE c.status = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    "ctdt_id" => $row['ctdt_id'],
                    "file" => $row['file'],
                    "nganh_id" => $row['nganh_id'],
                    "ten_nganh" => $row['ten_nganh'],
                    "ck_id" => $row['ck_id'],
                    "ten_ck" => $row['ten_ck'],
                    "la_ctdt" => $row['la_ctdt'],
                    "status" => $row['status']
                ];
            }
        }
        return $data;
    }

    public function getAllpaging($page = 1, $nganh_id = null, $ck_id = null, $la_ctdt = null, $status = null, $txt_search = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $conn = $this->db->getConnection();

        $sql = "SELECT c.*, n.ten_nganh, ck.ten_ck 
            FROM ctdt_daura c
            LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
            LEFT JOIN chu_ki ck ON c.ck_id = ck.ck_id
            WHERE 1=1";

        $conditions = "";
        $params = [];
        $types = "";

        if ($nganh_id !== null) {
            $conditions .= " AND c.nganh_id = ?";
            $params[] = $nganh_id;
            $types .= "i";
        }

        if ($ck_id !== null) {
            $conditions .= " AND c.ck_id = ?";
            $params[] = $ck_id;
            $types .= "i";
        }

        if ($la_ctdt !== null) {
            $conditions .= " AND c.la_ctdt = ?";
            $params[] = $la_ctdt;
            $types .= "i";
        }

        if ($status !== null) {
            $conditions .= " AND c.status = ?";
            $params[] = $status;
            $types .= "i";
        }

        if ($txt_search !== null && $txt_search !== "") {
            $conditions .= " AND (ck.ten_ck LIKE ? OR n.ten_nganh LIKE ? OR c.file LIKE ? OR c.ctdt_id LIKE ?)";
            $searchParam = "%" . $txt_search . "%";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "ssss";
        }

        // Đếm tổng số bản ghi
        $countSql = "SELECT COUNT(*) AS total 
                 FROM ctdt_daura c
                 LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                 LEFT JOIN chu_ki ck ON c.ck_id = ck.ck_id
                 WHERE 1=1" . $conditions;

        $countStmt = $conn->prepare($countSql);
        if (!empty($params)) {
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRecord = $countResult->fetch_assoc()['total'];
        $totalPage = ceil($totalRecord / $limit);

        // Truy vấn dữ liệu có phân trang
        $sql .= $conditions . " ORDER BY c.ctdt_id DESC LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "ctdt_id" => $row['ctdt_id'],
                "file" => $row['file'],
                "nganh_id" => $row['nganh_id'],
                "ten_nganh" => $row['ten_nganh'],
                "ck_id" => $row['ck_id'],
                "ten_ck" => $row['ten_ck'],
                "la_ctdt" => $row['la_ctdt'],
                "status" => $row['status']
            ];
        }

        return [
            "data" => $data,
            "currentPage" => $page,
            "totalPages" => $totalPage
        ];
    }



    // Lấy dữ liệu theo ID
    public function getById($ctdt_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT c.*, n.ten_nganh, ck.ten_ck 
                                FROM ctdt_daura c
                                LEFT JOIN nganh n ON c.nganh_id = n.nganh_id
                                LEFT JOIN chu_ki ck ON c.ck_id = ck.ck_id
                                WHERE c.ctdt_id = ?");
        $stmt->bind_param("i", $ctdt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = [
                "ctdt_id" => $row['ctdt_id'],
                "file" => $row['file'],
                "nganh_id" => $row['nganh_id'],
                "ten_nganh" => $row['ten_nganh'],
                "ck_id" => $row['ck_id'],
                "ten_ck" => $row['ten_ck'],
                "la_ctdt" => $row['la_ctdt'],
                "status" => $row['status']
            ];
            return $data;
        } else {
            return false;
        }
    }

    // Cập nhật dữ liệu
    public function update($ctdt_id, $file, $nganh_id, $ck_id, $la_ctdt, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE ctdt_daura 
                                SET file = ?, nganh_id = ?, ck_id = ?, la_ctdt = ?, status = ? 
                                WHERE ctdt_id = ?");
        $stmt->bind_param("siiiii", $file, $nganh_id, $ck_id, $la_ctdt, $status, $ctdt_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function toggleStatus($ctdt_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE ctdt_daura SET status = NOT status WHERE ctdt_id = ?");
        $stmt->bind_param("i", $ctdt_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isExist($nganh_id, $ck_id, $la_ctdt)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT 1 FROM ctdt_daura WHERE nganh_id = ? AND ck_id = ? AND la_ctdt = ?");
        $stmt->bind_param("iii", $nganh_id, $ck_id, $la_ctdt);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
