<?php
require_once __DIR__ . '/../../models/SurveyModel.php';
$surveyModel = new SurveyModel();
$listSurveyFieldAndQuestion = json_decode($surveyModel->getSurveyFieldAndQuestion($_GET['surveyId']), true);

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
                        echo    '<tr>
                                        <th class="normal-case w-1/2">' . $sttSurveyField . '. ' . $surveyField['ten_muc'] . '</th>
                                        <th class="normal-case w-1/20 text-center">1</th>
                                        <th class="normal-case w-1/20 text-center">2</th>
                                        <th class="normal-case w-1/20 text-center">3</th>
                                        <th class="normal-case w-1/20 text-center">4</th>
                                        <th class="normal-case w-1/20 text-center">5</th>
                                        <th class="normal-case w-1/20 text-center">6</th>
                                        <th class="normal-case w-1/20 text-center">7</th>
                                        <th class="normal-case w-1/20 text-center">8</th>
                                        <th class="normal-case w-1/20 text-center">9</th>
                                        <th class="normal-case w-1/20 text-center">10</th>
                                    </tr>';
                        foreach ($surveyField['cau_hoi'] as $question) {
                            echo    '<tr>
                                            <td name="txt-' . $question['ch_id'] . '">' . $question['noi_dung'] . '</td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="1" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="2" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="3" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="4" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="5" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="6" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="7" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="8" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="9" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-' . $question['ch_id'] . '" value="10" class="radio radio-primary" /></td>
                                        </tr>';
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