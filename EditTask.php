<?php
$page_title = "Update Task";
include_once 'Templates/Header.php';

include "./Includes/class-autoload.inc.php";
$taskUpdate = new TaskRepository();

$task = $taskUpdate->getTaskDetail($_GET['id']);
$id = $task['id'];
$title = $task['title'];
$description = $task['detail'];
$completed = $task['completed'];
?>

<body>
    <div class="container">
        <div class="row mt-5 justify-content-center">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Update Task</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Process.php?send=update&id=<?php $taskUpdate->scream($id) ?>">

                            <?php if (isset($message)) $taskController->scream($message); ?>

                            <div class="form-group">
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter task title" required value="<?php $taskUpdate->scream($title) ?>">
                            </div>

                            <div class="form-group">
                                <textarea name="detail" id="detail" class="form-control" placeholder="Enter task description"><?php $taskUpdate->scream($description) ?></textarea>
                            </div>

                            <div class="form-group">
                                <?php if ($completed == 1) { ?>
                                    <input type="checkbox" name="mark" checked> Task Completed
                                <?php } else { ?>
                                    <input type="checkbox" name="mark"> Mark Task as Completed
                                <?php } ?>
                            </div>

                            <button type="submit" class="btn btn-primary" name="updateTask">Update Task</button>

                            <a href="Index.php" class="btn btn-link float-right">Back to home</a>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <?php include_once 'Templates/Footer.php'; ?>