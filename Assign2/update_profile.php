<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    // Include the header, password library and configuration file
    include("header.inc");
    require 'lib/password.php';
    include 'config.php';?>
    
    <!-- Meta data for the HTML document -->
    <meta name="author" content="Huỳnh Nguyễn Quốc Bảo">
    <title>Update Profile</title>
</head>

<body>
    <header>
        <?php
        // Set the current page and include the menu and user check
        $currentPage = 'update_profile';
        include('menu.inc');
        session_start();
        include('user_check.php');
        ?>
        <div class="banner">
            <h1 id="applyh1">Update Profile</h1>
        </div>
    </header>

    <?php
        // Define the sanitize function to clean user input
        function sanitize($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            return $data;
        }

        // Define the password validation function
        function isPasswordValid($password){
            // Regex pattern for password validation
            $pattern = "/^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,}$/";
            return preg_match($pattern, $password);
        }

        // Get the user id from the session
        $user_id = $_SESSION['userId'];

        // If user id is not set, redirect to login page
        if(!isset($user_id)){
            header('location:login.php');
        };

        // If update_profile is set in POST, start the update process
        if (isset($_POST['update_profile'])) {
            // Prepare a SQL statement to get the password of the user
            $stmt = mysqli_prepare($conn, "SELECT password FROM `user_form` WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $fetch_pass = mysqli_fetch_assoc($result);
            $old_pass_hash = $fetch_pass['password'];

            $old_pass = $_POST['old_pass'];
            
            // Verify the old password using password_verify()
            if (empty($old_pass)) {
                $message[] = '<div class = "error_message">Please enter your password!</div>';
            } else if (!password_verify($old_pass, $old_pass_hash)) {
                $message[] = '<div class = "error_message">Invalid authentication password!</div>';
            } else {
                // Sanitize and escape the user input
                $update_name = mysqli_real_escape_string($conn, sanitize($_POST['update_name']));
                $update_email = mysqli_real_escape_string($conn, sanitize($_POST['update_email']));
            
                // Define the username validation function
                function isUsernameValid($username){
                    // Regex pattern for username validation
                    $pattern = "/^[a-zA-Z][a-zA-Z0-9]{4,}$/";
                    return preg_match($pattern, $username);
                }
            
                // Check if the username is valid
                if (!isUsernameValid($update_name)) {
                    $message[] = '<div class = "error_message">Username must be at least 5 characters long, start with a letter, and contain only letters and numbers.</div>';
                } else {
                    // Prepare a SQL statement to update the user's name and email
                    $stmt = mysqli_prepare($conn, "UPDATE `user_form` SET name = ?, email = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, 'ssi', $update_name, $update_email, $user_id);
                    mysqli_stmt_execute($stmt);
                    $message[] = '<div class = "success_message">Username changed successfully!</div>';    
                }

                // Check if the password fields are not empty and validate the new password
                $update_pass = '';
                if (isset($_POST['update_pass'])) {
                    $update_pass = mysqli_real_escape_string($conn, sanitize($_POST['update_pass']));
                }
                $new_pass = mysqli_real_escape_string($conn, sanitize($_POST['new_pass']));
                $confirm_pass = mysqli_real_escape_string($conn, sanitize($_POST['confirm_pass']));
                // Check if any of the password fields are not empty
                if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
                        if ($update_pass != $old_pass && !empty($update_pass)) {
                            $message[] = '<div class = "error_message">Old password does not match!</div>';
                        } else if (!isPasswordValid($new_pass)) {
                            $message[] = '<div class = "error_message">New password does not meet the requirements.</div>';
                        } else if ($new_pass != $confirm_pass) {
                            $message[] = '<div class = "error_message">Confirm password does not match!</div>';
                        } else {
                            // Hash the new password and update it in the database
                            $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                            $stmt = mysqli_prepare($conn, "UPDATE `user_form` SET password = ? WHERE id = ?");
                            mysqli_stmt_bind_param($stmt, 'si', $new_pass_hash, $user_id);
                            mysqli_stmt_execute($stmt);
                            $message[] = '<div class = "error_message">Password updated successfully!</div>';
                        }
         
                }
                // Check if the image is not empty and update it in the database
                $update_image = $_FILES['update_image']['name'];
                $update_image_size = $_FILES['update_image']['size'];
                $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
                $update_image_folder = 'uploaded_img/' . $update_image;
    
                if (!empty($update_image)) {
                    if ($update_image_size > 2000000) {
                        $message[] = '<div class = "error_message">Image is too large.</div>';
                    } else {
                        $stmt = mysqli_prepare($conn, "UPDATE `user_form` SET image = ? WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, 'si', $update_image, $user_id);
                        mysqli_stmt_execute($stmt);
                        if (mysqli_stmt_affected_rows($stmt) > 0) {
                            move_uploaded_file($update_image_tmp_name, $update_image_folder);
                        }
                        $message[] = '<div class = "success_message">Image updated successfully!</div>';
                    }
                }
            }
            // Unset the old password from POST
            unset($_POST['old_pass']);
        }

    ?>

    <div class="update-profile">

        <?php
            // Prepare a SQL statement to get the user's data
            $stmt = mysqli_prepare($conn, "SELECT * FROM `user_form` WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0){
                $fetch = mysqli_fetch_assoc($result);
        }
        ?>

        <!-- Form for updating the profile -->
        <form action="" method="post" enctype="multipart/form-data">
        <?php
            // Display the user's image or a default one if it doesn't exist
            if($fetch['image'] == ''){
                echo '<img src="images/default-avatar.png">';
            }else{
                echo '<img src="uploaded_img/'.$fetch['image'].'">';
            }
            // Display any messages
            if(isset($message)){
                foreach($message as $message){
                    echo $message;
                }
            }
        ?>
        <div class="flex">
            <div class="inputBox">
                <!-- Input fields for updating the username, email and profile picture -->
                <span>Update your username:</span>
                <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                <span>Update your email:</span>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                <span>Update your profile picture:</span>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            </div>
            <div class="inputBox">
                <!-- Input fields for updating the password -->
                <span>New password:</span>
                <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                <span>Password confirmation:</span>
                <input type="password" name="confirm_pass" placeholder="Re-enter the password" class="box">
                <span>Authentication</span>
                <input type="password" name="old_pass" placeholder="Enter current password" class="box" value="<?php echo isset($_POST['old_pass']) ? $_POST['old_pass'] : ''; ?>">
            </div>
        </div>
        <!-- Submit button for the form -->
        <input type="submit" value="Update Profile" name="update_profile" class="btn">
        <a href="dashboard.php" class="delete-btn">Return to Dashboard</a>
        </form>

    </div>

    <?php include("footer.inc"); ?>
</body>

</html>