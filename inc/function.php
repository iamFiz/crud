<?php
define('DB_NAME', 'data/db.txt');
function generateReport()
{
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
?>
    <table class="table table-striped mt-3">
        <thead>
            
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Roll</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
// Generate the report table and include Edit and Delete links
foreach ($students as $student) {
?>
    <tr>
        <td><?php printf('%s %s', $student['fname'], $student['lname']); ?></td>
        <td><?php printf('%d', $student['roll']); ?></td>
        <td>
            <?php if (isAdmin() || isEditor()): ?>
                <a href="./index.php?task=update&id=<?php echo $student['id']; ?>">Edit</a> <!-- Correct URL -->
            <?php endif; ?>
            <?php if (isAdmin()): ?>
                | <a href="./index.php?task=delete&id=<?php echo $student['id']; ?>">Delete</a> <!-- Correct URL -->
            <?php endif; ?>
        </td>
    </tr>
<?php
}
?>

        </tbody>
    </table>
<?php
}
?>
<?php


function isAdmin()
{
    return ('admin' == $_SESSION['role']);
}

function isEditor()
{
    return ('editor' == $_SESSION['role']);
}
function addStudent($fname, $lname, $roll)
{
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    if ($students === false) {
        $students = []; // <-- Initialize as an empty array if unserialize fails
    }

    foreach ($students as $_student) {
        if ($_student['roll'] == $roll) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $newID = getNewId($students);
        $student = array(
            'id' => $newID,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );
        array_push($students, $student);
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return true;
}

function doUpdate($id,$fname, $lname, $roll){
    $found = false;
    // define('DB_NAME',"data/db.txt");
    $serialiezed = file_get_contents(DB_NAME);
    $students = unserialize($serialiezed);
    foreach($students as $student){
        if($student['id'] == $id){
            $student['fname'] = $fname;
            $student['lname'] = $lname;
            $student['roll'] = $roll;
            break;
        }
    }
    $serializedData = serialize($students);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX); // Save the updated data back to the file

}

function getNewId($students)
{
    if (empty($students)) {
        return 1; // <-- Return 1 if the students array is empty
    }
    $maxId = max(array_column($students, 'id'));
    return $maxId + 1;
}

function getStudentById($id){
    $serialiezed = file_get_contents(DB_NAME);
    $students = unserialize($serialiezed);
    foreach ($students as $student){
        if($student['id'] == $id){
            return $student;
        }
    }
    return null;
}

?>