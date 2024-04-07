<?php
    if (isset($_SESSION['userId'])) {
        require_once 'config.php';
        $query = "SELECT * FROM `user_form` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $fetch = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        } else {
            // Handle the case where the prepared statement failed
            die('Query preparation failed');
        }
        echo '<li><a href="dashboard.php" >Dashboard</a></li>';
        echo '<li><a href="dashboard.php">Welcome, ' . $fetch["name"] . '</a></li>';
        echo '</ul>';
        echo '</nav>';
      }
      else{
        echo '<li><a href="login.php">Login</a></li>';
          echo '<li><a href="register.php">Register</a></li>';
          echo '</ul>';
          echo '</nav>';
      } 