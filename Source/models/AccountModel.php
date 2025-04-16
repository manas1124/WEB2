<?php
require_once __DIR__ . '/database.php';
class AccountModel
{
    private $db;
    public function __construct()
    {
        $this->db = new MyConnection();
    }
    // Database operations
    public function create($username, $password, $dt_id, $quyen_id, $status)
    {
        $conn = $this->db->getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO tai_khoan (username, password, dt_id, quyen_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $username, $hashedPassword, $dt_id, $quyen_id, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllTaiKhoan()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT *
                                FROM tai_khoan
                                JOIN quyen ON tai_khoan.quyen_id = quyen.quyen_id;");

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
    public function update($tk_id, $username, $password, $dt_id, $quyen_id, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
        UPDATE tai_khoan 
        SET username = ?, password = ?, dt_id = ?, quyen_id = ?, status = ?
        WHERE tk_id = ?
    ");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssiiii", $username, $hashedPassword, $dt_id, $quyen_id, $status, $tk_id);

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        $this->db->closeConnection();
        return true;
    }
    //hàm xoá , chuyển status về 0 thay vì xoá hết
    public function softDelete($tk_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE tai_khoan SET status = 0 WHERE tk_id = ?");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $stmt->bind_param("s", $tk_id); // hoặc "i" nếu tk_id là số nguyên

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        $this->db->closeConnection();
        return true;
    }
    public function searchAccount($keyword)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE username LIKE ? AND status = 1");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $likeKeyword = '%' . $keyword . '%';
        $stmt->bind_param("s", $likeKeyword);

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
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

    public function getAccount($username)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE username = ? AND status = 1");

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $stmt->bind_param("s", $username);

        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $result = $stmt->get_result();
        $data = null;

        if ($result->num_rows > 0) {
            $data = json_encode($result->fetch_assoc());
        }

        $stmt->close();
        $this->db->closeConnection();
        return $data;
    }
}
