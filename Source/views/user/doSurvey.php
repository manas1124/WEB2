<?php
require_once __DIR__ . '/../../models/SurveyModel.php';
require_once __DIR__ . '/../../models/loaiTraLoiModel.php';
$surveyModel = new SurveyModel();
$answerType = new TraLoiModel();
$listSurveyFieldAndQuestion = json_decode($surveyModel->getSurveyFieldAndQuestion($_GET['surveyId']), true);
$typeScore = $answerType->getTraLoiByIdKhaoSat($_GET['surveyId']);

?>
<form action="" name="survey-form">
    <div class="flex flex-col gap-4 p-12">
        <div class="border-base-content/25 w-full rounded-lg border">
            <div class="overflow-x-auto">
                <table class="table">
                    <?php
                    echo    '<tr>
                                <th class="normal-case w-1/2">Nội dung khảo sát</th>
                                <th class="normal-case w-1/2 text-center" colspan="10">Mực độ hài lòng</th>
                                </tr>';
                    $sttSurveyField = 1;
                    foreach ($listSurveyFieldAndQuestion as $surveyField) {
                        $phanSo = 1 / 2 / $typeScore['thang_diem'];
                        echo    '<tr>
                                        <th class="normal-case w-1/2">' . $sttSurveyField . '. ' . $surveyField['ten_muc'] . '</th>
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
                                echo '<td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value='. $i .' class="radio radio-primary" /></td>';
                            }
                            echo '</tr>';
                        }
                        $sttSurveyField++;
                    }
                    ?>
                </table>

            </div>
        </div>
        <button class="btn btn-primary" name="send-survey" type="button" onclick=sendSurvey(this)>Nộp khảo sát</button>
    </div>
</form>