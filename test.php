 <?php
// $fp = fopen("./crud/users.txt", "r");

// if ($fp) {
//     echo "File opened successfully.";
//     // Remember to close the file after you are done
//     fclose($fp);
// } else {
//     echo "Failed to open the file.";
// }

// if (isEditor()) {
//     echo "Editor role is detected";
// }
// if (isAdmin()) {
//     echo "Admin role is detected";
// }

// <?php
//         if ($student_id ) {
//           printf("<h3>Editor role is detected %d<h3>".$student_id);
//       }
//       ?>


define('DB_NAME',"data/db.txt");
$serialiezedFile = file_get_contents(DB_NAME);
$printFile = unserialize($serialiezedFile);
print_r($printFile) ;



// define('DB_NAME', 'data/db.txt');
// function generateReport()
// {
//     $serializedData = file_get_contents(DB_NAME);
//     $students = unserialize($serializedData);
?>

