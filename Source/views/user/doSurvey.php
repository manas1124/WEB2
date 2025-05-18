<?php
require_once __DIR__ . '/../../models/SurveyModel.php';
require_once __DIR__ . '/../../models/loaiTraLoiModel.php';
$surveyModel = new SurveyModel();

$answerType = new TraLoiModel();

// $listSurveyFieldAndQuestion = json_decode($surveyModel->getSurveyFieldAndQuestion($listEx), true);

$typeScore = $answerType->getTraLoiByIdKhaoSat($_GET['surveyId']);
$listParent = json_decode($surveyModel->getAllParent($_GET['surveyId']), true); // Muc cha


function isExistsParent($mks_id) {
    global $surveyModel;
    return $surveyModel->isExistsParent($mks_id);
}

function genTable($mks_id, $isParent, $stt) {
    global $surveyModel;
    // global $answerType;
    global $typeScore;
    $listSurveyFieldAndQuestion = json_decode($surveyModel->getSurveyFieldAndQuestion($mks_id, $isParent), true);
    
    echo ' <div class="border-base-content/25 w-full rounded-lg border">
                <table class="table">';
        echo    '<tr>
                    <th class="normal-case w-1/2">Nội dung khảo sát</th>
                    <th class="normal-case w-1/2 text-center" colspan="10">Mực độ hài lòng</th>
                    </tr>';
        $sttSurveyField = 1;
        foreach ($listSurveyFieldAndQuestion as $surveyField) {
            $phanSo = 1 / 2 / $typeScore['thang_diem'];
            echo    '<tr>
                            <th class="normal-case w-1/2 font-semibold">' . $stt . '.' . $sttSurveyField . '. ' . $surveyField['ten_muc'] . '</th>
                    ';
            for ($i = 1; $i <= $typeScore['thang_diem']; $i++) {
                echo '<th class="normal-case w-1/' . $phanSo . ' text-center">' . $i . '</th>';
            }
            echo '</tr>';
            foreach ($surveyField['cau_hoi'] as $question) {
                echo    '<tr>
                                <td name="txt-' . $question['ch_id'] . '">' . $question['noi_dung'] . '</td>
                        ';
                for ($i = 1; $i <= $typeScore['thang_diem']; $i++) {
                    echo '<td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value=' . $i . ' class="radio radio-primary" /></td>';
                }
                echo '</tr>';
            }
            $sttSurveyField++;
        }
    
    echo '</table>
        </div>';

}

function genNote() {
    global $typeScore;
    $listDetails = explode(', ', $typeScore['chitiet_mota']);
    echo '<div class="list__radio flex gap-8 p-12 justify-center">';
    foreach ($listDetails as $index => $detail) {
        echo '<div class="radio__note flex items-center flex-col">
                <span>'. ucfirst($detail) .'</span>
                <div class="radio flex">
                    <span class="font-medium mr-[3px] mt-[-4px]">'. $index + 1 .'</span>
                </div>
            </div>';
    }

    echo '</div>';
}

genNote();
?>


<form action="" name="survey-form">
    <div class="flex flex-col gap-4 p-12">
        <?php
            $stt = 1;
            foreach($listParent as $parent) {
                if ($parent['parent_mks_id'] == null) {
                    echo '<span class="font-semibold">'. $stt . '. ' . $parent['ten_muc'] .'</span>';
                    genTable($parent['mks_id'], isExistsParent($parent['mks_id']), $stt);
                    $stt++;
                }
            }
        ?>
        
        
        <div class="flex items-center justify-end mb-4">
            <div class="flex items-center gap-8">
                <div>
                    <a href="./home.php">
                        <button class="btn btn-error" type="button">Hủy</button>
                    </a>
                </div>
                <div>
                    <button class="btn btn-primary" name="send-survey" type="button" onclick=sendSurvey(this)>Nộp khảo sát</button>
                </div>

            </div>
        </div>
    </div>
</form>