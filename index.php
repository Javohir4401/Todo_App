<?php
require 'todo_app.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .todo-body {
            max-width: 75%;
            margin: auto;
            box-shadow: 0 0 3px 3px black;
            padding: 20px;
            border-radius: 8px;
        }

        .text-pending {
            color: bold
            font-weight: #e49e07;
        }

        .text-in-progress {
            color: #00c4ff;
            font-weight: #0066ff;
        }

        .text-completed {
            color: #86f186;
            font-weight: #05ffbe;
        }

        .task-controls {
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-center my-5">
        <div class="todo-body">
            <h1 class="text-center">Todo App</h1>
            <form method="POST" class="input-group mb-3">
                <input name="task" type="text" class="form-control" placeholder="Vazifa kiriting" required>
                <input name="due_date" type="datetime-local" class="form-control" placeholder="Muddatni tanlang" required>
                <button type="submit" class="btn btn-outline-success">Qo‘shish</button>
            </form>
            <ul class="list-group">
                <?php if (!empty($todos)): ?>
                    <?php foreach ($todos as $todo): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="<?=
                                $todo['status'] === 'completed' ? 'text-completed' :
                                ($todo['status'] === 'in_progress' ? 'text-in-progress' : 'text-pending') ?>">
                                <?= htmlspecialchars($todo['title']) ?>
                            </span>
                            <div class="task-controls">
                                <a href="todo_app.php?toggle=<?= $todo['id'] ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <?= $todo['status'] === 'completed' ? 'Pending' :
                                        ($todo['status'] === 'in_progress' ? 'Completed' : 'In Progress') ?>
                                </a>
                                <a href="todo_app.php?delete=<?= $todo['id'] ?>" class="btn btn-sm btn-outline-danger">O'chirish</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item text-center">Hozircha vazifalar yo'q</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
