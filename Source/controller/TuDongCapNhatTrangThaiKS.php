<?php
require_once __DIR__ . '/../models/khaoSatModel.php';
$ksModel = new KhaoSatModel();
$status = $ksModel->capNhatTrangThaiSuDungTuDong();
if ($status) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Cập nhật trạng thái thành công'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi cập nhật trạng thái'
    ]);
}
