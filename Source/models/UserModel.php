<?php
// app/Models/KhaoSat.php

require_once __DIR__ .'/database.php'; 

class UserModel {

    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
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
        $stmt = $conn->prepare("SELECT * FROM doi_tuong WHERE dt_id = ?");
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
    
    public function updateUser($dt_id,$ho_ten,$email,$diachi,$dien_thoai,$loai_dt_id,$ctdt_id ) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE doi_tuong SET ho_ten = ?, diachi = ?, dien_thoai = ?, nhom_ks = ?, loai_dt_id = ?, ctdt_id = ? WHERE email = ?");
        $stmt->bind_param(
            "sssssss",$dt_id,$ho_ten,$email,$diachi,$dien_thoai,$loai_dt_id,$ctdt_id 
           
        );
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