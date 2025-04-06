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
        $sql = "INSERT INTO cau_hoi (noi_dung,mks_id) VALUES ('$noi_dung','$mks_id')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}