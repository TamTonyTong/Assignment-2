<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("header.inc") ?>
  <meta name="author" content="Tống Đức Từ Tâm">
  <title>Enhancements</title>
</head>

<body>
  <header>
    <?php $currentPage = 'enhancements';
    require_once("menu.inc");
    session_start();
    require_once('user_check.php');
     ?>
    <div class="banner">
      <h1 id="applyh1">Enhancements</h1>
    </div>
  </header>
  <div class="enhancements">
    <h2>List of Enhancements:<span class="h-enhancement-bolding"><span></span></span> </h2>
    <ul class="enhancements-list">
      <li>
        <h3>Enhanced Navigation:</h3>
        <p>The navigation bar utilizes a dynamic effect, highlighting the relevant web page tab by focusing it when the user navigates to that section.</p>
        <img src="images/1st-enhancement.png" id="first-enhancement-pic" alt="1st-enhancement">
      </li>
      <li>
        <h3>Interactive Index Page:</h3>
        <p>The index page features an animated number display that automatically changes each time you enter the page, adding a touch of dynamism.</p>
        <img src="images/2nd-enhancement.png" id="second-enhancement-pic" alt="2nd-enhancement">
      </li>
      <li>
        <h3>Engaging Job Descriptions:</h3>
        <p>In the job description page, a hover effect brings the text box to life, scaling it up for better focus. Additionally, hovering over the apply button changes its color, creating a clear call to action.</p>
        <img src="images/3rd-enhancement.png" id="third-enhancement-pic" alt="3rd-enhancement">
      </li>
      <li>
        <h3>Smooth Footer Animation:</h3>
        <p>The footer section boasts three moving bars that animate continuously and smoothly, offering subtle visual interest.</p>
        <img src="images/4th-enhancement.png" id="fourth-enhancement-pic" alt="4th-enhancement">
      </li>
      <li>
        <h3>Interactive About Us Page:</h3>
        <p>The icons on the About Us page are interactive, scaling up slightly when you hover over them, inviting exploration.</p>
        <img src="images/5th-enhacement.png" id="fifth-enhancement-pic" alt="5th-enhacement">
      </li>
    </ul>
  </div>

  <?php require_once("footer.inc"); ?>

</body>

</html>