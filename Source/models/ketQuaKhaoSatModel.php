<?php

require_once __DIR__ . '/database.php';

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

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

    public function getAllByKsId($ks_id)
    {
        // Kiểm tra tham số ks_id
        if ($ks_id === null) {
            return [
                'error' => 'Thiếu tham số ks_id',
                'data' => []
            ];
        }

        $conn = $this->db->getConnection();

        // Truy vấn lấy tất cả bản ghi
        $sql = "SELECT * FROM kq_khao_sat WHERE status = 1 AND ks_id = ?";
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
        $query = "SELECT COUNT(*) as total FROM kq_khao_sat WHERE ks_id = ? AND status = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function getIdKhaoSat()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT DISTINCT ks_id FROM kq_khao_sat WHERE status = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $ks_ids = [];
        while ($row = $result->fetch_assoc()) {
            $ks_ids[] = $row['ks_id'];
        }

        return $ks_ids;
    }

    public function getIdKhaoSatByIdUser($user_id)
    {
        if (!$user_id) return [];
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT DISTINCT ks_id FROM kq_khao_sat WHERE status = 1 AND nguoi_lamks_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ks_ids = [];
        while ($row = $result->fetch_assoc()) {
            $ks_ids[] = $row['ks_id'];
        }

        return $ks_ids;
    }

    function exportSurveyToExcel($ks_id, $outputFile = 'survey_export.xlsx')
    {
        try {

            $conn = $this->db->getConnection();

            // 1. Lấy thông tin khảo sát
            $surveyQuery = "
                SELECT 
                    khao_sat.ten_ks, 
                    khao_sat.ngay_bat_dau,
                    khao_sat.ngay_ket_thuc,
                    loai_tra_loi.thang_diem,
                    nhom_khao_sat.ten_nks,
                    chu_ki.ten_ck,
                    nganh.ten_nganh,
                    ctdt_daura.la_ctdt
                FROM khao_sat
                JOIN loai_tra_loi ON khao_sat.ltl_id = loai_tra_loi.ltl_id
                JOIN nhom_khao_sat ON khao_sat.nks_id = nhom_khao_sat.nks_id
                JOIN ctdt_daura ON khao_sat.ctdt_id = ctdt_daura.ctdt_id
                JOIN chu_ki ON ctdt_daura.ck_id = chu_ki.ck_id 
                JOIN nganh ON  ctdt_daura.nganh_id = nganh.nganh_id
                WHERE khao_sat.ks_id = ? AND khao_sat.ctdt_id = ctdt_daura.ctdt_id
            ";
            $stmt = $conn->prepare($surveyQuery);
            $stmt->bind_param('i', $ks_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $survey = $result->fetch_assoc();

            if (!$survey) {
                return [
                    'status' => false,
                    'message' => 'Khong tim thay ket qua khao sat'
                ];
            }

            // 2. Lấy danh sách mục khảo sát và câu hỏi
            $questionsQuery = "
                SELECT mks.mks_id, mks.ten_muc, ch.ch_id, ch.noi_dung
                FROM muc_khao_sat mks
                JOIN cau_hoi ch ON mks.mks_id = ch.mks_id
                WHERE mks.ks_id = ? AND mks.status = 1 AND ch.status = 1
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
                SELECT kq.kqks_id, dt.dt_id, dt.email, tl.ch_id, tl.ket_qua
                FROM kq_khao_sat kq
                JOIN doi_tuong dt ON kq.nguoi_lamks_id = dt.dt_id
                LEFT JOIN tra_loi tl ON kq.kqks_id = tl.kq_ks_id
                WHERE kq.ks_id = ? AND kq.status = 1
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
                $kqks_id = $result['kqks_id'];

                if (!isset($users[$kqks_id])) {
                    $users[$kqks_id] = ['0' => $result['email']];
                }

                if ($result['ch_id']) {
                    $colIndex = $questionMap[$result['ch_id']] ?? null;
                    if ($colIndex !== null) {
                        $users[$kqks_id][$colIndex] = $result['ket_qua'] ?: '';
                    }
                }
            }

            // Chuyển dữ liệu người dùng thành mảng dữ liệu cho Excel
            foreach ($users as $user) {
                $row = [];
                foreach (range(0, count($headers) - 1) as $i) {
                    // Kiểm tra nếu có câu trả lời thì thêm vào dòng, nếu không thì để trống
                    $row[$i] = $user[$i] ?? '';  // Để trống cho các ô không có dữ liệu
                }
                $data[] = $row;  // Thêm dòng vào mảng dữ liệu
            }

            // 5. Tạo file Excel với PhpSpreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Kết quả khảo sát');

            // Ghi thông tin khảo sát
            $sheet->setCellValue('A1', 'Thông tin khảo sát');
            $sheet->mergeCells('A1:' . chr(65 + count($headers) - 1) . '1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            // Các thông tin khảo sát
            $sheet->setCellValue('A2', 'Tên khảo sát');
            $sheet->setCellValue('B2', $survey['ten_ks']);

            $sheet->setCellValue('A3', 'Nhóm khảo sát');
            $sheet->setCellValue('B3', $survey['ten_nks']);

            $sheet->setCellValue('A4', 'Ngày bắt đầu');
            $sheet->setCellValue('B4', $survey['ngay_bat_dau']);

            $sheet->setCellValue('A5', 'Ngày kết thúc');
            $sheet->setCellValue('B5', $survey['ngay_ket_thuc']);

            $sheet->setCellValue('A6', 'Chu kỳ');
            $sheet->setCellValue('B6', $survey['ten_ck']);

            $sheet->setCellValue('A7', 'Ngành');
            $sheet->setCellValue('B7', $survey['ten_nganh']);

            $sheet->setCellValue('A8', 'Loại');
            $sheet->setCellValue('B8', $survey['la_ctdt'] == 1 ? "Chương trình đào tạo" : "Chuẩn đầu ra");

            $sheet->setCellValue('A9', 'Thang điểm');
            $sheet->setCellValue('B9', $survey['thang_diem']);

            // Ghi tiêu đề bảng
            $row = 10;
            foreach (array_values($headers) as $colIndex => $header) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex + 1); // Excel bắt đầu từ 1
                $sheet->setCellValue($colLetter . $row, $header);
                $sheet->getStyle($colLetter . $row)->getFont()->setBold(true);
            }

            // Ghi dữ liệu
            $row++;
            foreach ($data as $dataRow) {
                foreach (array_values($dataRow) as $colIndex => $value) {
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                    $sheet->setCellValue($colLetter . $row, $value);
                }
                $row++;
            }

            // Tự động điều chỉnh kích thước cột
            foreach (range('A', chr(64 + count($headers))) as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            return $spreadsheet;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage() . "\n";
        } finally {
            // Đóng kết nối
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
    public function getAllByNguoiLamKsId($nguoi_lamks_id)
    {
        if ($nguoi_lamks_id == null) {
            return [
                'error' => 'Thiếu tham số nguoi_lamks_id',
                'data' => []
            ];
        }

        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM kq_khao_sat WHERE status = 1 AND nguoi_lamks_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nguoi_lamks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();

        return [
            'data' => $data
        ];
    }

    public function getIdKhaoSatByNguoiLamKsId($nguoi_lamks_id)
    {
        // Kiểm tra tham số
        if ($nguoi_lamks_id === null) {
            return [
                'error' => 'Thiếu tham số nguoi_lamks_id',
                'data' => []
            ];
        }

        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT DISTINCT ks_id FROM kq_khao_sat WHERE status = 1 AND nguoi_lamks_id = ?");
        $stmt->bind_param("i", $nguoi_lamks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ks_ids = [];
        while ($row = $result->fetch_assoc()) {
            $ks_ids[] = $row['ks_id'];
        }

        return [
            'data' => $ks_ids
        ];
    }
    public function getByIdKhaoSatAndIdUser($kqks_id, $nguoi_lamks_id) 
{
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM kq_khao_sat WHERE ks_id = ? AND nguoi_lamks_id = ?");
    $stmt->bind_param("ii", $kqks_id, $nguoi_lamks_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}
}
