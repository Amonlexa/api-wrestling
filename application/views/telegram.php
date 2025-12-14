<!DOCTYPE html>
<html>
<head>
    <title>Login with Telegram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login with Telegram</h2>
        
        <script async src="https://telegram.org/js/telegram-widget.js?22"
                data-telegram-login="AmonlexaWrestlingBot"
                data-size="large"
                data-onauth="onTelegramAuth(user)"
                data-request-access="write">
        </script>
        
        <div id="avatar-container" style="margin-top: 20px;"></div>
        
        <script type="text/javascript">
            function onTelegramAuth(user) {
                alert('Logged in as ' + user.first_name + ' (ID: ' + user.id + ')');
                
                fetch('/telegram_auth/callback', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(user)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                });
            }
        </script>
    </div>
</body>
</html>