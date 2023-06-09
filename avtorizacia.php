<?php
include('bd.php');

if(isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if(!$login || !$password) {
        $error = 'Вы не ввели логин или пароль';
    } else {
        $query = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) == 1) {
            echo 'Вы успешно авторизовались';

            // Перенаправление на страницу с указанным HTML-кодом
            header("Location: glavnai1.php");
            exit;
        } else {
            $error = 'Неправильный логин или пароль';
        }
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="styleavtorizacia.css">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <?php
    if(isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    ?>
    <form method="POST">
        <p>Логин:<input type="text" name="login"></p>
        <p>Пароль:<input type="password" name="password"></p>
        <p><input type="submit" value="Войти"></p>
    </form>
</body>
</html>