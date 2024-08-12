<?php
define('DB_NAME','data/db.txt');
function generateReport(){
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
            </thead>\
            <tbody>
                <?php
                foreach($students as $student){
                ?>
                 <tr>
                    <td>
                        <?php printf('%s %s',$student['fname'], $student['lname']);?>
                    </td>
                    <td><?php printf('%d',$student['roll']);?></td>
                    <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
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


function isAdmin(){
    return ('admin' == $_SESSION['role']);
}

function isEditor(){
    return ('editor' == $_SESSION['role']);

}
function addStudent($fname,$lname,$roll){
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);
    foreach($students as $_student){
        if($_student['roll'] = $roll){
            $found = true;
            break;
        }
    }
    if(!$found){
        $newID = getNewId($students);
        $student = array(
            'id' => $newID,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );
        array_push($students,$student);
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData , LOCK_EX);
        return true;
    }
    return true ;

}

function getNewId($students){
    $maxId = max(array_column($students,'id'));
    return $maxId + 1;
}

?>