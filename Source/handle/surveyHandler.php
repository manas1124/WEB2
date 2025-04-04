<?php
    if(isset($_GET['surveyId']) && $_GET['surveyId']) {
        require_once '../views/user/doSurvey.php';
    } 
    else {
        echo 'No surveyId provided';
    }
?>