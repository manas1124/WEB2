<?php
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Converts Excel file to JSON format
 * 
 * @param string $filePath
 * @return array
 */
function survey_content_excel_to_json($filePath)
{
    try {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $sectionNames = $data[0]; // dòng 1 chứa tên mục
        $jsonOutput = [];

        for ($col = 1; $col < count($sectionNames); $col++) {
            $section = $sectionNames[$col];
            if (!$section) continue;

            $questions = [];
            for ($row = 2; $row < count($data); $row++) {
                $question = $data[$row][$col] ?? null;
                if ($question && trim($question) !== '') {
                    $questions[] = trim($question);
                }
            }

            $jsonOutput[] = [
                'sectionName' => trim($section),
                'questions' => $questions
            ];
        }

        return $jsonOutput;

    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
