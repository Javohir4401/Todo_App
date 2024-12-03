<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=todo_app', 'root', '1112');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ma'lumotlar bazasiga ulanishda xatolik: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'], $_POST['due_date'])) {
    $task = trim($_POST['task']);
    $due_date = $_POST['due_date'];
    if (!empty($task) && !empty($due_date)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO todo (title, status, due_date, created_at) VALUES (:title, 'pending', :due_date, NOW())");
            $stmt->execute([':title' => $task, ':due_date' => $due_date]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            die("Vazifani qo'shishda xatolik: " . $e->getMessage());
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM todo WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Vazifani o'chirishda xatolik: " . $e->getMessage());
    }
}

if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    try {
        $stmt = $pdo->prepare("
            UPDATE todo 
            SET status = 
                CASE 
                    WHEN status = 'completed' THEN 'pending'
                    WHEN status = 'in_progress' THEN 'completed'
                    ELSE 'in_progress'
                END
            WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Holatni o'zgartirishda xatolik: " . $e->getMessage());
    }
}

try {
    $stmt = $pdo->query("SELECT * FROM todo ORDER BY created_at DESC");
    $todos = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
} catch (PDOException $e) {
    die("Ma'lumotlarni olishda xatolik: " . $e->getMessage());
}
?>
