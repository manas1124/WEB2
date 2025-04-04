<?php
require_once __DIR__ . '/../../models/SurveyModel.php';
$surveyModel = new SurveyModel();
$listSurveyFieldAndQuestion = json_decode($surveyModel->getSurveyFieldAndQuestion($_GET['surveyId']), true);

?>

<div class="flex flex-col gap-4 p-12">
    <div class="border-base-content/25 w-full rounded-lg border">
        <div class="overflow-x-auto">
            <table class="table">
                <?php
                    $sttSurveyField = 1;
                    $sttQuestion = 1;
                    foreach($listSurveyFieldAndQuestion as $mks => $surveyField) {
                        echo    '<tr>
                                    <th class="normal-case w-1/2">'. $sttSurveyField .'. '. $surveyField['ten_muc'] .'</th>
                                    <th class="normal-case w-1/10 text-center">Rất không hài lòng</th>
                                    <th class="normal-case w-1/10 text-center">Không hài lòng</th>
                                    <th class="normal-case w-1/10 text-center">Bình thường</th>
                                    <th class="normal-case w-1/10 text-center">Hài lòng</th>
                                    <th class="normal-case w-1/10 text-center">Rất hài lòng</th>
                                </tr>';
                        foreach($surveyField['noi_dung'] as $question) {
                            echo    '<tr>
                                        <td>'. $question .'</td>
                                        <td class="text-center"><input type="radio" name="radio-'. $sttQuestion .'" class="radio radio-primary" id="radioInline1" /></td>
                                        <td class="text-center"><input type="radio" name="radio-'. $sttQuestion .'" class="radio radio-primary" id="radioInline1" /></td>
                                        <td class="text-center"><input type="radio" name="radio-'. $sttQuestion .'" class="radio radio-primary" id="radioInline1" /></td>
                                        <td class="text-center"><input type="radio" name="radio-'. $sttQuestion .'" class="radio radio-primary" id="radioInline1" /></td>
                                        <td class="text-center"><input type="radio" name="radio-'. $sttQuestion .'" class="radio radio-primary" id="radioInline1" /></td>
                                    </tr>';
                            $sttQuestion++;

                    
                        }
                        $sttSurveyField++;
                    }
                ?>
            </table>
            
        </div>
    </div>
    <button class="btn btn-primary">Nộp khảo sát</button>
</div>