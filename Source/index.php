<?php
// public/index.php

$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/admin') === 0) {
    // Admin routing
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/router') {
        require __DIR__ . './controller/RouteController.php';
        $controller = new RouteController();
        $controller->loadView($_POST['route']);
        exit;
    }
    // Default to admin dashboard if no subpage specified
    $adminRoute = '/admin';
    if(strlen($requestUri) > strlen("/admin")){
        $adminRoute = $requestUri;
    }
    require __DIR__ . './controller/RouteController.php';
    $controller = new RouteController();
    $controller->loadView($adminRoute);
    exit;
} else {
    // User routing
    require __DIR__ . './controller/RouteController.php';
    $controller = new RouteController();
    $controller->loadView('/user');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>AJAX Routing</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav>
        <a href="/" data-route="/">Home</a>
        <a href="/about" data-route="/about">About</a>
        <a href="/user" data-route="/user">User</a>
        <a href="/admin" data-route="/admin">Admin</a>
    </nav>

    <div id="content">
        </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/script.js"></script>
</body>
</html>