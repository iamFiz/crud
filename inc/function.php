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
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php printf('%s %s', $student['fname'], $student['lname']); ?></td>
                <td><?php printf('%d', $student['roll']); ?></td>
                <td>
                    <?php if (isAdmin() || isEditor()): ?>
                        <a href="./index.php?task=update&id=<?php echo $student['id']; ?>">Edit</a>
                    <?php endif; ?>
                    <?php if (isAdmin()): ?>
                        |
                        <a href="./index.php?task=delete&id=<?php echo $student['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

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
        $students = [];
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
            'roll' => $roll,
        );
        array_push($students, $student);
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}

function doUpdate($id, $fname, $lname, $roll)
{
    $serialized = file_get_contents(DB_NAME);
    $students = unserialize($serialized);

    foreach ($students as &$student) {
        if ($student['id'] == $id) {
            $student['fname'] = $fname;
            $student['lname'] = $lname;
            $student['roll'] = $roll;
            break;
        }
    }

    $serializedData = serialize($students);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX);
}

function getNewId($students)
{
    if (empty($students)) {
        return 1;
    }
    $maxId = max(array_column($students, 'id'));
    return $maxId + 1;
}

function getStudentById($id)
{
    $serialized = file_get_contents(DB_NAME);
    $students = unserialize($serialized);

    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student;
        }
    }
    return null;
}

function deleteStudent($id)
{
    $serialized = file_get_contents(DB_NAME);
    $students = unserialize($serialized);

    // Filter out the student with the given ID
    $students = array_filter($students, function($student) use ($id) {
        return $student['id'] != $id;
    });

    // Reindex the array to avoid gaps in the keys
    $students = array_values($students);

    // Serialize and save the updated data back to the file
    $serializedData = serialize($students);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX);
}

?>