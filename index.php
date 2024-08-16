<?php
session_start();
require_once "./inc/function.php";

$task  = $_GET['task'] ?? 'report';

if (isset($_POST['submit']) && $task === 'add') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $roll = $_POST['roll'];
    addStudent($fname, $lname, $roll);
    header("Location: ./index.php?task=report");
    exit;
}

if (isset($_POST['submit']) && $task === 'update') {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $roll = $_POST['roll'];
    doUpdate($id, $fname, $lname, $roll);
    header("Location: ./index.php?task=report");
    exit;
}

if ($task === 'delete') {
    $id = $_GET['id'];
    deleteStudent($id);
    header("Location: ./index.php?task=report");
    exit;
}

// Ensure session key 'loggedin' is set
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD design with SESSION Techniques</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">CRUD design with SESSION Techniques</h2>
        <p>A sample project to perform CRUD operations using plain files and PHP</p>
        
        <!-- Include navigation -->
        <div class="container m-2">
            <?php include ('./inc/templates/nav.php'); ?>
        </div>

        <?php if ($task === 'report'): ?>
            <div class="container">
                <?php generateReport(); ?>
            </div>
        <?php endif; ?>

        <?php if ($task === 'add'): ?>
            <div class="container mt-5 mx-auto col-md-6">
                <form action="./index.php?task=add" method="post">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" name="fname" class="form-control" placeholder="First name">
                        </div>
                        <div class="col">
                            <input type="text" name="lname" class="form-control" placeholder="Last name">
                        </div>
                        <div class="col">
                            <input type="text" name="roll" class="form-control" placeholder="Roll">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($task === 'update'): ?>
            <?php
            $student_id = $_GET['id'];
            $student = getStudentById($student_id);
            if ($student):
            ?>
                <div class="container mt-5 mx-auto col-md-6">
                    <form action="./index.php?task=update" method="post">
                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="fname" class="form-control" placeholder="First name" value="<?php echo $student['fname']; ?>">
                            </div>
                            <div class="col">
                                <input type="text" name="lname" class="form-control" placeholder="Last name" value="<?php echo $student['lname']; ?>">
                            </div>
                            <div class="col">
                                <input type="text" name="roll" class="form-control" placeholder="Roll" value="<?php echo $student['roll']; ?>">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            <?php else: ?>
                <p class='alert alert-danger'>Student not found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
