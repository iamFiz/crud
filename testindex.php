<?php
if ('update' == $task):
    // Get student ID from the URL parameter (This is added code)
    $student_id = $_GET['id'];
    $student = getStudentById($student_id); // <-- Added function call to fetch student data by ID
?>
<div class="container mt-5 mx-auto col-md-6">
<form action="./index.php?task=update" method="post">
  <div class="form-row">
    <div class="col">
      <input type="hidden" name="id" value="<?php echo $student['id']; ?>"> <!-- Hidden input for ID (Added) -->
      <input type="text" name="fname"  class="form-control" value="<?php echo $student['fname']; ?>" placeholder="First name"> <!-- Pre-fill (Added) -->
    </div>
    <div class="col">
      <input type="text" name="lname"  class="form-control" value="<?php echo $student['lname']; ?>" placeholder="Last name"> <!-- Pre-fill (Added) -->
    </div>
    <div class="col">
      <input type="text" name="roll"  class="form-control" value="<?php echo $student['roll']; ?>" placeholder="Roll"> <!-- Pre-fill (Added) -->
    </div>
  </div>
  <button type="submit" name="submit" class="btn btn-primary mt-3">Update</button>
</form>
</div>
<?php
endif;
?>

<?php
// Existing code...

// Added function to fetch student by ID
function getStudentById($id) {
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student; // Return the student data
        }
    }
    return null; // Return null if student not found
}
?>

