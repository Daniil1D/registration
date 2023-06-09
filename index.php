<?php
include('bd.php');

if(isset($_POST['go'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if(!$login || !$password) {
        $error = 'Вы не ввели логин или пароль';
    }

    if(!isset($error)) {
        // Проверка на существование пользователя с таким же логином
        $checkQuery = "SELECT * FROM `users` WHERE `login` = '$login'";
        $checkResult = mysqli_query($link, $checkQuery);

        if(mysqli_num_rows($checkResult) > 0) {
            // Пользователь с таким логином уже существует
            echo "<script>window.location.href='existing_user.php';</script>";
            exit;
        } else {
            $query = "INSERT INTO `users` (`id`, `login`, `password`) VALUES (NULL, '$login', '$password');";
            mysqli_query($link, $query);
            echo 'Вы успешно создали пользователя';

            // Перенаправление на страницу авторизации
            header("Location: avtorizacia.php");
            exit;
        }
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="styleregister.css">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <?php
    if(isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    ?>
    <form method="POST">
        <p>Логин:<input type="text" name="login"></p>
        <p>Пароль:<input type="password" name="password"></p>
        <p><input type="submit" name="go" value="Зарегистрироваться"></p>
    </form>
    
    <!-- Кнопка для перехода на страницу авторизации -->
    <form method="GET" action="avtorizacia.php">
        <p><input type="submit" value="Авторизоваться"></p>
    </form>
</body>
</html>