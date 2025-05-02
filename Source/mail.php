<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <textarea id="email" placeholder="Enter your email"></textarea>
    <textarea id="subject" placeholder="Enter subject"></textarea>
    <textarea id="body" placeholder="Enter email body"></textarea>
    <button id="sendEmail">Send Email</button>
    <script>
        document.getElementById('sendEmail').addEventListener('click', function() {
            const startTime = Date.now();
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const body = document.getElementById('body').value;
            const listEmail = email.split('\n');
            console.log(listEmail);
            $.ajax({
                url: '../Source/utils/MailUtil.php',
                type: 'POST',
                data: {
                    act: 'send-mail',
                    listEmail: listEmail,
                    subject: subject,
                    body: body
                },
                success: function(response) {
                    const endTime = Date.now();
                    console.log((endTime - startTime) / 1000);
                    alert(response);
                },
                error: function(xhr, status, error) {
                    alert('Error sending email: ' + error);
                }
            });
            
        });
    </script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>
</html>