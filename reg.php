<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊帳號</title>
    <style>
        .error { color: red; }
        .weak { color: red; }
        .strong { color: green; }
    </style>
</head>
<body>
    <h2>註冊帳號</h2>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 'username_taken'): ?>
        <p class="error">這個帳號已經被使用，請選擇其他帳號。</p>
    <?php endif; ?>

    <form id="register-form" action="register.php" method="POST">
        <label for="username">帳號:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">密碼:</label>
        <input type="password" id="password" name="password" required><br><br>
        <span id="password-feedback"></span><br><br>

        <input type="submit" value="註冊">
    </form>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const feedback = document.getElementById('password-feedback');
            let feedbackText = '';

            // 使用 AJAX 檢查 Bloom Filter 是否包含弱密碼
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'bloom.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // 如果小於6 or 沒通過BF
                    if (xhr.responseText === 'weak' || password.length < 6) {
                        feedbackText = '密碼太弱，請避免使用常見密碼';
                        feedback.className = 'weak';
                    } else {
                        feedbackText = '密碼強';
                        feedback.className = 'strong';
                    }
                    feedback.textContent = feedbackText;
                }
            };
            xhr.send('password=' + encodeURIComponent(password));
        });
    </script>
</body>
</html>
