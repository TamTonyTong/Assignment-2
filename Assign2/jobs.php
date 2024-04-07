<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("header.inc"); ?>
  <meta name="author" content="Huỳnh Nguyễn Quốc Bảo">
  <title>Job Vacancy</title>
</head>

<body>
  <header>
    <?php
    // Set the current page
    $currentPage = 'jobs';
    // Include the menu
    require_once('menu.inc');
    // Start the session
    session_start();
    // Check if the user is logged in
    require_once('user_check.php');
    ?>
    <div class="banner">
      <h1 id="applyh1">Job Descriptions</h1>
    </div>
  </header>
  <?php
  // Database connection
  require_once('config.php');

  // Check database connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // SQL query to fetch all jobs
  $sql = "SELECT * FROM jobs";
  $result = $conn->query($sql);

  $jobs = [];
  if ($result->num_rows > 0) {
    // Fetch data of each row into an array
    while ($row = $result->fetch_assoc()) {
      // Split responsibilities and qualifications into arrays
      $row['responsibilities'] = explode("\n", $row['responsibilities']);
      $row['qualifications'] = explode("\n", $row['qualifications']);
      $jobs[] = $row;
    }
  } else {
    $jobs = null;
  }

  $conn->close();
  ?>
  <!-- Job list -->
  <div class="jobs-list-container">
    <h2><?php echo count($jobs); ?> Jobs</h2>
    <?php if ($jobs): ?>
      <?php foreach ($jobs as $job): ?>
        <div class="jobs-container">
          <div class="job">
            <img src="images/Logo-black.png" alt="images" class="logo-black">
            <h3 class="job-title"><?= $job["title"] ?></h3>
            <section class="details">
              <h4>Position Details</h4>
              <ol>
                <li><span class="bolding">Company Position Reference:</span> <?= $job["reference"] ?></li>
                <li><span class="bolding">Position Title:</span> <?= $job["title"] ?></li>
                <li><span class="bolding">Brief Description:</span> <?= $job["description"] ?></li>
                <li><span class="bolding">Salary Range:</span> <?= $job["salary"] ?></li>
                <li><span class="bolding">Reporting To:</span> <?= $job["reporting_to"] ?></li>
              </ol>
              <h4>Key Responsibilities</h4>
              <ul>
                <?php foreach ($job["responsibilities"] as $responsibility): ?>
                  <li><?= $responsibility ?></li>
                <?php endforeach; ?>
              </ul>
              <h4>Required Qualifications</h4>
              <ul>
                <li class="bolding-first-line">Required:</li>
                <?php foreach ($job["qualifications"] as $qualification): ?>
                  <li><?= $qualification ?></li>
                <?php endforeach; ?>
              </ul>
            </section>
            <aside>
              <p><strong><em>*Salary depends on experience*</em></strong></p>
            </aside>
            <span class="open-postion"><strong><?= $job["open_positions"] ?> open positions</strong></span>
            <a href="apply.php" class="Apply-btn"><strong>Apply</strong></a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No jobs found</p>
    <?php endif; ?>
  </div>
  <?php require_once("footer.inc"); ?>
</body>

</html>
