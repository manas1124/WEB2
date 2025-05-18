<?php
require_once __DIR__ . '/database.php';

class MucKhaoSatModel
{
    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    public function create($ten_muc, $ks_id, $parent_id = null)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO muc_khao_sat (ten_muc,ks_id,parent_mks_id,status) VALUES (?,?,?,1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $ten_muc, $ks_id, $parent_id);

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
    public function getMucKhaoSatByKsId($ks_id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM muc_khao_sat WHERE ks_id = ? and status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }

    public function delete($id)
    {
        $con = $this->db->getConnection();
        $sql = "UPDATE muc_khao_sat SET status = 0 WHERE mks_id = $id";

        if ($con->query($sql) === TRUE) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }
    public function getArrayQuestionBySectionId($sectionId)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM cau_hoi WHERE mks_id = ? AND STATUS = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sectionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    "ch_id" => $row["ch_id"],
                    "noi_dung" => $row["noi_dung"],
                ];
            }
        }
        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }
     public function getQuestionsByKsId($ks_id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT
                    ch.ch_id AS questionId,
                    ch.noi_dung AS questionContent,
                    ch.mks_id AS sectionId
                FROM cau_hoi ch
                WHERE ch.mks_id IN (
                    SELECT mks_id FROM muc_khao_sat WHERE ks_id = ?
                )";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }
}

// $t = new MucKhaoSatModel();
// $a = $t->create("rea",3);
// echo json_encode($a);
?>