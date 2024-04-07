<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('header.inc');
    session_start();

    ?>
    <meta name="author" content="Tống Đức Từ Tâm">
    <link rel="stylesheet" href="styles/style.css">
    <title>Form Checking</title>
</head>

<body>

    <div class=error-container>
        <?php
        require_once("config.php");
        function sanitise_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        // RETURN TO APPLY IF USER HASN'T ENTER FORM
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['Apply'])) {
                $errors = [];
                $job_ref_num = sanitise_input($_POST['job_ref_num']);
                $first_name = sanitise_input($_POST['first_name']);
                $last_name = sanitise_input($_POST['last_name']);
                $date_of_birth = sanitise_input($_POST['date_of_birth']);
                $gender = sanitise_input($_POST['gender']);
                $street_address = sanitise_input($_POST['street_address']);
                $suburb_town = sanitise_input($_POST['suburb_town']);
                $state = sanitise_input($_POST['state']);
                $postcode = sanitise_input($_POST['postcode']);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $phone_num = sanitise_input($_POST['phone_num']);
                $skill1 = isset($_POST["skill1"]) ? mysqli_real_escape_string($conn, trim($_POST["skill1"])) : "";
                $skill2 = isset($_POST["skill2"]) ? mysqli_real_escape_string($conn, trim($_POST["skill2"])) : "";
                $skill3 = isset($_POST["skill3"]) ? mysqli_real_escape_string($conn, trim($_POST["skill3"])) : "";
                $skill4 = isset($_POST["skill4"]) ? mysqli_real_escape_string($conn, trim($_POST["skill4"])) : "";
                $skill5 = isset($_POST["skill5"]) ? mysqli_real_escape_string($conn, trim($_POST["skill5"])) : "";
                $skill6 = isset($_POST["skill6"]) ? mysqli_real_escape_string($conn, trim($_POST["skill6"])) : "";
                $other_skill = isset($_POST["other_skill"]) ? mysqli_real_escape_string($conn, trim($_POST["other_skill"])) : "";

                // Define the valid postcode ranges for each state
                $state_postcode_ranges = array(
                    'VIC' => array('3000', '3999', '8000', '8999'),
                    'NSW' => array('2000', '2999', '1000', '1999'),
                    'QLD' => array('4000', '4999', '9000', '9999'),
                    'NT'  => array('0800', '0899', '0900', '0999'),
                    'WA'  => array('6000', '6999', '6800', '6999'),
                    'SA'  => array('5000', '5999', '5800', '5999'),
                    'TAS' => array('7000', '7999', '7800', '7900'),
                    'ACT' => array('0200', '0299', '2600', '2618', '2900', '2920'),
                );
                //var_dump($_POST);
                if (empty($job_ref_num)) {
                    $job_ref_num = "";
                    $errors[] = "<p>Job reference number is required.</p>\n";
                } else {
                    if (!preg_match("/^[a-zA-Z0-9]{5}$/", $job_ref_num)) {
                        $errors[] = "<p>Job reference number must be exactly 5 alphanumeric characters.</p>\n";
                    }
                }
                if (empty($first_name)) {
                    $first_name = "";
                    $errors[] = "<p>First name is required.</p>\n";
                } else {
                    if (!preg_match("/^[a-zA-Z0-9]{1,20}$/", $first_name)) {
                        $errors[] = "<p>First name must be maximum 20 alphanumeric characters.</p>\n";
                    }
                }
                if (empty($last_name)) {
                    $last_name = "";
                    $errors[] = "<p>Last name is required.</p>\n";
                } else {
                    if (!preg_match("/^[a-zA-Z0-9]{1,20}$/", $last_name)) {
                        $errors[] = "<p>Last name must be maximum 20 alphanumeric characters.</p>\n";
                    }
                }
                if (empty($date_of_birth)) {
                    $date_of_birth = "";
                    $errors[] = "<p>Date of Birth is required.</p>\n";
                } else {
                    $dob = new DateTime($date_of_birth);
                    $today = new DateTime();
                    $age = $today->diff($dob)->y;
                    if ($age > 80 || $age < 15) {
                        $errors[] = "<p>Age must be between 15 and 80.</p>\n";
                    }
                }
                if (empty($gender)) {
                    $gender = "";
                    $errors[] = "<p>Gender is required.</p>\n";
                }
                if (empty($street_address)) {
                    $street_address = "";
                    $errors[] = "<p>Street Address is required.</p>\n";
                } else {
                    if (strlen($street_address) > 40) {
                        $errors[] = "<p>Street Address must be maximum 40 characters.</p>\n";
                    }
                }
                if (empty($suburb_town)) {
                    $suburb_town = "";
                    $errors[] = "<p>Suburb/Town is required.</p>\n";
                } else {
                    if (!preg_match("/^[a-zA-Z0-9\s\.,'-]{1,40}$/", $suburb_town)) {
                        $errors[] = "<p>Suburb/Town must be maximum 40 characters.</p>\n";
                    }
                }
                // Validate state
                if (empty($state)) {
                    $state = "";
                    $errors[] = "<p>State selection is required.</p>\n";
                } else {
                    if (!array_key_exists($state, $state_postcode_ranges)) {
                        $errors[] = "<p>Invalid state selected.</p>\n";
                    }
                }
                // Validate postcode
                if (empty($_POST['postcode'])) {
                    $postcode = "";
                    $errors[] = "<p>Postcode is required.</p>\n";
                } else {
                    if (!preg_match("/^\d{4}$/", $postcode)) {
                        $errors[] = "<p>Postcode must consist of exactly 4 digits.</p>\n";
                    } elseif (!in_array($postcode, range($state_postcode_ranges[$state][0], $state_postcode_ranges[$state][1]))) {
                        $errors[] = "<p>Invalid postcode for the selected state.</p>\n";
                    }
                }
                if (empty($email)) {
                    $email = "";
                    $errors[] = "<p>Email is required</p>\n";
                } else {
                    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
                        $errors[] = "<p>Invalid email address</p>\n";
                    }
                }
                if (empty($phone_num)) {
                    $phone_num = " ";
                    $errors[] = "<p>Phone number is required</p>\n";
                } else {
                    if (!preg_match('/^[0-9\s]{8,12}$/', $phone_num)) {
                        $errors[] = "<p>Phone number is not valid</p>\n";
                    }
                }
                if (empty($skill1) && empty($skill2) && empty($skill3) && empty($skill4) && empty($skill5) && empty($skill6)) {
                    $errors[] = "<p>One of the skills must be selected</p>\n";
                }
                if (!empty($skill6)) {
                    if (!empty($other_skill)) {
                    } else {
                        $errors[] = "<p>The text area must not be empty</p>\n";
                    }
                } else {
                    if (!empty($other_skill)) {
                        $errors[] = "<p>You must select the other skill box</p>\n";
                    }
                }
                $_SESSION['job_ref_num'] = $job_ref_num;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['date_of_birth'] = $date_of_birth;
                $_SESSION['gender'] = $gender;
                $_SESSION['street_address'] = $street_address;
                $_SESSION['suburb_town'] = $suburb_town;
                $_SESSION['state'] = $state;
                $_SESSION['postcode'] = $postcode;
                $_SESSION['email'] = $email;
                $_SESSION['phone_num'] = $phone_num;
                $_SESSION['skill1'] = $skill1;
                $_SESSION['skill2'] = $skill2;
                $_SESSION['skill3'] = $skill3;
                $_SESSION['skill4'] = $skill4;
                $_SESSION['skill5'] = $skill5;
                $_SESSION['skill6'] = $skill6;
                $_SESSION['other_skill'] = $other_skill;
                // CREATE TABLE IF NOT
                // Check if the EOI table exists
                $checking_query = "SHOW TABLES LIKE 'EOI'";
                $result = mysqli_query($conn, $checking_query);
                if (mysqli_num_rows($result) == 0) {
                    $create_table_query = "CREATE TABLE EOI (
                    EOINUM VARCHAR(36) COLLATE latin1_swedish_ci PRIMARY KEY,
                    Status ENUM('New', 'Current', 'Final') COLLATE latin1_swedish_ci DEFAULT 'New',
                    Job_Reference_Number VARCHAR(5) COLLATE latin1_swedish_ci,
                    `First Name` VARCHAR(20) COLLATE latin1_swedish_ci,
                    `Last Name` VARCHAR(20) COLLATE latin1_swedish_ci,
                    `DOB` VARCHAR(10) COLLATE latin1_swedish_ci,
                    `Gender` VARCHAR(10) COLLATE latin1_swedish_ci,
                    `Street address` VARCHAR(20) COLLATE latin1_swedish_ci,
                    `Suburb/town` VARCHAR(20) COLLATE latin1_swedish_ci,
                    `State` VARCHAR(20) COLLATE latin1_swedish_ci,
                    `Postcode` INT(4) COLLATE latin1_swedish_ci,
                    `Email Address` VARCHAR(60) COLLATE latin1_swedish_ci,
                    `Phone Number` INT(15) COLLATE latin1_swedish_ci,
                    `skill1` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `skill2` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `skill3` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `skill4` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `skill5` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `skill6` VARCHAR(36) COLLATE latin1_swedish_ci,
                    `other_skill` VARCHAR(40) COLLATE latin1_swedish_ci
                    )";
                    mysqli_query($conn, $create_table_query);
                }
                if (empty($errors)) {
                    var_dump($_POST);
                    // Check if the data already exists
                    $check_query = "SELECT COUNT(*) AS total FROM EOI WHERE `Job_Reference_Number` = ? AND `First Name` = ? AND `Last Name` = ? AND `DOB` = ? AND `Gender` = ? AND `Street address` = ? AND `Suburb/town` = ? AND `State` = ? AND `Postcode` = ? AND `Email Address` = ? AND `Phone Number` = ? AND `skill1` = ? AND `skill2` = ? AND `skill3` = ? AND `skill4` = ? AND `skill5` = ? AND `skill6` = ? AND `other_skill` = ?";
                    $stmt = mysqli_prepare($conn, $check_query);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "ssssssssssssssssss",
                        $job_ref_num,
                        $first_name,
                        $last_name,
                        $date_of_birth,
                        $gender,
                        $street_address,
                        $suburb_town,
                        $state,
                        $postcode,
                        $email,
                        $phone_num,
                        $skill1,
                        $skill2,
                        $skill3,
                        $skill4,
                        $skill5,
                        $skill6,
                        $other_skill
                    );
                    mysqli_stmt_execute($stmt);
                    $check_result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($check_result);
                    $total_records = $row['total'];

                    if ($total_records > 0) {
                        // Data already exists, handle accordingly (e.g., show error message)
                        $_SESSION['status'] = "error";
                        $errors[] = "Data already exists in the table.";
                        $_SESSION['errors'] = $errors;
                        header("Location: apply.php?result=validation_error");
                        die();
                    } else {
                        // INSERT DATA TO TABLE
                        $insert_query = "INSERT INTO `EOI` (`Job_Reference_Number`, `First Name`, `Last Name`, `DOB`, `Gender`, `Street address`, `Suburb/town`, `State`, `Postcode`, `Email Address`, `Phone Number`, `skill1`, `skill2`, `skill3`, `skill4`, `skill5`, `skill6`, `other_skill`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $insert_query);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "ssssssssssssssssss",  $job_ref_num, $first_name, $last_name, $date_of_birth, $gender, $street_address, $suburb_town, $state, $postcode, $email, $phone_num, $skill1, $skill2, $skill3, $skill4, $skill5, $skill6, $other_skill);
                            mysqli_stmt_execute($stmt);
                        }
                        // Update EOINUM
                        $update_query = "UPDATE EOI SET EOINUM = UUID() WHERE 1";
                        mysqli_query($conn, $update_query);

                        // Fetch the last inserted EOInumber
                        $last_insert_id_query = "SELECT EOINUM FROM EOI";
                        $stmt_last_insert = mysqli_prepare($conn, $last_insert_id_query);
                        mysqli_stmt_execute($stmt_last_insert);
                        $result = mysqli_stmt_get_result($stmt_last_insert);
                        $row = mysqli_fetch_assoc($result);
                        $eoi_number = $row['EOINUM'];

                        $data = [
                            'eoi_num' => $eoi_number
                        ];
                        $_SESSION["status"] = "success";
                        $_SESSION["data"] = $data;
                        header("Location: apply.php?result=success");
                        die();
                    }
                } else {
                    // Handle validation errors
                    $_SESSION['status'] = "error";
                    $_SESSION['errors'] = $errors;
                    header("Location: apply.php?result=validation_error");
                    die();
                }
            } else if (isset($_POST['Reset'])) {
                unset($_SESSION['job_ref_num']);
                unset($_SESSION['first_name']);
                unset($_SESSION['last_name']);
                unset($_SESSION['date_of_birth']);
                unset($_SESSION['gender']);
                unset($_SESSION['street_address']);
                unset($_SESSION['suburb_town']);
                unset($_SESSION['state']);
                unset($_SESSION['postcode']);
                unset($_SESSION['email']);
                unset($_SESSION['phone_num']);
                unset($_SESSION['skill1']);
                unset($_SESSION['skill2']);
                unset($_SESSION['skill3']);
                unset($_SESSION['skill4']);
                unset($_SESSION['skill5']);
                unset($_SESSION['skill6']);
                unset($_SESSION['other_skill']);
                header("location: apply.php");
            }
        }
        mysqli_close($conn); ?>
    </div>