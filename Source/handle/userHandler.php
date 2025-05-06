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
            require_once("../views/admin/ketQuaKhaoSat.php");
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
        // case "ks-tao":
        //     ob_start();
        //     $filePath = "../views/admin/qlKhaoSatPage-tao.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "ks-sua":
        //     ob_start();
        //     $filePath = "../views/admin/qlKhaoSatPage-edit.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "ctdt-them":
        //     ob_start();
        //     $filePath = "../views/admin/ctdtPage-them.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "ctdt-sua":
        //     ob_start();
        //     $filePath = "../views/admin/ctdtPage-sua.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "nganh-them":
        //     ob_start();
        //     $filePath = "../views/admin/nganh-them.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "nganh-sua":
        //     ob_start();
        //     $filePath = "../views/admin/nganh-sua.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "chuky-them":
        //     ob_start();
        //     $filePath = "../views/admin/chuky-them.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "chuky-sua":
        //     ob_start();
        //     $filePath = "../views/admin/chuky-sua.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "tk-them":
        //     ob_start();
        //     $filePath = "../views/admin/taikhoanPage-them.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "tk-edit":
        //     ob_start();
        //     $filePath = "../views/admin/taikhoanPage-edit.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
        // case "tk-xoa":
        //     ob_start();
        //     $filePath = "../views/admin/taikhoanPage.php";
        //     require_once($filePath);
        //     $response["html"] = ob_get_clean();
        //     break;
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
