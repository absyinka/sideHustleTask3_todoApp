<?php
include "./Includes/class-autoload.inc.php";

$task = new TaskRepository();

if (isset($_POST['addTask'])) {
    $title = $task->sanitizeInput($_POST['title']);
    $description = $task->sanitizeInput($_POST['detail']);

    $task->addTask($title, $description);

    header("location: {$_SERVER['HTTP_ORIGIN']}/index.php?status=added");
} else if ($_GET['send'] === 'del') {
    $id = $_GET['id'];
    $task->deleteTask($id);

    header("location: {$_SERVER['HTTP_ORIGIN']}/index.php?status=deleted");
} else if ($_GET['send'] === 'update') {

    $id = $_GET['id'];

    $title = $task->sanitizeInput($_POST['title']);

    $description = $task->sanitizeInput($_POST['detail']);

    if (isset($_POST['mark'])) {
        $completed = 1;
    } else {
        $completed = 0;
    }

    $task->editTask($id, $title, $description, $completed);

    header("location: {$_SERVER['HTTP_ORIGIN']}/index.php?status=updated");
}
