<?php
// Start the session with a cookie lifetime of 300 seconds (5 minutes)
// session_start(
//     [
//         'cookie_lifetime' => 500,
//     ]
// );
session_start();
$error = false;
// session_destroy();
// Initialize 'loggedin' key in the session if it's not already set
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
    session_destroy();
}

$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
$fp = fopen("C:\\xampp\\htdocs\\crud\\data\\users.txt", "r");
if($username && $password){
// if (isset($_POST['username']) && isset($_POST['password'])) {
$_SESSION['loggedin'] = false;
$_SESSION['user'] = false;
$_SESSION['role'] = false;
while($data = fgetcsv($fp)){
// Check if the username and password are set in the POST request

    // Validate the username and password
    // if ('admin' == $_POST['username'] && 'rabbit' == $_POST['password']) {
    if ($data[0] == $username && $data[1]  == sha1($password)) {
        // If credentials are correct, set 'loggedin' to true
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $data[2];

        // header('location:./crud/index.php');
        header('location:./index.php');
    }
    if(!$_SESSION['loggedin']) {
        $error = true;
    }
}
}

// Check if there is a 'logout' parameter in the GET request
if (isset($_GET['logout'])) {
    // If 'logout' is set, set 'loggedin' to false to log out the user
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    session_destroy();
    // header('location:index.php');
    header('Location:./index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set and viewport settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS CDN for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Page title -->
                <h2 class="text-center mt-5">Login Page</h2>
                <p class="text-center">
                    <?php
// echo md5("rabbit") . "</br>"; //hash function md5
// Display a message based on the login status
if ($_SESSION['loggedin']) {
    echo "Hello Admin, Welcome - ".$data[2];
} else {
    echo "Please enter your username and password below";
}
?>
                </p>
                <?php
if ($error) {
    echo "<blockquote>username and password didn't match</blockquote>";
}
// Display the login form if the user is not logged in
if (!$_SESSION['loggedin']):
?>
                <form method="POST">
                    <div class="form-group">
                        <!-- Username input field -->
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <!-- Password input field -->
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                    </div>
                    <!-- Login button -->
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <?php
// Display the logout button if the user is logged in
else:
?>
                <!-- <form action="auth.php?logout=true" method="POST"> -->
                <form action="./crud/auth.php" method="POST" >
                    <!-- Logout button -->
                     <input type="hidden" name="logout" value="1">
                    <button type="submit" class="btn btn-primary btn-block">Log Out</button>
                </form>
                <?php
endif;
?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript dependencies for Bootstrap functionality -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
