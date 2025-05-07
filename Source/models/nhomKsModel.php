<?php
// app/Models/KhaoSat.php

require_once __DIR__ .'/database.php'; 

Class NhomKsModel {
    private $db;
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getAllNhomKs() {
        $con = $this->db->getConnection();
        $sql = "SELECT nks_id,ten_nks FROM nhom_khao_sat ";
        $result = $con->query($sql);
       
        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data; 
        } else {
            die("Query execution failed: " . $con->error);
        }
    }
    public function addNhomks($ten_Nks) {
        $conn = $this->db->getConnection();
    
        $stmt = $conn->prepare("INSERT INTO nhom_khao_sat (ten_nks) VALUES (?)");
        $stmt->bind_param(
            "s",  $ten_Nks);
        
            if ($stmt->execute()) {
                $insertedId = $conn->insert_id;
                $stmt->close();
                return [
                    'success' => true,
                    'message' => 'Thêm thành công',
                    'id' => $insertedId
                ];
            } else {
                $stmt->close();
                return [
                    'success' => false,
                    'message' => 'Lỗi khi thêm: ' . $stmt->error
                ];
            }
    }
    public function getNhomKsById($id) {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM nhom_khao_sat WHERE nks_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Cập nhật nhóm khảo sát
    public function updateNhomKs($id, $ten_nks) {
        $conn = $this->db->getConnection();
        $query = "UPDATE nhom_khao_sat SET ten_nks = ? WHERE nks_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $ten_nks, $id);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Cập nhật nhóm khảo sát thành công'];
        } else {
            return ['success' => false, 'message' => 'Cập nhật thất bại'];
        }
    }
    public function deletenks($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("DELETE FROM nhom_khao_sat WHERE nks_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
        
    }
    public function getAllKhaoSat() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat ");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // return data as string json
        return $data;
    }
}

// $test = new NhomKsModel();
// $re = $test->getAllNhomKs()[0];
// echo json_encode($re);

?>