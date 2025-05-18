<?php
class MyConnection
{
    private $connection;
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "student_survey_management";

    public function __construct()
    { 
    }

    public function getConnection()
    {   
        $this->connection = new mysqli($this->server, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Kết nối đến MySQL thất bại: " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    public function closeConnection()
    {
        if ($this->connection) {
            $this->connection->close();
            // echo "Connection closed.";
        }
    }

    public function read($ks_id)
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
// test purpose
// $db = new MyConnection();
// $ks_id = 1;
// $result = $db->read($ks_id);
// if ($result) {
//     // Print the result
//     print_r($result);
// } else {
//     echo "No record found with ks_id = $ks_id";
// }
// $db->closeConnection();

?>