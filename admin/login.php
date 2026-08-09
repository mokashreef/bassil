<?php
session_start();
$admin_password = "add your password"; // Default password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && $_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "كلمة المرور غير صحيحة!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; width: 300px; }
        input[type="password"] { padding: 12px; width: 90%; margin: 15px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 12px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>لوحة إدارة الموقع</h2>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <br>
            <button type="submit">دخول</button>
        </form>
    </div>
</body>
</html>
