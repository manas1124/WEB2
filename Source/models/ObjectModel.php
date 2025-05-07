<?php
class ObjectModel
{
    private $db;
    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getObjectId($id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM doi_tuong WHERE dt_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        }
        $this->db->closeConnection();
        // return data as string json
        return null;
    }

    public function create($fullName, $email, $address, $phone, $obj, $ctdt, $status = 1)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO doi_tuong (ho_ten, email, diachi, dien_thoai, loai_dt_id, ctdt_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiii", $fullName, $email, $address, $phone, $obj, $ctdt, $status);

        if ($stmt->execute()) {
            return $conn->insert_id;
        } else {
            return -1;
        }
    }
    public function update($dt_id, $ho_ten, $email, $dien_thoai, $diachi)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE doi_tuong SET ho_ten=?, email=?, dien_thoai=?, diachi=? WHERE dt_id=?");
        if (!$stmt) return false;

        $stmt->bind_param("ssssi", $ho_ten, $email, $dien_thoai, $diachi, $dt_id);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }
}
