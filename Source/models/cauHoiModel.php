<?php
require_once __DIR__ . '/database.php';

class CauHoiModel
{
    private $db; // Database connection
    private $conn;
    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function getById($id)
    {
        $this->conn = $this->db->getConnection();
        $sql = "SELECT * FROM cau_hoi WHERE id = $id";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        $this->db->closeConnection();
        return null;
    }
    public function create($noi_dung, $mks_id)
    {
        $this->conn = $this->db->getConnection();
        $sql = "INSERT INTO cau_hoi (noi_dung,mks_id,status) VALUES ('$noi_dung','$mks_id',1)";
        if ($this->conn->query($sql) === TRUE) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }
    public function deleteByMksId($mks_id)
    {
        $this->conn = $this->db->getConnection();
        $sql = "update cau_hoi set status = 0 where mks_id = $mks_id";
        if ($this->conn->query($sql) === TRUE) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }
    public function delete($id)
    {
        $this->conn = $this->db->getConnection();
        $sql = "update cau_hoi set status = 0 where id = $id";
        if ($this->conn->query($sql) === TRUE) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }

    public function getByMucCauHois($mucCauHois){
        $conn = $this->db->getConnection();

        $placeholders = implode(',', array_fill(0, count($mucCauHois), '?'));
        $sql = "SELECT * FROM cau_hoi WHERE mks_id IN ($placeholders)";
    
        $stmt = $conn->prepare($sql);
        
        $types = str_repeat('i', count(value: $mucCauHois));
        $stmt->bind_param($types, ...$mucCauHois);
    
        $stmt->execute();
    
        $result = $stmt->get_result();
        $data = [];
    
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
    }
}