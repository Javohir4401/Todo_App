<?php

require_once 'DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (:task)");
        $stmt->execute([':task' => $task]);
        header("Location: todo_app.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: todo_app.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .todo-body {
            max-width: 75%;
            margin: auto;
            box-shadow: 0 0 3px 3px gray;
            padding: 20px;
            border-radius: 8px;
        }
        .todo-text {
            font-weight: bold;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-center my-5">
        <div class="todo-body">
            <h1 class="text-center todo-text">Todo App</h1>
            <form method="POST" class="input-group mb-3">
                <input name="task" type="text" class="form-control" placeholder="Vazifa kiriting" required>
                <button type="submit" class="btn btn-outline-success">Qo‘shish</button>
            </form>
            <ul class="list-group">
                <?php foreach ($todos as $todo): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($todo['task']) ?>
                        <a href="todo_app.php?delete=<?= $todo['id'] ?>" class="btn btn-outline-primary">O'chirish</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<script>
    const todoInput = document.getElementById('todoInput');
    const addTodo = document.getElementById('addTodo');
    const todoList = document.getElementById('todoList');

    addTodo.addEventListener('click', () => {
        const todoText = todoInput.value.trim();

        if (todoText === '') {
            alert('Iltimos, vazifa kiriting!');
            return;
        }

        const listItem = document.createElement('li');
        listItem.className = 'list-group-item';

        const textNode = document.createTextNode(todoText);
        const deleteButton = document.createElement('button');
        deleteButton.textContent = "O'chirish";
        deleteButton.className = 'btn btn-outline-primary';
        deleteButton.onclick = () => {
            todoList.removeChild(listItem);
        };

        listItem.appendChild(textNode);
        listItem.appendChild(deleteButton);
        todoList.appendChild(listItem);

        todoInput.value = '';
    });
</script>
</body>
</html>
