<?php

require_once __DIR__ . '/database.php';

class LoaiTraLoiModel
{

    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllTraLoi()
    {
        $con = $this->db->getConnection();
        $sql = "SELECT * FROM loai_tra_loi WHERE status = 1";
        $result = $con->query($sql);

        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data; // Return the result set for further processing
        } else {
            die("Query execution failed: " . $con->error);
        }
    }

    public function getTraLoiByIdKhaoSat($idKhaoSat)
    {
        $con = $this->db->getConnection();
        $sql = "SELECT thang_diem
                FROM khao_sat ks JOIN loai_tra_loi ltl ON ks.ltl_id = ltl.ltl_id
                WHERE ks.ks_id = ? AND ltl.status = 1 AND ks.status = 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idKhaoSat);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            return $result->fetch_assoc();
        } else {
            die("Query execution failed: " . $con->error);
        }
    }

    public function getLoaiTraLoiById($ltl_id)
    {
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM loai_tra_loi WHERE ltl_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $ltl_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $loaiTraLoi = $result->fetch_assoc();
            $stmt->close();
            $this->db->closeConnection();
            return $loaiTraLoi;
        } else {
            $stmt->close();
            $this->db->closeConnection();
            return null;
        }
    }


    public function getAllPaging($page, $textSearch = '', $status = null)
    {
        $con = $this->db->getConnection();
        $limit = 7;
        $offset = ($page - 1) * $limit;

        // Base query (dùng lại cho cả đếm và truy vấn)
        $whereClause = " WHERE 1=1 ";

        if ($status !== null && $status !== '') {
            $whereClause .= " AND status = " . intval($status);
        }

        if (!empty($textSearch)) {
            $textSearchEscaped = $con->real_escape_string($textSearch);
            $whereClause .= " AND (
            ltl_id LIKE '%$textSearchEscaped%' OR
            thang_diem LIKE '%$textSearchEscaped%' OR
            mota LIKE '%$textSearchEscaped%' OR
            motachitiet LIKE '%$textSearchEscaped%'
        ) ";
        }

        // Đếm tổng số dòng
        $countSql = "SELECT COUNT(*) as total FROM loai_tra_loi $whereClause";
        $countResult = $con->query($countSql);
        $totalRecords = 0;
        if ($countResult && $countRow = $countResult->fetch_assoc()) {
            $totalRecords = intval($countRow['total']);
        }

        $totalPage = ceil($totalRecords / $limit);

        // Lấy dữ liệu trang hiện tại
        $dataSql = "SELECT * FROM loai_tra_loi $whereClause ORDER BY ltl_id DESC LIMIT $limit OFFSET $offset";
        $dataResult = $con->query($dataSql);

        $data = [];
        if ($dataResult) {
            while ($row = $dataResult->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->db->closeConnection();

        return [
            'data' => $data,
            'totalPages' => $totalPage,
            'currentPage' => $page
        ];
    }

    public function create($thangDiem, $moTa, $moTaChiTiet)
    {
        $con = $this->db->getConnection();

        // Chuẩn bị câu lệnh
        $stmt = $con->prepare("INSERT INTO loai_tra_loi (thang_diem, mota, chitiet_mota, status) VALUES (?, ?, ?, 1)");

        if (!$stmt) {
            return false;
        }

        // Gán tham số
        $stmt->bind_param("iss", $thangDiem, $moTa, $moTaChiTiet);

        // Thực thi
        $result = $stmt->execute();

        if ($result) {
            $insertedId = $stmt->insert_id;
            $stmt->close();
            return $insertedId;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function update($ltl_id, $thangDiem, $moTa, $moTaChiTiet, $status)
    {
        $con = $this->db->getConnection();

        // Chuẩn bị câu lệnh UPDATE
        $stmt = $con->prepare("UPDATE loai_tra_loi SET thang_diem = ?, mota = ?, chitiet_mota = ?, status = ? WHERE ltl_id = ?");

        if (!$stmt) {
            return false;
        }

        // Gán tham số
        $stmt->bind_param("issii", $thangDiem, $moTa, $moTaChiTiet, $status, $ltl_id);

        // Thực thi
        $result = $stmt->execute();

        $stmt->close();
        $this->db->closeConnection();

        return $result; // Trả về true nếu thành công, false nếu thất bại
    }

    public function toggleStatus($ltl_id)
    {
        $con = $this->db->getConnection();

        // Lấy status hiện tại
        $stmt = $con->prepare("SELECT status FROM loai_tra_loi WHERE ltl_id = ?");
        $stmt->bind_param("i", $ltl_id);
        $stmt->execute();
        $stmt->bind_result($currentStatus);

        if ($stmt->fetch()) {
            $stmt->close();

            // Đảo giá trị status
            $newStatus = $currentStatus == 1 ? 0 : 1;

            // Cập nhật status mới
            $updateStmt = $con->prepare("UPDATE loai_tra_loi SET status = ? WHERE ltl_id = ?");
            $updateStmt->bind_param("ii", $newStatus, $ltl_id);
            $result = $updateStmt->execute();
            $updateStmt->close();

            $this->db->closeConnection();
            return $result; // true nếu thành công
        } else {
            $stmt->close();
            $this->db->closeConnection();
            return false; // Không tìm thấy bản ghi
        }
    }
}
//     $model = new NganhModel();
//     $re = $model->getAllNganh();
// echo json_encode($re);
