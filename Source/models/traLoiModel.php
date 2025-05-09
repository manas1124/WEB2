<?php

require_once __DIR__ . '/database.php';

class TraLoiModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM tra_loi";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getById($tl_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tra_loi WHERE tl_id = ?");
        $stmt->bind_param("i", $tl_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function create($ket_qua, $ch_id, $kq_ks_id, $status)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO tra_loi (ket_qua, ch_id, kq_ks_id, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare(query: $sql);
        $stmt->bind_param("iiii", $ket_qua, $ch_id, $kq_ks_id, $status);

        return $stmt->execute();
    }

    public function update($tl_id, $ket_qua, $ch_id, $kq_ks_id, $status)
    {
        $conn = $this->db->getConnection();
        $sql = "UPDATE tra_loi SET ket_qua = ?, ch_id = ?, kq_ks_id = ?, status = ? WHERE tl_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiii", $ket_qua, $ch_id, $kq_ks_id, $status, $tl_id);

        return $stmt->execute();
    }

    public function getByKqksId($kq_ks_id)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM tra_loi WHERE kq_ks_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $kq_ks_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getByKqksIdAndChIds($kq_ks_id, $ch_ids)
    {
        $conn = $this->db->getConnection();

        if (empty($ch_ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ch_ids), '?'));

        $sql = "SELECT * FROM tra_loi WHERE kq_ks_id = ? AND ch_id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $types = str_repeat('i', count($ch_ids) + 1);
        $params = array_merge([$kq_ks_id], $ch_ids);

        $stmt->bind_param($types, $params);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getByKqksIds($kqks_ids)
    {
        $conn = $this->db->getConnection();

        if (empty($kqks_ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($kqks_ids), '?')); 

        $sql = "SELECT * FROM tra_loi WHERE kq_ks_id IN ($placeholders) AND status =1";
        $stmt = $conn->prepare($sql);

        $types = str_repeat('i', count($kqks_ids)); 
        $stmt->bind_param($types, ...$kqks_ids);

        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();

        return $data;
    }
}
