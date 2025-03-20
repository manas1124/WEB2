<?php
// app/Controllers/RouteController.php

class RouteController {
    public function loadView($route) {
        $viewPath = __DIR__ . './views/';

        switch ($route) {
            case '/':
                include $viewPath . 'user.php';
                break;
            case '/admin':
                include $viewPath . 'admin.php';
                break;
            case '/admin/test':
                include $viewPath . 'admin_a.php';
                break;
            case '/admin/home':
                include $viewPath . 'admin_b.php';
                break;
            default:
                http_response_code(404);
                echo '404 Not Found';
                break;
        }
    }
}
?>