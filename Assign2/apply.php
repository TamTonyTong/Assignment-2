<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("header.inc");?>
  <meta name="author" content="Tống Đức Từ Tâm">
  <title>Application Form</title>
</head>

<body>
  <header>
  <?php $currentPage='apply';
  require_once("menu.inc");
  session_start();
  require_once('user_check.php');
  ?>
  <div class="banner">
  <h1 id="applyh1">Job Application Form</h1>
    </div>
    
  </header>
  <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'error') : 
      $errors = $_SESSION['errors'];
      ?>

    <div class=error-container>
      <h1>Errors:</h1>
      <?php foreach($errors as $e) :?>
      <?= $e?>
      <?php endforeach;?>
    </div>

    <?php elseif(isset($_SESSION['status']) && $_SESSION['status'] === 'success') :
      $data = $_SESSION['data'];
    ?>
    <div class=successful>
    <h1>Successful</h1>
    <p class=successful>Expression of Interest submitted successfully. Your EOInumber is: <br><?= $data['eoi_num']?></p>
    </div>
    <?php endif; ?>
  <div class="job-applying-container">
    
    <div class="applying-basic-info">
      <h2>Personal Information</h2>
      <hr>
      <form method="post" action="processEOI.php" novalidate="novalidate">
        <p id="asterisk"><em><strong>Required fields</strong></em></p>
        <label for="job_ref_num"> Job Reference Number</label>
        <input type="text" name="job_ref_num" id="job_ref_num" size="20" pattern="[a-zA-Z0-9]{5}"
          placeholder="Please enter exactly 5 aplphanumeric characters - SWS05" value= "<?php if(isset($_SESSION['job_ref_num'])) echo $_SESSION['job_ref_num'];?>">
        <div class="name-container">
          <div>
            <label for="first_name"> First Name</label>
            <input type="text" name="first_name" id="first_name" size="20" pattern="[A-Za-z]{1,20}"
              title="Only maximum of 20 alphabetical characters allowed" value= "<?php if(isset($_SESSION['first_name'])) echo $_SESSION['first_name'];?>">
          </div>

          <div id="last_name_align">
            <label for="last_name" id="last_name1"> Last Name</label>
            <input type="text" name="last_name" id="last_name" size="20" pattern="[A-Za-z]{1,20}"
              title="Only maximum of 20 alphabetical characters allowed" value= "<?php if(isset($_SESSION['last_name'])) echo $_SESSION['last_name'];?>">
          </div>
        </div>

        <label for="date_of_birth"> Date of Birth</label>
        <input type="date" name="date_of_birth" id="date_of_birth" size="20" title="Please Enter your D.O.B" value= "<?php if(isset($_SESSION['date_of_birth'])) echo $_SESSION['date_of_birth'];?>">

        <div class="gender">
          <fieldset>
            <legend>Gender</legend>
            <label class="container">
              <input type="radio" name="gender" value="Men" title="Please choose your gender" <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] === 'Men') echo 'checked'; ?>>Men
              <span class="checkmark"></span>
            </label>
            <label class="container">
              <input type="radio" name="gender" value="Women" <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] === 'Women') echo 'checked'; ?>>Women
              <span class="checkmark"></span>
            </label>
          </fieldset>
        </div>



        <label for="street_address">Street Address</label>
        <input type="text" name="street_address" id="street_address" size="30" maxlength="40" value= "<?php if(isset($_SESSION['street_address'])) echo $_SESSION['street_address'];?>">

        <label for="suburb_town">Suburb Town</label>
        <input type="text" name="suburb_town" id="suburb_town" size="30" maxlength="40" value= "<?php if(isset($_SESSION['suburb_town'])) echo $_SESSION['suburb_town'];?>">


        <label id="statecuztomize" for="state">State</label>

        <select name="state" id="state" >
          <option value="">Please Select</option>
          <option value="VIC" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'VIC') echo 'selected'; ?>>VIC</option>
          <option value="NSW" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'NSW') echo 'selected'; ?>>NSW</option>
          <option value="QLD" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'QLD') echo 'selected'; ?>>QLD</option>
          <option value="NT" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'NT') echo 'selected'; ?>>NT</option>
          <option value="WA" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'WA') echo 'selected'; ?>>WA</option>
          <option value="SA" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'SA') echo 'selected'; ?>>SA</option>
          <option value="TAS" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'TAS') echo 'selected'; ?>>TAS</option>
          <option value="ACT" <?php if(isset($_SESSION['state']) && $_SESSION['state'] === 'ACT') echo 'selected'; ?>>ACT</option>
        </select>
        <input id="blank">


        <label for="postcode">Postcode <a href="postcode.php" target="_blank">Guidance</a></label>
        <input type="text" name="postcode" id="postcode" size="10" pattern="\d{4}" title="Please enter exact 4 digits" value= "<?php if(isset($_SESSION['postcode'])) echo $_SESSION['postcode'];?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value= "<?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?>">

        <label for="phone_num">Phone Number</label>
        <input type="text" name="phone_num" id="phone_num" pattern="[0-9\s]{8,12}" title="Please enter from 8 to 12 digits" value= "<?php if(isset($_SESSION['phone_num'])) echo $_SESSION['phone_num'];?>">

        <div class="skill_list">
          <h2>Skills List</h2>
          <label class="container">Programming Languages
            <input type="checkbox" name="skill1" value="Programming Languages" <?php if(isset($_SESSION['skill1']) && $_SESSION['skill1'] == "Programming Languages") echo "checked"; ?> >
            <span class="checkmark <?php if(isset($_SESSION['skill1']) && $_SESSION['skill1'] == "Programming Languages") echo 'checked'; ?>"></span>
          </label>

          <label class="container">Web Development
            <input type="checkbox" name="skill2" value="Web Development" <?php if(isset($_SESSION['skill2']) && $_SESSION['skill2'] == "Web Development") echo "checked"; ?>>
            <span class="checkmark <?php if(isset($_SESSION['skill2']) && $_SESSION['skill2'] == "Web Development") echo 'checked'; ?>""></span>
          </label>


          <label class="container">Database Management
            <input type="checkbox" name="skill3" value="Database Management" <?php if(isset($_SESSION['skill3']) && $_SESSION['skill3'] == "Database Management") echo "checked"; ?>>
            <span class="checkmark <?php if(isset($_SESSION['skill3']) && $_SESSION['skill3'] == "Database Management") echo 'checked'; ?>""></span>
          </label>


          <label class="container">Cloud Computing
            <input type="checkbox" name="skill4" value="Cloud Computing" <?php if(isset($_SESSION['skill4']) && $_SESSION['skill4'] == "Cloud Computing") echo "checked"; ?>>
            <span class="checkmark <?php if(isset($_SESSION['skill4']) && $_SESSION['skill4'] == "Cloud Computing") echo 'checked'; ?>"></span>
          </label>


          <label class="container">Cybersecurity
            <input type="checkbox" name="skill5" value="Cybersecurity" <?php if(isset($_SESSION['skill5']) && $_SESSION['skill5'] == "Cybersecurity") echo "checked"; ?>>
            <span class="checkmark <?php if(isset($_SESSION['skill3']) && $_SESSION['skill3'] == "Cybersecurity") echo 'checked'; ?>"></span>
          </label>



          <label class="container">Other Skills
            <input type="checkbox" name="skill6" value="Other Skills" <?php if(isset($_SESSION['skill6']) && $_SESSION['skill6'] == "Other Skills") echo "checked"; ?>>
            <span class="checkmark <?php if(isset($_SESSION['skill3']) && $_SESSION['skill3'] == "Other Skills") echo 'checked'; ?>"></span>
          </label>

          <br><textarea name="other_skill" rows="5" cols="75" placeholder="Write your other skills here..."><?php if(isset($_SESSION['other_skill'])) echo $_SESSION['other_skill']; ?></textarea>
        </div>

        <input type="submit" name="Apply" value="Apply" id="apply">
        <input type="submit" name="Reset" value ="Reset" id="apply">

        <hr>
      </form>
    </div>
  </div>
  
  <?php require_once("footer.inc");?>

</body>
</html>

<?php 
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['data']);