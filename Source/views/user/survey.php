<?php
    require_once __DIR__ .'/../../models/SurveyModel.php';

    $surveyModel = new SurveyModel();
    $listSurvey = json_decode($surveyModel->getAllSurveys(), true);

    foreach($listSurvey as $survey) { 
        echo '<div class="card sm:max-w-sm">
                    <div class="card-header">
                        <h5 class="card-title">'. $survey['ten_ks'] .'</h5>
                    </div>
                    <div class="card-body">
                        <p>Nhóm khảo sát: '. $survey['nks_id'] .'</p>
                        <p>Ngày bắt đầu: '. $survey['ngay_bat_dau'] .'</p>
                        <p>Ngày Kết thúc: '. $survey['ngay_ket_thuc'] . '</p>

                        <button class="btn btn-primary" '. ($survey['su_dung'] == 1 ? '' : 'disabled') .' onclick="doSurvey(this, '. $survey['ks_id'] .')" data-act="do-survey">Làm khảo sát</button>
                    </div>
                </div>';
    }
    
?>


