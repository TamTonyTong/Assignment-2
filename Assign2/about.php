<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("header.inc");?>
  <meta name="author" content="Huỳnh Nguyễn Quốc Bảo">
  <title>About Us</title>
</head>

<body>
  <header>
  <?php $currentPage='about';
  require_once("menu.inc");
  session_start();
  require_once('user_check.php');
  ?>
  <div class="banner">
  <h1 id="applyh1">About Us</h1>
    </div>
</header>
    </div>
  </header>
  <!--Introduction-->
  <div class="about-section">
    <div class="inner-container">
      <h1>About Us</h1>
      <p class="text">
        We are a passionate group of Computer Science students dedicated to making the world a
        more sustainable place. Founded in 2024 with the belief that innovative technology can solve real-world
        problems, we develop software solutions for homes and businesses. We believe in transparency, collaboration, and
        exceeding expectations, and we're always looking for ways to improve our products and services.
        We invite you to learn more about our mission and join us in creating a brighter future!
      </p>
      <section class="course-info">
        <h2>Course Information</h2>
        <dl>
          <dt>Name:</dt>
          <dd>PHP Suffer</dd>
          <dt>Group ID:</dt>
          <dd>SOS04</dd>
          <dt>Tutor's Name</dt>
          <dd>Eric Le</dd>
          <dt>Group Email:</dt>
          <dd><a href="mailto:tonytutam@gmail.com">tonytutam@gmail.com</a></dd>
        </dl>
        <figure class="profile">
          <img src="images/profile.png" alt="Your Profile Picture">
        </figure>

      </section>

    </div>
  </div>
  <!--COURSE INFORMATION-->
  <div class="table-style">
  <h2>Time Table</h2>
  <table>
    <thead>
      <tr>
        <th>Days in Week/Times</th>
        <td class="table-align-center">Monday</td>
        <td class="table-align-center">Tuesday</td>
        <td class="table-align-center">Wednesday</td>
        <td class="table-align-center">Thursday</td>
        <td class="table-align-center">Friday</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>9:00 AM - 10:00 AM</td>
        <td colspan="5" class="table-align-center">Team meeting</td>
      </tr>
      <tr>
        <td>10:00 AM - 12:00 PM</td>
        <td colspan="5" class="table-align-center">Individual work time</td>
      </tr>
      <tr>
        <td>12:00 PM - 1:00 PM</td>
        <td colspan="5" class="table-align-center">Lunch break</td>
      </tr>
      <tr>
        <td>1:00 PM - 3:00 PM:</td>
        <td colspan="5" class="table-align-center">Individual work time</td>
      </tr>
      <tr>
        <td>3:00 PM - 4:00 PM</td>
        <td colspan="5" class="table-align-center">Collaborative task</td>
      </tr>
    </tbody>
  </table>
</div>
  <!--Team-->
  <div class="team-container">
    <!--Header-->
    <div class="team-header">
      <h1>Our Team</h1>
    </div>
    <div class="sub-container">
      <!--Team Image-->
      <div class="teams">
        <img src="images/Bao.jpg" alt="Huynh Nguyen Quoc Bao">
        <!--team member info-->
        <div class="name">Huynh Nguyen Quoc Bao</div>
        <div class="position">Team Leader</div>
        <div class="profile-socials">
          <a href="https://www.facebook.com/KallenKaslana213/"><span class="fa-brands fa-square-facebook"></span></a>
          <a href="https://twitter.com/Travis_Derp"><span class="fa-brands fa-square-twitter"></span></a>
          <a href="https://www.linkedin.com/in/huynh-nguyen-quoc-bao-6b7ab6236/"><span
              class="fa-brands fa-linkedin"></span></a>
          <a href="https://github.com/Travis-Houston"><span class="fa-brands fa-github"></span></a>
        </div>
      </div>

      <!--Team Image-->
      <div class="teams">
        <img src="images/Chi-Lon-Thon.png" alt="Le Hoang Triet Thong photo">
        <!--team member info-->
        <div class="name">Le Hoang Triet Thong</div>
        <div class="position">Team Members</div>
        <div class="profile-socials">
          <a href="https://www.facebook.com/chilonthon/"><span class="fa-brands fa-square-facebook"></span></a>
          <a href="https://www.linkedin.com/in/thong-le-5b26b6185/"><span class="fa-brands fa-linkedin"></span></a>
          <a href="https://github.com/AlecVOV"><span class="fa-brands fa-github"></span></a>
        </div>
      </div>

      <!--Team Image-->
      <div class="teams">
        <img id="tamtong" src="images/Tam-Tong.png" alt="Tong Duc Tu Tam photo">
        <!--team member info-->
        <div class="name">Tong Duc Tu Tam</div>
        <div class="position">Team Members</div>
        <div class="profile-socials">
          <a href="https://www.facebook.com/tongss.tamss.7/"><span class="fa-brands fa-square-facebook"></span></a>
          <a href="https://www.linkedin.com/in/tong-duc-tu-tam-989825196/"><span
              class="fa-brands fa-linkedin"></span></a>
          <a href="https://github.com/TamTonyTong"><span class="fa-brands fa-github"></span></a>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("footer.inc");?>
</body>

</html>