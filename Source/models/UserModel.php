<?php
// app/Models/KhaoSat.php

require_once __DIR__ .'/database.php'; 

class UserModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

     public function getUserByPageNumber($page,$searchKeyWord = null,$nhomKsId= null, $chuKyId= null,$nganhId= null)
    {
        $limit = 6;

        $conn = $this->db->getConnection();
        $sql = "SELECT doi_tuong.* ,nks.ten_nks
                FROM doi_tuong 
                LEFT JOIN nhom_khao_sat nks ON doi_tuong.nhom_ks = nks.nks_id 
                LEFT JOIN ctdt_daura  ON doi_tuong.ctdt_id = ctdt_daura.ctdt_id
                where 1 = 1 ";

        // Đếm tổng số dòng (để tính tổng số trang)
        $countSql = "SELECT COUNT(*) as total FROM doi_tuong 
                    LEFT JOIN nhom_khao_sat nks ON doi_tuong.nhom_ks = nks.nks_id 
                    LEFT JOIN ctdt_daura  ON doi_tuong.ctdt_id = ctdt_daura.ctdt_id 
                    where 1 = 1 ";
        $params = [];
        $types = "";
        $status = 1;
       
        if ($status != null) {
            $sql .= " AND doi_tuong.status = ?";

            $countSql .= " AND doi_tuong.status = ?";
            $params[] = $status;
            $types .= "i";
        }
        if ($searchKeyWord != null) {
            $sql .= " AND (doi_tuong.ho_ten LIKE ? OR doi_tuong.email LIKE ?)";

            $countSql .= " AND (doi_tuong.ho_ten LIKE ? OR doi_tuong.email LIKE ?)";
            $params[] = "%" . $searchKeyWord . "%";
            $params[] = "%" . $searchKeyWord . "%";
            $types .= "ss";
        }
        if ($nhomKsId != null) {
            $sql .= " AND doi_tuong.nhom_ks = ? ";

            $countSql .= " AND doi_tuong.nhom_ks = ? ";
            $params[] = $nhomKsId;
            $types .= "i";
        }
        if ($nganhId != null) {
            $sql .= " AND ctdt_daura.nganh_id = ? ";

            $countSql .= " AND ctdt_daura.nganh_id  = ? ";
            $params[] = $nganhId;
            $types .= "i";
        }
        if ($chuKyId != null) {
            $sql .= " AND ctdt_daura.ck_id = ? ";

            $countSql .= " AND ctdt_daura.ck_id  = ? ";
            $params[] = $chuKyId;
            $types .= "i";
        }
        $sql .= " ORDER BY dt_id DESC";
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

    public function getAllUser($search = '',$nhomKsId = '') {
        $conn = $this->db->getConnection();
       
        if ($nhomKsId != '') {
            $stmt = $conn->prepare("SELECT u.*, nks.ten_nks 
                FROM doi_tuong u
                LEFT JOIN nhom_khao_sat nks ON u.nhom_ks = nks.nks_id
                WHERE (u.ho_ten LIKE ? OR u.email LIKE ?) AND u.nhom_ks = ?");
            $stmt->bind_param("ssi", $searchTerm, $searchTerm, $nhomKsId); 
        } else {
            $stmt = $conn->prepare("SELECT u.*, nks.ten_nks 
                FROM doi_tuong u
                LEFT JOIN nhom_khao_sat nks ON u.nhom_ks = nks.nks_id
                WHERE u.ho_ten LIKE ? OR u.email LIKE ?");
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
        }
        $searchTerm = "%$search%";
       
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
    public function getUserById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM doi_tuong,loai_doi_tuong WHERE doi_tuong.dt_id = ? AND loai_doi_tuong.dt_id = doi_tuong.loai_dt_id");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    public function addUser($ho_ten,$email,$diachi,$dien_thoai,$nhom_ks,$loai_dt_id,$ctdt_id ) {
       
        $conn = $this->db->getConnection();
    
        $stmt = $conn->prepare("INSERT INTO doi_tuong (ho_ten, email, diachi, dien_thoai, nhom_ks, loai_dt_id, ctdt_id) VALUES ( ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param(
            "sssssss",  $ho_ten,$email,$diachi,$dien_thoai,$nhom_ks,$loai_dt_id,$ctdt_id);
        
            if ($stmt->execute()) {
                $id = $stmt->insert_id;
                $stmt->close();
                return $id;
            } else {
                $stmt->close();
                return false;
            }
    }
    
    public function updateUser($dt_id, $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks_id, $loai_dt_id, $ctdt_id) {
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("UPDATE doi_tuong SET ho_ten = ?, email = ?, diachi = ?, dien_thoai = ?, nhom_ks = ?, loai_dt_id = ?, ctdt_id = ? WHERE dt_id = ?");
    $stmt->bind_param("sssssssi", $ho_ten, $email, $diachi, $dien_thoai, $nhom_ks_id, $loai_dt_id, $ctdt_id, $dt_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
    public function deleteUser($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM doi_tuong WHERE dt_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
}
?>