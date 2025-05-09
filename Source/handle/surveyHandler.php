<?php
    require_once '../utils/JwtUtil.php';
    session_start();
    if(isset($_GET['act']) && $_GET['act']) {
        $act = $_GET['act'];
            if($act == 'do-survey') {
                if (isset($_SESSION['accessToken']) && $_SESSION['accessToken']) {
                    $accessToken = $_SESSION['accessToken'];
                    $isVaid = isAuthorization($accessToken, 'view.survey');
                    if ($isVaid) {
                        require_once '../views/user/doSurvey.php';
                    }
                    else {
                        echo 'Ko có quyền truy cập!';
                        exit;
                    }
                }
                else {
                    echo 'hihi!';
                    exit;
                }
                
                
            }
        
    }
else if (isset($_POST['act']) && $_POST['act']) {
    if ($_POST['act'] == 'send-survey') {
        require_once '../models/AnswerModel.php';
        $data = json_decode($_POST['data'], true);
        // foreach($data as $key => $value) {
        //     echo "{$key}, {$value} <br>";
        //     // Save the answer to the database or process it as needed
        //     // Example: saveAnswerToDatabase($questionId, $answer);
        // }
        $kqks_id = doSurvey();
        $answerModel = new AnswerModel();
        foreach($data as $key => $value) {
            $record = [
                'kqks_id' => $kqks_id,
                'ch_id' => $key,
                'ket_qua' => $value,
                'status' => 1
            ];
            if ($answerModel->createAnswer($record) == null) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra khi gửi khảo sát!'
                ]);
                return;
            };
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Đã gửi khảo sát thành công!'
        ]);

    }
}

    function doSurvey() {
        require_once '../models/AccountModel.php';
        require_once '../models/SurveyResultModel.php';
        require_once '../utils/JwtUtil.php';

        
        $accessToken = $_SESSION['accessToken'];
        $surveyId = $_POST['surveyId'];
        $dt_id = getObjectId($accessToken);
        $accountModel = new AccountModel();

        $surveyReulstModel = new SurveyResultModel();
        $data = [
            'dt_id' => $dt_id,
            'ks_id' => $surveyId,
            'status' => 1
        ];
        $surveyResult = $surveyReulstModel->createResult($data);
        return $surveyResult['id'];
    }



?>