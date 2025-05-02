<?php

require_once __DIR__ . '/database.php';

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KqKhaoSatModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM kq_khao_sat";
        $stmt = $conn->prepare($sql);
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

    public function getAllByKsId($ks_id) {
        // Kiểm tra tham số ks_id
        if ($ks_id === null) {
            return [
                'error' => 'Thiếu tham số ks_id',
                'data' => []
            ];
        }
    
        $conn = $this->db->getConnection();
    
        // Điều kiện lọc
        $condition = "WHERE status = 1 AND ks_id = ?";
    
        // Truy vấn lấy tất cả bản ghi
        $sql = "SELECT * FROM kq_khao_sat " . $condition;
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
    
        // Đóng statement
        $stmt->close();
    
        return [
            'data' => $data
        ];
    }

    public function getById($kqks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM kq_khao_sat WHERE kqks_id = ?");
        $stmt->bind_param("i", $kqks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function create($nguoi_lamks_id, $ks_id, $status = 1)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO kq_khao_sat (nguoi_lamks_id, ks_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $nguoi_lamks_id, $ks_id, $status);

        return $stmt->execute();
    }


    public function totalKQKhaoSat($ks_id)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT COUNT(*) as total FROM kq_khao_sat WHERE ks_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function getIdKhaoSat()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT DISTINCT ks_id FROM kq_khao_sat");
        $stmt->execute();
        $result = $stmt->get_result();
        $ks_ids = [];
        while ($row = $result->fetch_assoc()) {
            $ks_ids[] = $row['ks_id'];
        }

        return $ks_ids;
    }

    function exportSurveyToExcel($ks_id, $outputFile = 'survey_export.xlsx') {
        try {

            $conn = $this->db->getConnection();
    
            // 1. Lấy thông tin khảo sát
            $surveyQuery = "
                SELECT ks.ks_id, ks.ten_ks, ks.ngay_bat_dau, ks.ngay_ket_thuc, nks.ten_nks
                FROM khao_sat ks
                JOIN nhom_khao_sat nks ON ks.nks_id = nks.nks_id
                WHERE ks.ks_id = ?
            ";
            $stmt = $conn->prepare($surveyQuery);
            $stmt->bind_param('i', $ks_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $survey = $result->fetch_assoc();
    
            if (!$survey) {
                throw new Exception("Không tìm thấy khảo sát với ks_id = $ks_id");
            }
    
            // 2. Lấy danh sách mục khảo sát và câu hỏi
            $questionsQuery = "
                SELECT mks.mks_id, mks.ten_muc, ch.ch_id, ch.noi_dung
                FROM muc_khao_sat mks
                LEFT JOIN cau_hoi ch ON mks.mks_id = ch.mks_id
                WHERE mks.ks_id = ?
                ORDER BY mks.mks_id, ch.ch_id
            ";
            $stmt = $conn->prepare($questionsQuery);
            $stmt->bind_param('i', $ks_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $questions = $result->fetch_all(MYSQLI_ASSOC);
    
            // Tổ chức cấu trúc tiêu đề
            $headers = ['Email']; // Cột đầu tiên là Email
            $questionMap = []; // Lưu ánh xạ ch_id với vị trí cột
            $currentMksId = null;
            $colIndex = 1; // Bắt đầu từ cột B (sau cột Email)
    
            foreach ($questions as $question) {
                // Nếu gặp mục khảo sát mới, thêm tiêu đề mục khảo sát
                if ($question['mks_id'] !== $currentMksId) {
                    $headers[$colIndex] = $question['ten_muc'];
                    $colIndex++;
                    $currentMksId = $question['mks_id'];
                }
                // Thêm tiêu đề câu hỏi
                if ($question['ch_id']) {
                    $headers[$colIndex] = $question['noi_dung'];
                    $questionMap[$question['ch_id']] = $colIndex;
                    $colIndex++;
                }
            }
    
            // 3. Lấy danh sách người tham gia và kết quả trả lời
            $resultsQuery = "
                SELECT dt.dt_id, dt.email, tl.ch_id, tl.ket_qua
                FROM kq_khao_sat kq
                JOIN doi_tuong dt ON kq.nguoi_lamks_id = dt.dt_id
                LEFT JOIN tra_loi tl ON kq.kqks_id = tl.kq_ks_id
                WHERE kq.ks_id = ?
                ORDER BY dt.dt_id, tl.ch_id
            ";
            $stmt = $conn->prepare($resultsQuery);
            $stmt->bind_param('i', $ks_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $results = $result->fetch_all(MYSQLI_ASSOC);
    
            // 4. Tổ chức dữ liệu theo định dạng bảng
            $data = [];
            $users = [];
            foreach ($results as $result) {
                $dt_id = $result['dt_id'];
                if (!isset($users[$dt_id])) {
                    $users[$dt_id] = ['Email' => $result['email']];
                }
                if ($result['ch_id']) {
                    $users[$dt_id][$questionMap[$result['ch_id']]] = $result['ket_qua'] ?: '';
                }
            }
    
            // Chuyển dữ liệu người dùng thành mảng dữ liệu cho Excel
            foreach ($users as $user) {
                $row = [];
                foreach (range(0, count($headers) - 1) as $i) {
                    $row[$i] = $user[$i] ?? ''; // Để trống cho các ô không có dữ liệu
                }
                $data[] = $row;
            }
    
            // 5. Tạo file Excel với PhpSpreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Survey Results');
    
            // Ghi thông tin khảo sát
            $sheet->setCellValue('A1', 'Thông tin khảo sát');
            $sheet->mergeCells('A1:' . chr(65 + count($headers) - 1) . '1');
            $sheet->getStyle('A1')->getFont()->setBold(true);
    
            $sheet->setCellValue('A2', 'Tên khảo sát');
            $sheet->setCellValue('B2', $survey['ten_ks']);
            $sheet->setCellValue('A3', 'Nhóm khảo sát');
            $sheet->setCellValue('B3', $survey['ten_nks']);
            $sheet->setCellValue('A4', 'Ngày bắt đầu');
            $sheet->setCellValue('B4', $survey['ngay_bat_dau']);
            $sheet->setCellValue('A5', 'Ngày kết thúc');
            $sheet->setCellValue('B5', $survey['ngay_ket_thuc']);
    
            // Ghi tiêu đề bảng
            $row = 7;
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $sheet->getStyle($col . $row)->getFont()->setBold(true);
                $col++;
            }
    
            // Ghi dữ liệu
            $row++;
            foreach ($data as $dataRow) {
                $col = 'A';
                foreach ($dataRow as $value) {
                    $sheet->setCellValue($col . $row, $value);
                    $col++;
                }
                $row++;
            }
    
            // Tự động điều chỉnh kích thước cột
            foreach (range('A', chr(64 + count($headers))) as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
    
            // Lưu file Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save($outputFile);
            echo "File Excel đã được tạo: $outputFile\n";
    
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage() . "\n";
        } finally {
            // Đóng kết nối
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
}
