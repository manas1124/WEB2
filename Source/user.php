<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/output.css">
</head>
<body>
<h1 class="text-2xl font-bold mb-4">Admin Panel</h1>
    <nav>
        <a href="admin.php?page=dashboard&admin=true" class="nav-link" data-page="dashboard">Dashboard</a>
        <a href="admin.php?page=settings&admin=true" class="nav-link" data-page="ctdtPage">ctdt</a>
        <a href="admin.php?page=settings&admin=true" class="nav-link" data-page="ctdtPage">ctdt</a>
        <a href="index.php">User Panel</a>
    </nav>
   
    <div id="content">Loading...</div>

    <script src="./assets/js/adminScript.js"></script>
</body>
</html>
