<?php
$fp = fopen("./crud/users.txt", "r");

if ($fp) {
    echo "File opened successfully.";
    // Remember to close the file after you are done
    fclose($fp);
} else {
    echo "Failed to open the file.";
}

?>