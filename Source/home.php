<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <link rel="shortcut icon" href="./assets/image/sgu.png">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/output.css" />
    <link rel="stylesheet" href="assets/css/user.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        input:disabled,
        select:disabled {
            opacity: 1;
            /* Make the text fully visible */
            background-color: rgb(255, 255, 255);
            /* Match the background color */
            color: rgb(0, 0, 0);
            /* Keep original text color */
            border: 1px solid rgb(216, 216, 216);
            /* Keep original border color */
            cursor: not-allowed;
            /* Optional: change cursor */
        }
    </style>
</head>

<body>
    
    <?php require_once "./views/include/headerUser.php" ?>

    <div id="main-content" class="h-full w-full">
        <main class="hero">
            <div>
                <h1 class="font-bold text-[3rem] uppercase">Khảo sát sinh viên</h1>
                <hr />
                <h1 class="text-[1.5rem] uppercase">Trường đại học Sài Gòn</h1>
            </div>
        </main>


    </div>

    <?php require_once "./views/include/footerUser.php" ?>

    <script src="../node_modules/flyonui/flyonui.js"></script>
    <script src="./views/javascript/indexUser.js"></script>
    <script src="./views/javascript/survey.js"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>