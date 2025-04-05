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
                        $sttSurveyField = 1;
                        foreach($listSurveyFieldAndQuestion as $surveyField) {
                            echo    '<tr>
                                        <th class="normal-case w-1/2">'. $sttSurveyField .'. '. $surveyField['ten_muc'] .'</th>
                                        <th class="normal-case w-1/10 text-center">Rất không hài lòng</th>
                                        <th class="normal-case w-1/10 text-center">Không hài lòng</th>
                                        <th class="normal-case w-1/10 text-center">Bình thường</th>
                                        <th class="normal-case w-1/10 text-center">Hài lòng</th>
                                        <th class="normal-case w-1/10 text-center">Rất hài lòng</th>
                                    </tr>';
                            foreach($surveyField['cau_hoi'] as $question) {
                                echo    '<tr>
                                            <td name="txt-'. $question['ch_id'] .'">'. $question['noi_dung'] .'</td>
                                            <td class="text-center"><input type="radio" name="radio-'. $question['ch_id'] .'" value="rkhl" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-'. $question['ch_id'] .'" value="khl" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-'. $question['ch_id'] .'" value="bt" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-'. $question['ch_id'] .'" value="hl" class="radio radio-primary" /></td>
                                            <td class="text-center"><input type="radio" name="radio-'. $question['ch_id'] .'" value="rhl" class="radio radio-primary" /></td>
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