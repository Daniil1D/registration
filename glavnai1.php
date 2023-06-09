<?php
$link = mysqli_connect('localhost', 'root', '', 'avtorizacia');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newTodo'])) {
        $newTodo = $_POST['newTodo'];

        // Подготовка и выполнение запроса на добавление записи в базу данных
        $query = "INSERT INTO `Todo List` (`id`, `Name`) VALUES (NULL, '$newTodo')";
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
<input
          type="text"
          class="form-control search-input"
          placeholder="type to search"
        />
        <div class="btn-group">
            <button type="button" class="btn btn-info">All</button
            ><button type="button" class="btn btn-outline-secondary">
              Active</button
            ><button type="button" class="btn btn-outline-secondary">
              Done
            </button>
          </div>
</div>
      <ul class="list-group todo-list">
        
       
<?php
        // Выполнение запроса на получение записей из базы данных
        $selectQuery = "SELECT * FROM `Todo List`";
        $result = mysqli_query($link, $selectQuery);

        // Вывод полученных записей
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['Name'];

            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
            echo '<span class="todo-list-item">' . $name . '</span>';
            echo '<form method="POST" class="ml-auto">'; // Добавлен класс "ml-auto" к форме
            echo '<input type="hidden" name="deleteTodo" value="' . $id . '">';
            echo '<button type="submit" class="btn btn-outline-danger btn-sm">';
            echo '<i class="fa fa-trash-o"></i></button>';
            echo '</form>';
            echo '<button type="button" class="btn btn-outline-success btn-sm ml-2">';
            echo '<i class="fa fa-exclamation"></i></button>';
            echo '</li>';
        }
        ?>
      
     
</ul>
      <form class="bottom-panel d-flex" method="POST">
        <input type="text" class="form-control new-todo-label" placeholder="What needs to be done?" name="newTodo" required>
        <button
          type="submit"
          class="btn btn-outline-secondary ml-auto"
          style="margin-left: auto;"
        >
          Add
        </button>
      </form>
    </div>
  </div>
</body>
</html>