<?php
// session_start(
//     [
//         'cookie_lifetime' => 500,
//     ]
// );
session_start();
require_once "./inc/function.php";
$task  = $_GET['task'] ?? 'report';

if(isset($_POST['submit'])){
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $roll = $_POST['roll'];
  addStudent($fname,$lname,$roll);
};
if(isset($_POST['submit']) && 'update' == $task){
  $id = $_POST['id'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $roll = $_POST['roll'];
  doUpdate($id,$fname, $lname, $roll);
  header("Location: ./index.php?task=report"); // Redirect after update
    // exit;
    header('location:././index.php');
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
    <title>CRUD design with SESSION Technques</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-5">CRUD design with SESSION Technques</h2>
        <p>A sample project to perform CRUD operations using plain files and PHP</p>
        
        <!-- Include navigation -->
       <div class="container m-2">
       <?php include ('./inc/templates/nav.php'); ?>
       </div>
   <?php
   if('report' == $task):
   ?>     
    <div class="container ">
    <?php generateReport(); ?> <!-- Report generated here -->
    </div>
<?php
endif;
?>
<?php
     if('add' == $task):
?>

<div class="container mt-5 mx-auto col-md-6">
<form action="./index.php?task=add" method="post">
  <div class="form-row">
    <div class="col">
      <input type="text" name="fname"  class="form-control" placeholder="First name">
    </div>
    <div class="col">
      <input type="text" name="lname"  class="form-control" placeholder="Last name">
    </div>
    <div class="col">
      <input type="text" name="roll"  class="form-control" placeholder="Roll">
    </div>
  </div>
  <button type="submit" name="submit" class="btn btn-primary mt-3">Save</button>
</form>
</div>

<?php
endif;
?>
<?php
if('update' == $task):
  // $student_id = $_GET['id'] ?? null;
  $student_id = $_GET['id'];

  // $student = getStudentById($student_id);
  if ($student_id) {
    $student = getStudentById($student_id);
}
if ($student):  // Ensure $student is not null

?>
<div class="container mt-5 mx-auto col-md-6">
<form action="./index.php?task=update" method="post">
  <div class="form-row">
  <input type="hidden" name="id" value="<?php echo $student['id']; ?>"> <!-- Add hidden field for ID -->
    <div class="col">
      <input type="text" name="fname"  class="form-control" placeholder="First name" value="<?php 
      echo $student['fname'];
      ?>">
    </div>
    <div class="col">
      <input type="text" name="lname"  class="form-control" placeholder="Last name" value="<?php 
      echo $student['lname'];
      ?>">
    </div>
    <div class="col">
      <input type="text" name="roll"  class="form-control" placeholder="Roll" value="<?php 
      echo $student['roll'];
      ?>">
    </div>
  </div>
  <button type="submit" name="submit" class="btn btn-primary mt-3">Update</button>
</form>
</div>

<?php
 else:
  echo "<p class='alert alert-danger'>Student not found.</p>"; // Show an error if student is not found
 endif;

endif;
?>
<?php
if('delete' == $task ):
?>
   <!-- modal start  -->
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button> -->

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you really want to delete this student?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <!-- 'Yes' button will trigger the deletion -->
        <button type="button" class="btn btn-primary" id="confirmDelete">Yes</button>
      </div>
    </div>
  </div>
</div>

   <!-- modal end here  -->
<?php
endif;
?>
    <!-- Bootstrap JS and dependencies (Optional) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
  $('#deleteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var studentId = button.data('id'); // Extract student ID from data-* attribute
      
      // Update the modal's content if needed
      var modal = $(this);
      modal.find('.modal-body').text('Are you sure you want to delete student with ID ' + studentId + '?');
      
      // Handle the confirmation
      $('#confirmDelete').off('click').on('click', function () {
          window.location.href = './index.php?task=delete&id=' + studentId;
      });
  });
</script>

</body>

</html>
