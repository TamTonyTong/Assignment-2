<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    // Include the header file
    include("header.inc"); ?>
    <meta name="author" content="Huỳnh Nguyễn Quốc Bảo">
    <title>Dashboard</title>
</head>

<body>
    <header>
        <?php
        // Start the session
        session_start();
        // Include the configuration file
        include 'config.php';
        // Get the user ID from the session
        $user_id = $_SESSION['userId'];
        // Set the current page
        $currentPage = 'dashboard';
        // Query the database for the user's information
        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
        $fetch = mysqli_fetch_assoc($select);
        // Include the menu file
        include('menu.inc');
        // Check if the user is logged in
        if (isset($_SESSION['userId'])) {
            // Display the dashboard and welcome message
            echo '<li><a href="dashboard.php" class="active" ">Dashboard</a></li>';
            echo '<li><a>Welcome, ' . $fetch["name"] . '</a></li>';
            echo '</ul>';
            echo '</nav>';
        }
        // Get the user's privileges
        $privileges = $_SESSION['privileges'];
        // If the user is not logged in, redirect to the login page
        if (!isset($user_id)) {
            header('location:login.php');
        };
        // If the logout link is clicked, log out the user and redirect to the login page
        if (isset($_GET['logout'])) {
            unset($user_id);
            session_destroy();
            header('location:login.php');
        }
        ?>
        <div class="banner">
            <h1 id="applyh1">Dashboard</h1>
        </div>
    </header>

    <div class="dashboard-container">
        <div class="profile_dashboard">
            <?php
            // Query the database for the user's information again
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
            // If the user has no image, display a default avatar
            if ($fetch['image'] == '') {
                echo '<img src="images/default-avatar.png">';
            } else {
                // Otherwise, display the user's image
                echo '<img src="uploaded_img/' . $fetch['image'] . '">';
            }
            ?>
            <p><?php echo $fetch['name']; ?></p>
            <?php //echo $fetch['privileges']; ?>
            <p><?php 
            $email = $fetch['email'];
            echo "Your email address: $email"; 
            $email = $fetch['email']; // Assuming $fetch['email'] contains the email address

            // Prepare the SQL query with a placeholder for the email address
            $query = "SELECT EOINUM FROM EOI WHERE `Email Address` = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                // Bind the email address parameter
                mysqli_stmt_bind_param($stmt, "s", $email);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Store the result set
                mysqli_stmt_store_result($stmt);

                // Check if any rows were returned
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Fetch the result
                    mysqli_stmt_bind_result($stmt, $EOINUM);
                    mysqli_stmt_fetch($stmt);

                    // Output the EOI number
                    echo "<p>EOI Number for this email</p>";
                    echo "<p>$EOINUM</p>";
                } else {
                    // No EOI found for the given email
                    echo "<p>No EOI found for this email</p>";
                    echo "<a href='apply.php'>We noticed you haven't submitted any application for our company's roles. If you're still interested, we highly encourage you to apply! </a>";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                // Error in preparing the statement
                echo "Error: " . mysqli_error($conn);
            } ?></p>
            <?php 
            // If the user is an admin, display the manage site link
            if ($privileges == "admin") {
                echo "<a href=\"add_jobs.php\" class=\"btn\">Post New Positions</a>";
                echo "<a href=\"manage.php\" class=\"btn\">Manage site</a>";
            } ?>
            <a href="update_profile.php" class="btn">Update profile</a>
            <a href="logout.php" class="delete-btn">Logout</a>
        </div>

    </div>

    <?php 
    // Include the footer file
    include("footer.inc"); ?>
</body>

</html>