<?php
require_once __DIR__ . '/database.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DoiTuongModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM doi_tuong";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
    public function getAllpaging($page, $limit = 10, $search = '', $nhomKs = null, $loaiDtId = null, $ctdtId = null)
    {
        $conn = $this->db->getConnection();

        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM doi_tuong 
            WHERE (ho_ten LIKE ? OR email LIKE ? OR diachi LIKE ? OR dien_thoai LIKE ?)";

        $params = [];
        $types = "ssss";
        $params[] = "%" . $search . "%";
        $params[] = "%" . $search . "%";
        $params[] = "%" . $search . "%";
        $params[] = "%" . $search . "%";

        if ($nhomKs !== null) {
            $sql .= " AND nhom_ks = ?";
            $params[] = $nhomKs;
            $types .= "i";
        }
        if ($loaiDtId !== null) {
            $sql .= " AND loai_dt_id = ?";
            $params[] = $loaiDtId;
            $types .= "i";
        }
        if ($ctdtId !== null) {
            $sql .= " AND ctdt_id = ?";
            $params[] = $ctdtId;
            $types .= "i";
        }

        $sql .= " LIMIT ?, ?";

        $stmt = $conn->prepare($sql);

        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt->bind_param($types, ...$params);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $countSql = "SELECT COUNT(*) AS total FROM doi_tuong WHERE (ho_ten LIKE ? OR email LIKE ? OR diachi LIKE ? OR dien_thoai LIKE ?)";

        // Mảng tham số cho câu truy vấn đếm
        $countParams = [];
        $countTypes = "ssss"; // Các tham số tìm kiếm
        $countParams[] = "%" . $search . "%";
        $countParams[] = "%" . $search . "%";
        $countParams[] = "%" . $search . "%";
        $countParams[] = "%" . $search . "%";

        // Thêm điều kiện lọc vào câu truy vấn đếm nếu có
        if ($nhomKs !== null) {
            $countSql .= " AND nhom_ks = ?";
            $countParams[] = $nhomKs;
            $countTypes .= "i";
        }
        if ($loaiDtId !== null) {
            $countSql .= " AND loai_dt_id = ?";
            $countParams[] = $loaiDtId;
            $countTypes .= "i";
        }
        if ($ctdtId !== null) {
            $countSql .= " AND ctdt_id = ?";
            $countParams[] = $ctdtId;
            $countTypes .= "i";
        }

        $countStmt = $conn->prepare($countSql);
        $countStmt->bind_param($countTypes, ...$countParams);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalCount = $countResult->fetch_assoc()['total'];

        $totalPages = ceil($totalCount / $limit);

        return [
            'data' => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function getById($dt_id)
    {
        $conn = $this->db->getConnection();

        // Câu truy vấn SQL để lấy thông tin đối tượng theo ID
        $sql = "SELECT * FROM doi_tuong WHERE dt_id = ?";

        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);

        // Liên kết tham số với câu truy vấn (dùng kiểu "i" cho integer)
        $stmt->bind_param("i", $dt_id);

        // Thực thi câu truy vấn
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Kiểm tra xem có bản ghi nào không
        if ($result->num_rows > 0) {
            // Trả về kết quả (dữ liệu của đối tượng)
            return $result->fetch_assoc();
        } else {
            // Nếu không tìm thấy đối tượng, trả về false
            return false;
        }
    }
    public function create($ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id)
    {
        $conn = $this->db->getConnection();

        $sql = "INSERT INTO doi_tuong (ho_ten, email, diachi, dien_thoai, nhom_ks, loai_dt_id, ctdt_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssiii", $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id);

        if ($stmt->execute()) {
            return $conn->insert_id;
        } else {
            return false;
        }
    }
    public function update($dt_id, $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id, $status)
    {
        $conn = $this->db->getConnection();

        $sql = "UPDATE doi_tuong 
            SET ho_ten = ?, email = ?, diachi = ?, dien_thoai = ?, nhom_ks = ?, loai_dt_id = ?, ctdt_id = ?, status = ?
            WHERE dt_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssiiiii", $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks, $loai_dt_id, $ctdt_id, $status, $dt_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getByIds($dt_ids)
    {
        $conn = $this->db->getConnection();

        if (empty($dt_ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($dt_ids), '?'));

        $sql = "SELECT dt.*, ldt.ten_dt
                FROM doi_tuong dt
                JOIN loai_doi_tuong ldt ON dt.loai_dt_id = ldt.dt_id
                WHERE dt.dt_id IN ($placeholders);";

        $stmt = $conn->prepare($sql);

        $types = str_repeat('i', count($dt_ids));

        $stmt->bind_param($types, ...$dt_ids);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getAllByNhomKs($nhom_ks)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM doi_tuong WHERE nhom_ks = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nhom_ks); // i = integer

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
