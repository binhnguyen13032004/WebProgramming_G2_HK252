<!DOCTYPE HTML>  
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/styles.css">
<title>Job Posting Form</title>
</head>
<body>  

<?php
// Initialize all variables
$jobTitleErr = $jobCategoryErr = $employmentTypeErr = $industryErr = $jobLevelErr = $openingsErr = "";
$countryErr = $cityErr = $workArrangementErr = "";
$salaryRangeErr = $salaryTypeErr = $benefitsErr = "";
$jobDescriptionErr = "";
$skillsErr = $proficiencyErr = "";
$degreeLevelErr = $experienceErr = "";

$jobTitle = $jobCategory = $employmentType = $industry = $jobLevel = $openings = "";
$country = $city = $district = $workArrangement = "";
$salaryRange = $salaryType = $benefits = "";
$jobDescription = "";
$skills = [];
$proficiency = "";
$degreeLevel = $experience = "";

$availableSkills = ["PHP", "JavaScript", "Python", "HTML", "CSS", "SQL", "React", "Node.js", "Java", "C++", "Project Management", "Communication"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // PART A
  if (empty($_POST["jobTitle"])) { $jobTitleErr = "Job Title is required"; } else { $jobTitle = test_input($_POST["jobTitle"]); }
  if (empty($_POST["jobCategory"])) { $jobCategoryErr = "Job Category is required"; } else { $jobCategory = test_input($_POST["jobCategory"]); }
  if (empty($_POST["employmentType"])) { $employmentTypeErr = "Employment Type is required"; } else { $employmentType = test_input($_POST["employmentType"]); }
  if (empty($_POST["industry"])) { $industryErr = "Industry is required"; } else { $industry = test_input($_POST["industry"]); }
  if (empty($_POST["jobLevel"])) { $jobLevelErr = "Job Level is required"; } else { $jobLevel = test_input($_POST["jobLevel"]); }
  if (empty($_POST["openings"])) { 
      $openingsErr = "Number of Openings is required"; 
  } else { 
      $openings = test_input($_POST["openings"]);
      if (!filter_var($openings, FILTER_VALIDATE_INT) || $openings < 1) { $openingsErr = "Please enter a valid number (1 or more)"; }
  }

  // PART B
  if (empty($_POST["country"])) { $countryErr = "Country is required"; } else { $country = test_input($_POST["country"]); }
  if (empty($_POST["city"])) { $cityErr = "City / Province is required"; } else { $city = test_input($_POST["city"]); }
  if (empty($_POST["district"])) { $district = ""; } else { $district = test_input($_POST["district"]); }
  if (empty($_POST["workArrangement"])) { $workArrangementErr = "Work Arrangement is required"; } else { $workArrangement = test_input($_POST["workArrangement"]); }

  // PART C
  if (empty($_POST["salaryRange"])) { $salaryRangeErr = "Salary range is required"; } else { $salaryRange = test_input($_POST["salaryRange"]); }
  if (empty($_POST["salaryType"])) { $salaryTypeErr = "Salary type is required"; } else { $salaryType = test_input($_POST["salaryType"]); }
  if (empty($_POST["benefits"])) { $benefitsErr = "Benefits are required"; } else { $benefits = test_input($_POST["benefits"]); }

  // PART D
  if (empty($_POST["jobDescription"])) { $jobDescriptionErr = "Job Description is required"; } else { $jobDescription = test_input($_POST["jobDescription"]); }

  // PART E
  if (empty($_POST["skills"])) {
    $skillsErr = "At least one skill is required";
  } else {
    $skills = $_POST["skills"];
    if (count($skills) > 5) {
      $skillsErr = "You can select a maximum of 5 skills";
    } else {
      foreach ($skills as $key => $value) { $skills[$key] = test_input($value); }
    }
  }
  if (empty($_POST["proficiency"])) { $proficiencyErr = "Minimum proficiency is required"; } else { $proficiency = test_input($_POST["proficiency"]); }

  // PART F
  if (empty($_POST["degreeLevel"])) { $degreeLevelErr = "Degree level is required"; } else { $degreeLevel = test_input($_POST["degreeLevel"]); }
  if (empty($_POST["experience"]) && $_POST["experience"] !== '0') {
    $experienceErr = "Years of experience is required";
  } else {
    $experience = test_input($_POST["experience"]);
    if (!filter_var($experience, FILTER_VALIDATE_INT) && $experience !== '0' || $experience < 0) {
      $experienceErr = "Please enter a valid number of years (0 or more)";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="form-container">
    <h2>Job Posting Form</h2>
    <p class="help-text"><span class="required-asterisk">*</span> Indicates a required field</p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
      
      <h3>A. Basic Job Information</h3>
      
      <div class="form-group">
          <label>Job Title <span class="required-asterisk">*</span></label>
          <input type="text" name="jobTitle" value="<?php echo $jobTitle;?>" placeholder="e.g. Software Engineer">
          <span class="error"><?php echo $jobTitleErr;?></span>
      </div>
      
      <div class="form-group">
          <label>Job Category <span class="required-asterisk">*</span></label>
          <input type="text" name="jobCategory" value="<?php echo $jobCategory;?>" placeholder="e.g. Information Technology">
          <span class="error"><?php echo $jobCategoryErr;?></span>
      </div>
      
      <div class="form-group">
          <label>Employment Type <span class="required-asterisk">*</span></label>
          <input type="text" name="employmentType" value="<?php echo $employmentType;?>" placeholder="e.g. Full-Time, Part-Time">
          <span class="error"><?php echo $employmentTypeErr;?></span>
      </div>
      
      <div class="form-group">
          <label>Industry <span class="required-asterisk">*</span></label>
          <input type="text" name="industry" value="<?php echo $industry;?>" placeholder="e.g. Financial Services">
          <span class="error"><?php echo $industryErr;?></span>
      </div>
      
      <div class="form-group">
          <label>Job Level <span class="required-asterisk">*</span></label>
          <div class="radio-group">
              <label><input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Junior") echo "checked";?> value="Junior"> Junior</label>
              <label><input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Mid") echo "checked";?> value="Mid"> Mid</label>
              <label><input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Senior") echo "checked";?> value="Senior"> Senior</label>
          </div>
          <span class="error"><?php echo $jobLevelErr;?></span>
      </div>

      <div class="form-group">
          <label>Number of Openings <span class="required-asterisk">*</span></label>
          <input type="number" name="openings" value="<?php echo $openings;?>" min="1">
          <span class="error"><?php echo $openingsErr;?></span>
      </div>
      
      <h3>B. Job Locations</h3>
      
      <div class="form-group">
          <label>Country <span class="required-asterisk">*</span></label>
          <input type="text" name="country" value="<?php echo $country;?>">
          <span class="error"><?php echo $countryErr;?></span>
      </div>

      <div class="form-group">
          <label>City / Province <span class="required-asterisk">*</span></label>
          <input type="text" name="city" value="<?php echo $city;?>">
          <span class="error"><?php echo $cityErr;?></span>
      </div>

      <div class="form-group">
          <label>District <span class="help-text" style="display:inline;">(Optional)</span></label>
          <input type="text" name="district" value="<?php echo $district;?>">
      </div>

      <div class="form-group">
          <label>Work Arrangement <span class="required-asterisk">*</span></label>
          <select name="workArrangement">
            <option value="" disabled <?php if ($workArrangement == "") echo "selected"; ?>>Select arrangement...</option>
            <option value="Onsite" <?php if (isset($workArrangement) && $workArrangement=="Onsite") echo "selected";?>>Onsite</option>
            <option value="Remote" <?php if (isset($workArrangement) && $workArrangement=="Remote") echo "selected";?>>Remote</option>
            <option value="Hybrid" <?php if (isset($workArrangement) && $workArrangement=="Hybrid") echo "selected";?>>Hybrid</option>
          </select>
          <span class="error"><?php echo $workArrangementErr;?></span>
      </div>

      <h3>C. Salary and Benefit</h3>
      
      <div class="form-group">
          <label>Salary Range <span class="required-asterisk">*</span></label>
          <input type="text" name="salaryRange" value="<?php echo $salaryRange;?>" placeholder="e.g. $50,000 - $70,000">
          <span class="error"><?php echo $salaryRangeErr;?></span>
      </div>

      <div class="form-group">
          <label>Salary Type <span class="required-asterisk">*</span></label>
          <select name="salaryType">
            <option value="" disabled <?php if ($salaryType == "") echo "selected"; ?>>Select type...</option>
            <option value="Gross" <?php if (isset($salaryType) && $salaryType=="Gross") echo "selected";?>>Gross</option>
            <option value="Net" <?php if (isset($salaryType) && $salaryType=="Net") echo "selected";?>>Net</option>
          </select>
          <span class="error"><?php echo $salaryTypeErr;?></span>
      </div>

      <div class="form-group">
          <label>Benefits <span class="required-asterisk">*</span></label>
          <textarea name="benefits" rows="4"><?php echo $benefits;?></textarea>
          <span class="error"><?php echo $benefitsErr;?></span>
      </div>

      <h3>D. Job Description</h3>
      
      <div class="form-group">
          <label>Description <span class="required-asterisk">*</span></label>
          <textarea name="jobDescription" rows="8" placeholder="Enter comprehensive job description here..."><?php echo $jobDescription;?></textarea>
          <span class="error"><?php echo $jobDescriptionErr;?></span>
      </div>

      <h3>E. Required Skills</h3>
      
      <div class="form-group">
          <label>Skills <span class="required-asterisk">*</span></label>
          <span class="help-text">Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options (Maximum 5).</span>
          <select name="skills[]" multiple size="6">
            <?php
            foreach ($availableSkills as $skillOption) {
              $selected = in_array($skillOption, $skills) ? "selected" : "";
              echo "<option value=\"$skillOption\" $selected>$skillOption</option>";
            }
            ?>
          </select>
          <span class="error"><?php echo $skillsErr;?></span>
      </div>

      <div class="form-group">
          <label>Minimum Proficiency <span class="required-asterisk">*</span></label>
          <select name="proficiency">
            <option value="" disabled <?php if ($proficiency == "") echo "selected"; ?>>Select proficiency...</option>
            <option value="Beginner" <?php if ($proficiency=="Beginner") echo "selected";?>>Beginner</option>
            <option value="Intermediate" <?php if ($proficiency=="Intermediate") echo "selected";?>>Intermediate</option>
            <option value="Advanced" <?php if ($proficiency=="Advanced") echo "selected";?>>Advanced</option>
            <option value="Expert" <?php if ($proficiency=="Expert") echo "selected";?>>Expert</option>
          </select>
          <span class="error"><?php echo $proficiencyErr;?></span>
      </div>

      <h3>F. Education & Experience Requirements</h3>
      
      <div class="form-group">
          <label>Minimum Degree Level <span class="required-asterisk">*</span></label>
          <select name="degreeLevel">
            <option value="" disabled <?php if ($degreeLevel == "") echo "selected"; ?>>Select degree...</option>
            <option value="High School Diploma" <?php if ($degreeLevel=="High School Diploma") echo "selected";?>>High School Diploma</option>
            <option value="Associate Degree" <?php if ($degreeLevel=="Associate Degree") echo "selected";?>>Associate Degree</option>
            <option value="Bachelor's Degree" <?php if ($degreeLevel=="Bachelor's Degree") echo "selected";?>>Bachelor's Degree</option>
            <option value="Master's Degree" <?php if ($degreeLevel=="Master's Degree") echo "selected";?>>Master's Degree</option>
            <option value="PhD / Doctorate" <?php if ($degreeLevel=="PhD / Doctorate") echo "selected";?>>PhD / Doctorate</option>
          </select>
          <span class="error"><?php echo $degreeLevelErr;?></span>
      </div>

      <div class="form-group">
          <label>Minimum Years of Experience <span class="required-asterisk">*</span></label>
          <input type="number" name="experience" value="<?php echo $experience;?>" min="0">
          <span class="error"><?php echo $experienceErr;?></span>
      </div>

      <input type="submit" name="submit" value="Submit Job Posting">  
    </form>

    <?php
    // Output success container
    if ($_SERVER["REQUEST_METHOD"] == "POST" && 
        empty($jobTitleErr) && empty($jobCategoryErr) && empty($employmentTypeErr) && 
        empty($industryErr) && empty($jobLevelErr) && empty($openingsErr) &&
        empty($countryErr) && empty($cityErr) && empty($workArrangementErr) &&
        empty($salaryRangeErr) && empty($salaryTypeErr) && empty($benefitsErr) &&
        empty($jobDescriptionErr) && empty($skillsErr) && empty($proficiencyErr) &&
        empty($degreeLevelErr) && empty($experienceErr)) {
        
        echo "<div class='result-container'>";
        echo "<h2>Submission Successful</h2>";
        
        echo "<h3>A. Basic Job Information</h3>";
        echo "<strong>Job Title:</strong> " . $jobTitle . "<br>";
        echo "<strong>Job Category:</strong> " . $jobCategory . "<br>";
        echo "<strong>Employment Type:</strong> " . $employmentType . "<br>";
        echo "<strong>Industry:</strong> " . $industry . "<br>";
        echo "<strong>Job Level:</strong> " . $jobLevel . "<br>";
        echo "<strong>Number of Openings:</strong> " . $openings . "<br>";

        echo "<h3>B. Job Locations</h3>";
        echo "<strong>Country:</strong> " . $country . "<br>";
        echo "<strong>City / Province:</strong> " . $city . "<br>";
        echo "<strong>District:</strong> " . ($district ? $district : "<em>Not provided</em>") . "<br>";
        echo "<strong>Work Arrangement:</strong> " . $workArrangement . "<br>";

        echo "<h3>C. Salary and Benefit</h3>";
        echo "<strong>Salary Range:</strong> " . $salaryRange . "<br>";
        echo "<strong>Salary Type:</strong> " . $salaryType . "<br>";
        echo "<strong>Benefits:</strong><br>" . nl2br($benefits) . "<br>";

        echo "<h3>D. Job Description</h3>";
        echo "<strong>Description:</strong><br>" . nl2br($jobDescription) . "<br>";

        echo "<h3>E. Required Skills</h3>";
        echo "<strong>Selected Skills:</strong> " . implode(", ", $skills) . "<br>";
        echo "<strong>Minimum Proficiency:</strong> " . $proficiency . "<br>";

        echo "<h3>F. Education & Experience Requirements</h3>";
        echo "<strong>Minimum Degree Level:</strong> " . $degreeLevel . "<br>";
        echo "<strong>Minimum Years of Experience:</strong> " . $experience . " year(s)<br>";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>