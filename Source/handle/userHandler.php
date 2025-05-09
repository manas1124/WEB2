<?php
// Sanitize and validate the 'page' parameter
// $allowedPages = ["qlKhaoSatPage", "ctdtPage", "taiKhoanPage"];
$page = isset($_GET["page"]) ? $_GET["page"] : null;

// Sanitize and validate the 'act' parameter
// $allowedActs = ["ks-tao", "ks-sua"]; && in_array($_GET["act"], $allowedActs) 
$act = isset($_GET["act"]) ? $_GET["act"] : null;

$response = [];

$response["text"] = "first $page";

if ($page) {

    switch ($page) {
        case "home":
            ob_start();
            require_once("../home.php");
            $response["html"] = ob_get_clean();
            break;
        case "survey":
            ob_start();
            require_once("../views/user/survey.php");
            $response["html"] = ob_get_clean();
            break;
        case "result-survey":
            ob_start();
            require_once("../views/user/ketQuaKhaoSatUser.php");
            $response["html"] = ob_get_clean();
            break;
        case "result-survey-ct":
            ob_start();
            require_once("../views/user/ketQuaKhaoSatUser.php");
            $response["html"] = ob_get_clean();
            break;
        case "login":
            ob_start();
            require_once("../login.php");
            $response["html"] = ob_get_clean();
            break;
        case "user-infor":
            ob_start();
            require_once("../views/user/userInfor.php");
            $response["html"] = ob_get_clean();
            break;
        default:
            $response["html"] = `loi trang handle`;
            $response["error"] = "Invalid page requested.";
            break;
    }
}

if ($act) {
    switch ($act) {
        case "xem-kqks":
            ob_start();
            require_once("../views/user/ketQuaKhaoSat-ctUser.php");
            $response["html"] = ob_get_clean();
            break;
        default:
            $response["html"] = "load trang bi";
            $response["error"] = "Invalid action requested.";
            break;
    }
} else {
    $response["error"] = "No page or action specified.";
}

$response["text"] = "end $page";

// Set the content type to JSON
header('Content-Type: application/json');

echo json_encode($response);
