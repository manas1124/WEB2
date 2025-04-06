<?php

if(isset($_GET['act']) && $_GET['act']) {
    $act = $_GET['act'];
        if($act == 'do-survey') {
            require_once '../views/user/doSurvey.php';
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
        $surveyId = $_POST['surveyId'];
        $username = $_POST['username'];
        $accountModel = new AccountModel();
        $account = json_decode($accountModel->getAccount($username), true);
        

        $surveyReulstModel = new SurveyResultModel();
        $data = [
            'dt_id' => $account['dt_id'],
            'ks_id' => $surveyId,
            'status' => 1
        ];
        $surveyResult = $surveyReulstModel->createResult($data);
        return $surveyResult['id'];
    }



?>