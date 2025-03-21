<?php
if (isset($_POST['page'])) {
    $page = $_POST['page'];
    $role = isset($_POST['admin']) ? "admin" : "user";
    $file = "../views/admin/$page.php";

    if (file_exists($file)) {
        include $file;
    } else {
        echo "Page not found!";
    }
}
?>