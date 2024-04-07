<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>" type="text/css" />

<head>
  <?php include("header.inc"); ?>
  <title>Home Page</title>
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
        function sanitize($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate form fields
            $errors = array();
            
            // Check if required fields are filled
            if (empty($_POST['title'])) {
                $errors[] = "Title is required.";
            }
            if (empty($_POST['reference'])) {
                $errors[] = "Reference is required.";
            }
            if (empty($_POST['description'])) {
                $errors[] = "Description is required.";
            }
            if (empty($_POST['salary'])) {
                $errors[] = "Salary is required.";
            }
            if (empty($_POST['reporting_to'])) {
                $errors[] = "Reporting To is required.";
            }
            if (empty($_POST['responsibilities'])) {
                $errors[] = "Responsibilities is required.";
            }
            if (empty($_POST['qualifications'])) {
                $errors[] = "Qualifications is required.";
            }
            if (empty($_POST['open_positions'])) {
                $errors[] = "Open Positions is required.";
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
                        VALUES ('$title', '$reference', '$description', '$salary', '$reporting_to', '$responsibilities', '$qualifications', '$open_positions')";
                
                // Execute SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "Job added successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                
                // Close database connection
                mysqli_close($conn);
            } else {
                // Display error messages
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            }
        }
        ?>

    <div id="add-job-container" class="add-job-container">
        <h1 class="add-job-title">Position Form</h1>
        <form class="add-job-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Position Title:</label>
            <input type="text" name="title" ><br><br>

            <label for="reference">Company Position Reference:</label>
            <input type="text" name="reference" ><br><br>

            <label for="description">Description:</label>
            <textarea name="description" ></textarea><br><br>

            <label for="salary">Salary:</label>
            <input type="number" name="salary" ><br><br>

            <label for="reporting_to">Reporting To:</label>
            <input type="text" name="reporting_to"><br><br>

            <label for="responsibilities">Responsibilities:</label>
            <textarea name="responsibilities"></textarea><br><br>

            <label for="qualifications">Qualifications:</label>
            <textarea name="qualifications" ></textarea><br><br>

            <label for="open_positions">Open Positions:</label>
            <input type="number" name="open_positions" ><br><br>

            <input type="submit" value="Add Job">
        </form>
    </div>
  
  <?php include("footer.inc"); ?>
</body>

</html>
