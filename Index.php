<?php
require "./Includes/class-autoload.inc.php";
$page_title = "Create Task";
require_once("Templates/Header.php");
$taskController = new TaskRepository();

$allTask = $taskController->countAll('task');
$completedTask = $taskController->countWhere('task', 'completed', 1);
$unCompletedTask = $taskController->countWhere('task', 'completed', 0);
?>

<body>
    <div class="container">
        <div class="row mt-5 justify-content-center">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Task</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Process.php">

                            <?php if (isset($message)) $taskController->scream($message); ?>

                            <div class="form-group">
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter task title" required>
                            </div>

                            <div class="form-group">
                                <textarea name="detail" id="detail" class="form-control" placeholder="Enter task description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success" name="addTask">Add Task <span>&#43;</span></button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">

                    <div class="card-header">
                        <p><strong>All Tasks:</strong>
                            <?php
                            $taskController->scream($taskController->toQuantity($allTask, 'task'));
                            ?>
                        </p>

                        <p><strong>Completed Tasks:</strong>
                            <?php
                            $taskController->scream($taskController->toQuantity($completedTask, 'task'));
                            ?>
                        </p>

                        <p><strong>Uncompleted Tasks:</strong>
                            <?php
                            $taskController->scream($taskController->toQuantity($unCompletedTask, 'task'));
                            ?>
                        </p>
                    </div>

                    <div class="card-body">
                        <ul class='list-group'>
                            <?php

                            $result = $taskController->getAllTask();

                            if (!empty($result)) {

                                foreach ($result as $key) {
                            ?>
                                    <li class='list-group-item'>
                                        <h4>
                                            <?php $taskController->scream($key['title']); ?>
                                        </h4>

                                        <p><?php $taskController->scream($key['detail']); ?></p>

                                        <?php
                                        if ($key['completed'] == 0) {
                                            $status = "<span class='badge badge-dark float-right'>Uncompleted</span>";
                                        } else {
                                            $status = "<span class='badge badge-success float-right'>Completed</span>";
                                        }

                                        $taskController->scream($status);
                                        ?>
                                        <p>
                                            <?php $taskController->scream($taskController->timeAgo($key['created_at'])); ?>
                                        </p>

                                        <div class="btn-group">
                                            <a class="btn btn-primary" href="EditTask.php?id=<?php $taskController->scream($key['id']); ?>">
                                                Edit
                                            </a>
                                            <a class="btn btn-danger btn-del" href="Process.php?send=del&id=<?php $taskController->scream($key['id']); ?>">
                                                Delete
                                            </a>
                                        </div>
                                    </li>
                                <?php
                                }
                                ?>

                        </ul>

                    <?php } else { ?>
                        <h4 class='text-danger text-center mt-3'>You currently have <?php $taskController->scream($taskController->toQuantity($allTask, 'task')) ?> in your todo list</h4>
                    <?php } ?>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <?php include_once 'Templates/Footer.php'; ?>