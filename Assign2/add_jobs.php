<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>" type="text/css" />

<head>
    <?php include("header.inc"); ?>
    <title>Add Jobs</title>
</head>

<body class="add-job-page">
    <header id="add-job-header">
        <?php $currentPage = 'index';
        require_once("menu.inc");
        session_start();
        include('user_check.php');

        $privileges = $_SESSION['privileges'];
        $user_id = $_SESSION['userId'];

        //Privilege check
        if ($privileges !== "admin") {
            header('location: index.php');
        }
        ?>
        <div class="banner">
            <h1 id="applyh1">Adding Job Descriptions</h1>
        </div>
    </header>

    <?php
    require_once("config.php");
    mysqli_report(MYSQLI_REPORT_OFF); // Turn off default messages

    // Function to sanitize input data
    function sanitize($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['reference'] = $_POST['reference'];
            $_SESSION['description'] = $_POST['description'];
            $_SESSION['salary'] = $_POST['salary'];
            $_SESSION['reporting_to'] = $_POST['reporting_to'];
            $_SESSION['responsibilities'] = $_POST['responsibilities'];
            $_SESSION['qualifications'] = $_POST['qualifications'];
            $_SESSION['open_positions'] = $_POST['open_positions'];
            // Validate form fields
            $errors = array();

            // Check if required fields are filled
            if (empty($_POST['title'])) {
                $errors[] = "<p>Title is required.</p>";
            }
            if (empty($_POST['reference'])) {
                $errors[] = "<p>Reference is required.</p>";
            }
            if (empty($_POST['description'])) {
                $errors[] = "<p>Description is required.</p>";
            }
            if (empty($_POST['salary'])) {
                $errors[] = "<p>Salary is required.</p>";
            }
            if (empty($_POST['reporting_to'])) {
                $errors[] = "<p>Reporting To is required.</p>";
            }
            if (empty($_POST['responsibilities'])) {
                $errors[] = "<p>Responsibilities is required.</p>";
            }
            if (empty($_POST['qualifications'])) {
                $errors[] = "<p>Qualifications is required.</p>";
            }
            if (empty($_POST['open_positions'])) {
                $errors[] = "<p>Open Positions is required.</p>";
            }

            if (empty($errors)) {
                // Sanitize form data
                $title = sanitize($_POST['title']);
                $reference = sanitize($_POST['reference']);
                $description = sanitize($_POST['description']);
                $salary = sanitize($_POST['salary']);
                $reporting_to = sanitize($_POST['reporting_to']);
                $responsibilities = sanitize(str_replace("\r\n", "\n", $_POST['responsibilities']));
                $qualifications = sanitize(str_replace("\r\n", "\n", $_POST['qualifications']));
                $open_positions = sanitize($_POST['open_positions']);

                // Prepare SQL statement
                $sql = "INSERT INTO jobs (title, reference, description, salary, reporting_to, responsibilities, qualifications, open_positions) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare and bind parameters
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssi", $title, $reference, $description, $salary, $reporting_to, $responsibilities, $qualifications, $open_positions);

                // Execute SQL statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "<p class = 'successful'>Job added successfully.</p>";

                    // Clear form data stored in session
                    unset($_SESSION['title']);
                    unset($_SESSION['reference']);
                    unset($_SESSION['description']);
                    unset($_SESSION['salary']);
                    unset($_SESSION['reporting_to']);
                    unset($_SESSION['responsibilities']);
                    unset($_SESSION['qualifications']);
                    unset($_SESSION['open_positions']);

                    // Redirect to the same page to clear POST data
                    header("Location: add_jobs.php" . $_SERVER['PHP_SELF']);
                } else {
                    echo "Error: " . mysqli_error($conn);
                    header("Location: add_jobs.php" . $_SERVER['PHP_SELF']);
                    exit;
                }

                // Close statement and connection
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else {
                // Display error messages
                echo '<div class="error-container">';
                echo '<h1>Errors:</h1>';
                foreach ($errors as $error) {
                    echo $error;
                }
                echo '</div>';
            }
        }
    
    ?>

    <div id="add-job-container" class="add-job-container">
        <h1 class="add-job-title">Position Form</h1>
        <form class="add-job-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Position Title:</label>
            <input type="text" name="title" value="<?php if (isset($_SESSION['title'])) echo $_SESSION['title']; ?>"><br><br>

            <label for="reference">Company Position Reference:</label>
            <input type="text" name="reference" value="<?php if (isset($_SESSION['reference'])) echo $_SESSION['reference']; ?>"><br><br>

            <label for="description">Description:</label>
            <textarea name="description"><?php if (isset($_SESSION['description'])) echo $_SESSION['description']; ?></textarea><br><br>

            <label for="salary">Salary:</label>
            <input type="number" name="salary" value="<?php if (isset($_SESSION['salary'])) echo $_SESSION['salary']; ?>"><br><br>

            <label for="reporting_to">Reporting To:</label>
            <input type="text" name="reporting_to" value="<?php if (isset($_SESSION['reporting_to'])) echo $_SESSION['reporting_to']; ?>"><br><br>

            <label for="responsibilities">Responsibilities:</label>
            <textarea name="responsibilities"><?php if (isset($_SESSION['responsibilities'])) echo $_SESSION['responsibilities']; ?></textarea><br><br>

            <label for="qualifications">Qualifications:</label>
            <textarea name="qualifications"><?php if (isset($_SESSION['qualifications'])) echo $_SESSION['qualifications']; ?></textarea><br><br>

            <label for="open_positions">Open Positions:</label>
            <input type="number" name="open_positions" value="<?php if (isset($_SESSION['open_positions'])) echo $_SESSION['open_positions']; ?>"><br><br>

            <input type="submit" value="Add Job">
            <br>
        </form>
    </div>

    <?php include("footer.inc"); ?>
</body>

</html>