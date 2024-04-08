<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('header.inc');
    session_start();
    $privileges = $_SESSION['privileges'];
    $user_id = $_SESSION['userId'];
    // Check if user is already logged in
    if ($privileges !== "admin") {
        header('location: dashboard.php');
    } elseif (!isset($user_id)) {
        header('location: index.php');
    }
    ?>
    <meta name="author" content="Tống Đức Từ Tâm">
    <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>" type="text/css" />
    <title>HR Checking</title>
</head>

<body>
    <h1 id="HR">HR Managing Site</h1>
    <form method="post" action="manage.php">
        <div class="HR_style">
            <select name="query_type">
                <option value="Show All Records">Show All Records</option>
                <option value="Show Records by Job Reference Number">Show Records by Job References Number</option>
                <option value="Show Records by Names">Show Records by Names</option>
                <option value="Delete Records by Job Reference Number">Delete Records by Job Reference Number</option>
                <option value="Change Status of an EOI">Change Status of an EOI</option>
            </select>
            <input id="blank">
            <br>
            <p>
                <label for="job_ref_num"> Job Reference Number
                    <input type="text" name="job_ref_num">
                </label>
            </p>
            <label for="first_name"> First Name
                <input type="text" name="first_name">
            </label>
            <label for="last_name"> Last Name
                <input type="text" name="last_name">
            </label>
            </p>
            <p>
                <label for="EOINUM"> EOI Number
                    <input type="text" name="EOINUM">
                </label>
                <label for="Status"> New Status
                    <!-- <input type="select" name="Status"> -->
                    <select name="Status" id=manage_status>
                        <option value=""></option>
                        <option>Current</option>
                        <option>Final</option>
                    </select>
                </label>
            </p>
            <input type="submit" value="Submit">
            <a href="dashboard.php" class="delete-btn">Return to Dashboard</a>
    </form>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //var_dump($_POST);
        require_once("config.php");
        function sanitise_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
        $job_ref_num = sanitise_input($_POST["job_ref_num"]);
        $EOINUM = sanitise_input($_POST['EOINUM']);
        $Status = sanitise_input($_POST['Status']);
        $first_name = sanitise_input($_POST["first_name"]);
        $last_name = sanitise_input($_POST["last_name"]);
        if ($_POST['query_type'] === "Change Status of an EOI") {
            $update_query = "UPDATE EOI SET `Status` = ? WHERE `EOINUM` = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "ss", $Status, $EOINUM);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Status of EOI with EOI $EOINUM has been changed to $Status successfully.";
            } else {
                echo "None is changed.";
            }
        }
        if ($_POST['query_type'] === "Delete Records by Job Reference Number") {
            $delete_query = "DELETE FROM `EOI` WHERE Job_Reference_Number = ?";
            $stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($stmt, "s",$job_ref_num);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            if ($affected_rows > 0) {
                echo "All EOIs with job reference number $job_ref_num have been deleted successfully.";
                exit;
            } else {
                echo "No EOIs found with job reference number $job_ref_num.";
                exit;
            }
        }

        if ($_POST['query_type'] === "Show All Records") {
            $query = "SELECT * FROM `EOI`";
            $result = mysqli_query($conn, $query);
        } elseif ($_POST['query_type'] === "Show Records by Job Reference Number") {
            $job_ref_num = sanitise_input($_POST["job_ref_num"]);
            $query = "SELECT * FROM `EOI` WHERE Job_Reference_Number = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $job_ref_num);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } elseif ($_POST['query_type'] === "Show Records by Names") {
            $query = "SELECT * FROM `EOI` WHERE `First Name` = ? OR `Last Name` = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss",$first_name,$last_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table border=\"1\">\n";
            echo "<tr>\n"
                . "<th scope= \"col\">EOINUM</th>\n"
                . "<th scope= \"col\">Status</th>\n"
                . "<th scope= \"col\">Job Reference Number</th>\n"
                . "<th scope= \"col\">First Name</th>\n"
                . "<th scope= \"col\">Last Name</th>\n"
                . "<th scope= \"col\">Date of Birth</th>\n"
                . "<th scope= \"col\">Gender</th>\n"
                . "<th scope= \"col\">Street Address</th>\n"
                . "<th scope= \"col\">Suburb/Town</th>\n"
                . "<th scope= \"col\">State</th>\n"
                . "<th scope= \"col\">Postcode</th>\n"
                . "<th scope= \"col\">Email Address</th>\n"
                . "<th scope= \"col\">Phone Number</th>\n"
                . "<th scope= \"col\">Skill 1</th>\n"
                . "<th scope= \"col\">Skill 2</th>\n"
                . "<th scope= \"col\">Skill 3</th>\n"
                . "<th scope= \"col\">Skill 4</th>\n"
                . "<th scope= \"col\">Skill 5</th>\n"
                . "<th scope= \"col\">Skill 6</th>\n"
                . "<th scope= \"col\">Other Skill</th>\n"
                . "</tr>\n";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>\n ";
                echo "<td>", $row["EOINUM"], "</td>\n ";
                echo "<td>", $row["Status"], "</td>\n ";
                echo "<td>", $row["Job_Reference_Number"], "</td>\n ";
                echo "<td>", $row["First Name"], "</td>\n ";
                echo "<td>", $row["Last Name"], "</td>\n ";
                echo "<td>", $row["DOB"], "</td>\n ";
                echo "<td>", $row["Gender"], "</td>\n ";
                echo "<td>", $row["Street address"], "</td>\n ";
                echo "<td>", $row["Suburb/town"], "</td>\n ";
                echo "<td>", $row["State"], "</td>\n ";
                echo "<td>", $row["Postcode"], "</td>\n ";
                echo "<td>", $row["Email Address"], "</td>\n ";
                echo "<td>", $row["Phone Number"], "</td>\n ";
                echo "<td>", $row["skill1"], "</td>\n ";
                echo "<td>", $row["skill2"], "</td>\n ";
                echo "<td>", $row["skill3"], "</td>\n ";
                echo "<td>", $row["skill4"], "</td>\n ";
                echo "<td>", $row["skill5"], "</td>\n ";
                echo "<td>", $row["skill6"], "</td>\n ";
                echo "<td>", $row["other_skill"], "</td>\n ";
                echo "</tr>\n ";
            }
            echo "</table>\n ";
            exit;
        } else {
            echo "Found no records";
            exit;
        }
    }
    ?>
</body>

</html>