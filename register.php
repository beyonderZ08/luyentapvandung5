<?php
$errors = [];
$oldData = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $repeatPassword = isset($_POST['repeat-password']) ? $_POST['repeat-password'] : '';

    // Check for empty username
    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập họ tên.";
    }

    // Check for empty email and validate email format
    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ.";
    }

    // Check for password length
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    // Check if passwords match
    if ($password !== $repeatPassword) {
        $errors['repeat-password'] = "Mật khẩu xác nhận không khớp.";
    }

    // If no errors, show success message and clear the form
    if (empty($errors)) {
        echo "<p>Chào mừng bạn, $username! Đăng ký thành công.</p>";
        // Optionally clear form fields
        $username = $email = $password = $repeatPassword = '';
    } else {
        // Retain form data to avoid re-entry
        $oldData = $_POST;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./reset.css" />
    <link rel="stylesheet" href="./style.css" />
    <title>Register Page</title>
</head>
<body>
    <div class="wrapper fade-in-down">
        <div id="form-content">
            <!-- Tabs Titles -->
            <a href="./login.php">
                <h2 class="inactive underline-hover">Đăng nhập</h2>
            </a>
            <a href="./register.php">
                <h2 class="active">Đăng ký</h2>
            </a>

            <!-- Icon -->
            <div class="fade-in first">
                <img src="./imgs/avatar.png" id="avatar" alt="User Icon" />
            </div>

            <!-- Registration Form -->
            <form method="POST" action="">
                <input
                    type="text"
                    id="username"
                    class="fade-in first"
                    name="username"
                    placeholder="Họ tên"
                    value="<?= htmlspecialchars($oldData['username'] ?? '') ?>"
                />
                <?php if (isset($errors['username'])): ?>
                    <p class="error"><?= $errors['username'] ?></p>
                <?php endif; ?>

                <input
                    type="email"
                    id="email"
                    class="fade-in second"
                    name="email"
                    placeholder="Email"
                    value="<?= htmlspecialchars($oldData['email'] ?? '') ?>"
                />
                <?php if (isset($errors['email'])): ?>
                    <p class="error"><?= $errors['email'] ?></p>
                <?php endif; ?>

                <input
                    type="password"
                    id="password"
                    class="fade-in third"
                    name="password"
                    placeholder="Mật khẩu"
                    value="<?= htmlspecialchars($oldData['password'] ?? '') ?>"
                />
                <?php if (isset($errors['password'])): ?>
                    <p class="error"><?= $errors['password'] ?></p>
                <?php endif; ?>

                <input
                    type="password"
                    id="repeat-password"
                    class="fade-in fourth"
                    name="repeat-password"
                    placeholder="Xác nhận mật khẩu"
                    value="<?= htmlspecialchars($oldData['repeat-password'] ?? '') ?>"
                />
                <?php if (isset($errors['repeat-password'])): ?>
                    <p class="error"><?= $errors['repeat-password'] ?></p>
                <?php endif; ?>

                <input type="submit" class="fade-in five" value="Đăng ký" />
            </form>

            <!-- Remind Password -->
            <div id="form-footer">
                <a class="underline-hover" href="#">Quên mật khẩu?</a>
            </div>
        </div>
    </div>
</body>
</html>
