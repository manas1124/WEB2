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
        $stmt = $conn->prepare("SELECT * FROM quyen where status = 1");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
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
        $status = 1;
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

    public function getQuyenById($quyen_id)
    {
        $conn = $this->db->getConnection();
        $query = "
                SELECT 
                quyen.quyen_id,
                quyen.ten_quyen,
                quyen.status
                FROM quyen
                WHERE quyen.quyen_id = ?
    ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $quyen_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    public function searchQuyen($keyword)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM quyen WHERE ten_quyen LIKE ? AND status = 1";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return [];
        }

        $likeKeyword = '%' . $keyword . '%';
        $stmt->bind_param("s", $likeKeyword);

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }
    public function create($ten_quyen, $status = 1)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO quyen (ten_quyen, status) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ten_quyen, $status);
        $success = $stmt->execute();
        $insert_id = $conn->insert_id;
        $stmt->close();
        $this->db->closeConnection();

        return [
            "status" => $success,
            "message" => $success ? "Thêm quyền thành công" : "Thêm quyền thất bại",
            "insert_id" => $insert_id
        ];
    }
    public function delete($quyen_id)
    {
        $conn = $this->db->getConnection();
        $sql = "UPDATE quyen SET status = 0 WHERE quyen_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quyen_id);
        $result = $stmt->execute();
        $stmt->close();
        $this->db->closeConnection();
        return $result;
    }
    public function update($quyen_id, $ten_quyen, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE quyen SET ten_quyen = ?, status = ? WHERE quyen_id = ?");
        $stmt->bind_param("sii", $ten_quyen, $status, $quyen_id);

        return $stmt->execute();
    }

    //chuc nang quyen
    public function createChucNangQuyen($quyen_id,$chuc_nang_key,$status = 1 )
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO chuc_nang (quyen_id, ten_cn, status) VALUES (?, ?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi",$quyen_id,$chuc_nang_key, $status );
        $success = $stmt->execute();
        $stmt->close();
        $this->db->closeConnection();

        return [
            "status" => $success,
            "message" => $success ? "Thêm chức năng thành công" : "Thêm chức năng thất bại",
        ];
    }
    public function deleteAllChucNangByQuyenId($quyen_id)
    {
        $conn = $this->db->getConnection();
        $sql = "DELETE FROM chuc_nang WHERE quyen_id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quyen_id,);
        $result = $stmt->execute();
        $stmt->close();
        $this->db->closeConnection();
        return $result;
    }
    public function getChucNangByQuyenId($quyen_id)
    {
        $conn = $this->db->getConnection();
        $query = " SELECT  * FROM chuc_nang WHERE quyen_id = ? ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $quyen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        $this->db->closeConnection();
        
        return $data;
        
        if ($result->num_rows <= 0) {
            return false;
        }
    }
}