<?php
require_once __DIR__ .'/database.php'; 

class MucKhaoSatModel 
{
    private $db; // Database connection
    
    public function __construct() {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function create($ten_muc,$ks_id)
    {   
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO muc_khao_sat (ten_muc,ks_id) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ten_muc, $ks_id);

        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            $this->db->closeConnection();
            return $id;
        } else {
            $stmt->close();
            $this->db->closeConnection();
            return false;
        }
        
    }

    public function delete($id)
    {   
        $con = $this->db->getConnection();
        $sql = "DELETE FROM muc_khao_sat WHERE id = $id";
        if ($con->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

// $t = new MucKhaoSatModel();
// $a = $t->create("rea",3);
// echo json_encode($a);
?>