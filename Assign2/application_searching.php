<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("header.inc");?>
  <meta name="author" content="Tống Đức Từ Tâm">
  <title>Job Application</title>
</head>

<body>
  <header>
    <?php $currentPage = 'application_searching';
    require_once('menu.inc');
    session_start();
    require_once('user_check.php');
    ?>
    <div class="banner">
      <h1 id="applyh1">Application Searching Form</h1>
    </div>

    <div class="job-applying-container">

      <div class="applying-basic-info">
        <h2>Enter EOI number to see your Application</h2>
        <hr>
        <form method="post" action="application_searching.php" novalidate="novalidate">
          <label for="EOINUM"> EOI Number</label>
          <input type="text" name="EOINUM">
          <input type="submit" value="Search" id="apply">
        </form>
      </div>
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
      $EOINUM = sanitise_input($_POST['EOINUM']);
      $search_query = "SELECT * FROM `EOI` WHERE `EOINUM` = ?";
      $stmt = mysqli_prepare($conn,$search_query);
      if ($stmt){
        mysqli_stmt_bind_param($stmt, "s", $EOINUM);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
      }
      if ($result and mysqli_num_rows($result) > 0) {
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

  </header>
  <?php require_once("footer.inc"); ?>
</body>
</html>