<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    // Include the header file
    include("header.inc"); ?>
    <meta name="author" content="Huỳnh Nguyễn Quốc Bảo">
    <title>Login</title>
</head>

<body>
    <header>
        <?php
        // Set the current page
        $currentPage = 'login';
        // Include the menu file
        require_once('menu.inc');
        echo '<li><a href="login.php"  class = "active">Login</a></li>';
        echo '<li><a href="register.php">Register</a></li>';
        echo '</ul>';
        echo '</nav>';
        ?>
        <div class="banner">
            <h1 id="applyh1">Login</h1>
        </div>
    </header>

    <?php
    // Include the password library and configuration file
    require 'lib/password.php';
    include 'config.php';

    // Define the sanitize function
    function sanitize($data) {
        // Remove spaces, slashes and convert special characters
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $data;
    }

    // Start the session
    session_start();

    // Check if user is already logged in
    if (isset($_SESSION['userId'])) {
        // Redirect to dashboard
        header('Location: dashboard.php');
        exit;
    }

    // Check if email and password are empty
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            // Check if the user is locked out
            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5) {
                if (isset($_SESSION['last_attempt_time']) && (time() - $_SESSION['last_attempt_time']) < 60) {
                    // User is locked out
                    $message[] = 'You have been locked out. Please wait 60 seconds and try again.';
                } else {
                    // Reset the login attempts and last attempt time
                    $_SESSION['login_attempts'] = 0;
                    unset($_SESSION['last_attempt_time']);
                }
            }

            if (!isset($_SESSION['login_attempts']) || $_SESSION['login_attempts'] < 5) {
                // Sanitize and escape email and password
                $email = mysqli_real_escape_string($conn, sanitize($_POST['email']));
                $password = mysqli_real_escape_string($conn, sanitize($_POST['password']));
                // Prepare the query
                $query = "SELECT * FROM user_form WHERE email=?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                
                // Execute the query
                // $result = mysqli_query($conn, $query);
                $result = mysqli_stmt_get_result($stmt);
                // Check if the query was successful
                if ($result) {
                    // Check if there is one user with the provided email
                    if (mysqli_num_rows($result) == 1) {
                        // Fetch the user data
                        $row = mysqli_fetch_assoc($result);
                        $hashedPassword = $row['password'];
                        // Verify the password
                        if (password_verify($password, $hashedPassword)) {
                            // Login successful
                            $userId = $row['id'];
                            $username = $row['name'];
                            $privileges = $row['privileges'];

                            // Start session and store user information
                            session_start();
                            $_SESSION['userId'] = $userId;
                            $_SESSION['username'] = $username;
                            $_SESSION['privileges'] = $privileges;

                            // Redirect to a logged-in page
                            header('Location: dashboard.php');
                            exit;
                        } else {
                            // Invalid email or password
                            $message[] = 'Invalid email or password';
                            // Increase the login attempts and set the last attempt time
                            $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
                            $_SESSION['last_attempt_time'] = time();
                        }
                    } else {
                        // Invalid email or password
                        $message[] = 'Invalid email or password';
                        // Increase the login attempts and set the last attempt time
                        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
                        $_SESSION['last_attempt_time'] = time();
                    }
                } else {
                    // Error occurred while executing the query
                    $message[] = 'Error occurred while executing the query: ' . mysqli_error($conn);
                }
            }
        }
        // else tell user they have to enter email or pass
        else {
            $message[]='Email or password is missing';
        }
    }
    ?>

    <div class="login-container">
        <div class="loginbox-container">
            <form action="login.php" method="post" enctype="multipart/form-data">
                <h2>Welcome back!</h2>
                <?php
                // Check if there are any messages
                if (isset($message)) {
                    // Display each message
                    foreach ($message as $message) {
                        echo '<div class="error-message">' . $message . '</div>';
                    }
                }
                ?>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="text" name="email" placeholder="Email" class="box">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Password" class="box">
                </div>
                <input type="submit" value="Log In" class="btn">
                <p>Don't have an account? <a href="register.php"><span class="register" id="link_to_register">Register now</span></a></p>
            </form>
        </div>
    </div>

    <?php 
    // Include the footer file
    include("footer.inc"); ?>
</body>

</html>