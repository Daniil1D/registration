<?php
$link = mysqli_connect('localhost', 'root', '', 'avtorizacia');

// Проверка соединения с базой данных
if (!$link) {
    die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
}

// Обработка POST-запроса на удаление записи
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteTodo'])) {
        $deleteTodoId = $_POST['deleteTodo'];

        // Подготовка и выполнение запроса на удаление записи из базы данных
        $query = "DELETE FROM `Todo List` WHERE `id` = $deleteTodoId";
        mysqli_query($link, $query);

        // Перенаправление на текущую страницу для обновления
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Обработка POST-запроса при нажатии на кнопку "Done"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['completeTodo'])) {
        $completeTodoId = $_POST['completeTodo'];

        // Подготовка и выполнение запроса на обновление записи в базе данных
        $query = "UPDATE `Todo List` SET `status` = 'Done' WHERE `id` = $completeTodoId";
        mysqli_query($link, $query);

        // Перенаправление на текущую страницу для обновления
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Обработка POST-запроса для добавления новой записи
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newTodo'])) {
        $newTodo = $_POST['newTodo'];

        // Подготовка и выполнение запроса на добавление записи в базу данных
        $query = "INSERT INTO `Todo List` (`Name`, `status`) VALUES ('$newTodo', 'Undone')";
        mysqli_query($link, $query);

        // Перенаправление на текущую страницу для обновления
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Todo App</title>
</head>

<body>
    <div id="root" role="main" class="container">
        <div class="todo-app">
            <div class="app-header d-flex">
                <h1>Todo List</h1>
                <h2>1 more to do, 3 done</h2>
            </div>
            <div class="top-panel d-flex">
                <input type="text" class="form-control search-input" placeholder="type to search">
                <div class="btn-group">
                    <button type="button" class="btn btn-info" onclick="location.href='?tab=all'">All</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="location.href='?tab=active'">Active</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="location.href='?tab=done'">Done</button>
                </div>
            </div>
            <ul class="list-group todo-list">
                <?php
                // Выполнение запроса на получение записей из базы данных
                if (isset($_GET['tab'])) {
                    $tab = $_GET['tab'];

                    if ($tab === 'active') {
                        $selectQuery = "SELECT * FROM `Todo List` WHERE `status` = 'Undone'";
                    } else if ($tab === 'done') {
                        $selectQuery = "SELECT * FROM `Todo List` WHERE `status` = 'Done'";
                    } else {
                        $selectQuery = "SELECT * FROM `Todo List`";
                    }
                } else {
                    $selectQuery = "SELECT * FROM `Todo List`";
                }

                $result = mysqli_query($link, $selectQuery);

                // Вывод полученных записей
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['Name'];
                    $status = $row['status'];

                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    echo '<span class="todo-list-item">' . $name . '</span>';

                    // Проверка статуса и вывод соответствующих кнопок
                    if ($status === 'Done') {
                        echo '<form method="POST" class="ml-auto">';
                        echo '<input type="hidden" name="completeTodo" value="' . $id . '">';
                        echo '<button type="submit" class="btn btn-outline-success btn-sm float-right"><i class="fa fa-check"></i></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="POST" class="ml-auto">';
                        echo '<input type="hidden" name="completeTodo" value="' . $id . '">';
                        echo '<button type="submit" class="btn btn-outline-secondary btn-sm float-right"><i class="fa fa-exclamation"></i></button>';
                        echo '</form>';
                    }

                    echo '<form method="POST" class="ml-auto">';
                    echo '<input type="hidden" name="deleteTodo" value="' . $id . '">';
                    echo '<button type="submit" class="btn btn-outline-danger btn-sm float-right mr-2"><i class="fa fa-trash"></i></button>';
                    echo '</form>';
                    echo '</li>';
                }
                ?>
            </ul>
            <form class="bottom-panel d-flex" method="POST">
                <input type="text" class="form-control new-todo-label" placeholder="What needs to be done?" name="newTodo" required>
                <button type="submit" class="btn btn-outline-secondary ml-auto" style="margin-left: auto;">Add</button>
            </form>
        </div>
    </div>
</body>

</html>