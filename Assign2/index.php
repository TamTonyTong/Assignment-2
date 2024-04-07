<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("header.inc"); ?>
  <title>Home Page</title>
</head>

<body>
  <header>
    <?php $currentPage = 'index';
    require_once("menu.inc");
    session_start();
    require_once('user_check.php');
    ?>
    <div class="banner">
      <div class="statitics">
        <h1>The Easiest Way To Get Your Job</h1>
        <ul id="statistics_bar">
          <li>
            <div id="countdown1"></div>
            <hr><span class="material-symbols-outlined"> globe </span>Countries
          </li>
          <li>
            <div id="countdown2"></div>
            <hr><span class="material-symbols-outlined">apartment</span> Companies
          </li>
          <li>
            <div id="countdown3"></div>
            <hr><span class="material-symbols-outlined"> person_apron </span>Active Employees
          </li>
          <li>
            <div id="countdown4"></div>
            <hr><span class="material-symbols-outlined">location_away </span>Clients
          </li>
        </ul>
      </div>
    </div>
  </header>
  <div id="big_box">
    <div class="section-head">
      <h2>Why Choose Us?</h2>
      <p>We take the time to understand your specific skills, your ambitions, and the work culture that lights you up. We don't just fill positions, we change lives. When you land the perfect job, we celebrate alongside you. We're here every step of the way with resume refinement, interview prep, and inside insights that give you the competitive edge.</p>
    </div>

    <div>
      <div class="item"> <span class="icon feature_box_col_one"><i class="fa-solid fa-person"></i></span>
        <h2>Focused on the Individual</h2>
        <p>Other agencies treat you like a number. We take the time to understand your specific skills, your ambitions, and the work culture that lights you up. We don't just fill positions, we change lives. When you land the perfect job, we celebrate alongside you. The job hunt can be daunting. We're here every step of the way with resume refinement, interview prep, and inside insights that give you the competitive edge.</p>
      </div>

      <div class="item"> <span class="icon feature_box_col_two"><i class="fa-solid fa-handshake-simple"></i></span>
        <h2>Emphasis on Results</h2>
        <p>Our vast network and industry expertise mean you get connected to top opportunities you wouldn't find on your own. We don't just talk the talk; our numbers speak for themselves. We don't just follow job trends, we understand them. This keeps you ahead of the curve and in front of the right hiring managers.</p>
      </div>

      <div class="item"> <span class="icon feature_box_col_three"><i class="fa-solid fa-people-arrows"></i></span>
        <h2>Friendly and Human Approach</h2>
        <p>Because the job search shouldn't be soul-sucking. Let's be honest, it can be stressful. We inject some fun and optimism back into the process. No robots here! You'll work with real people who understand the local market and genuinely care about your future. We're your job-hunting cheerleaders. When you need a pep talk, or help translating "corporate speak", we've got your back.</p>
      </div>

      <div class="item"> <span class="icon feature_box_col_four"><i class="fa fa-database"></i></span>
        <h2>Tech-Savvy and Cutting Edge</h2>
        <p>Our proprietary matching technology goes beyond job boards, getting your resume in front of the right people, not just the ones with the right keywords. Insider connections made easy. We leverage data and social networks to unearth hidden opportunities and put you in direct contact with decision-makers. Your career in the fast lane. Our streamlined process is designed for a digital world, getting you from application to offer with unprecedented speed.</p>
      </div>

      <div class="item"> <span class="icon feature_box_col_five"><i class="fa-solid fa-magnifying-glass-chart"></i></span>
        <h2>Focus on the Benefit</h2>
        <p>We specialize in finding the perfect job for you -- the one that matches your unique skills and ambitions. Whether you're in tech, the creative fields, healthcare, or beyond, our deep industry expertise means targeted placements and faster results. No more sifting through endless irrelevant job listings. Join our community of professionals for insider access, support, and knowledge-sharing that accelerates your career growth.</p>
      </div>

      <div class="item"> <span class="icon feature_box_col_six"><i class="fa-solid fa-business-time"></i></span>
        <h2>Values-Driven</h2>
        <p>More than a salary match. We find companies whose values and culture align with yours, because a true fit leads to long-term career satisfaction. Advocate for your worth. We're fiercely in your corner, negotiating not just compensation, but the benefits and flexibility that truly matter to you. Changing the industry, one placement at a time. We work with socially-conscious businesses and support candidates from diverse backgrounds to build a more equitable workforce.</p>
      </div>
    </div>
  </div>
  <?php require_once("footer.inc"); ?>
</body>

</html>