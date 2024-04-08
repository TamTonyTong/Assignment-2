<nav>
  <a href="#home" class="logo"><img src="images/Logo.png" alt="logo" class="logo"></a>
  <input type="checkbox" id="dropdown-btn">
  <label for="dropdown-btn">
    <span class="fa-solid fa-bars"></span>
  </label>
  <ul id="nav_bar">
      <li><a href="index.php" <?php if ($currentPage === 'index') echo 'class="active"' ?>>Home</a></li>
      <li><a href="about.php" <?php if ($currentPage === 'about') echo 'class="active"' ?>>About Us</a></li>
      <li><a href="enhancements.php" <?php if ($currentPage === 'enhancements') echo 'class="active"' ?>>Enhancements</a></li>
      <li><a href="https://youtu.be/GrEiv9SRdNg">Group Video</a></li>
      <li><a href="jobs.php" <?php if ($currentPage === 'jobs') echo 'class="active"' ?>>Job Descriptions</a></li>
      <li><a href="application_searching.php" <?php if ($currentPage === 'application_searching') echo 'class="active"' ?>>Search Application</a></li>
      