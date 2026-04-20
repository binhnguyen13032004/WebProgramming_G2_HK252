<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// Define Part A variables
$jobTitleErr = $jobCategoryErr = $employmentTypeErr = $industryErr = $jobLevelErr = $openingsErr = "";
$jobTitle = $jobCategory = $employmentType = $industry = $jobLevel = $openings = "";

// Define Part B variables
$countryErr = $cityErr = $workArrangementErr = "";
$country = $city = $district = $workArrangement = "";

// Define Part C variables
$salaryRangeErr = $salaryTypeErr = $benefitsErr = "";
$salaryRange = $salaryType = $benefits = "";

// Define Part D variables
$jobDescriptionErr = "";
$jobDescription = "";

// Define Part E variables
$skillsErr = $proficiencyErr = "";
$skills = [];
$proficiency = "";
// Pre-defined array of skills for the dropdown
$availableSkills = ["PHP", "JavaScript", "Python", "HTML", "CSS", "SQL", "React", "Node.js", "Java", "C++", "Project Management", "Communication"];

// Define Part F variables
$degreeLevelErr = $experienceErr = "";
$degreeLevel = $experience = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // --- PART A VALIDATION ---
  if (empty($_POST["jobTitle"])) {
    $jobTitleErr = "Job Title is required";
  } else {
    $jobTitle = test_input($_POST["jobTitle"]);
  }
  if (empty($_POST["jobCategory"])) {
    $jobCategoryErr = "Job Category is required";
  } else {
    $jobCategory = test_input($_POST["jobCategory"]);
  }
  if (empty($_POST["employmentType"])) {
    $employmentTypeErr = "Employment Type is required";
  } else {
    $employmentType = test_input($_POST["employmentType"]);
  }
  if (empty($_POST["industry"])) {
    $industryErr = "Industry is required";
  } else {
    $industry = test_input($_POST["industry"]);
  }
  if (empty($_POST["jobLevel"])) {
    $jobLevelErr = "Job Level is required";
  } else {
    $jobLevel = test_input($_POST["jobLevel"]);
  }
  if (empty($_POST["openings"])) {
    $openingsErr = "Number of Openings is required";
  } else {
    $openings = test_input($_POST["openings"]);
    if (!filter_var($openings, FILTER_VALIDATE_INT) || $openings < 1) {
      $openingsErr = "Please enter a valid number (1 or more)";
    }
  }

  // --- PART B VALIDATION ---
  if (empty($_POST["country"])) {
    $countryErr = "Country is required";
  } else {
    $country = test_input($_POST["country"]);
  }
  if (empty($_POST["city"])) {
    $cityErr = "City / Province is required";
  } else {
    $city = test_input($_POST["city"]);
  }
  if (empty($_POST["district"])) {
    $district = "";
  } else {
    $district = test_input($_POST["district"]);
  }
  if (empty($_POST["workArrangement"])) {
    $workArrangementErr = "Work Arrangement is required";
  } else {
    $workArrangement = test_input($_POST["workArrangement"]);
  }

  // --- PART C VALIDATION ---
  if (empty($_POST["salaryRange"])) {
    $salaryRangeErr = "Salary range is required";
  } else {
    $salaryRange = test_input($_POST["salaryRange"]);
  }
  if (empty($_POST["salaryType"])) {
    $salaryTypeErr = "Salary type is required";
  } else {
    $salaryType = test_input($_POST["salaryType"]);
  }
  if (empty($_POST["benefits"])) {
    $benefitsErr = "Benefits are required";
  } else {
    $benefits = test_input($_POST["benefits"]);
  }

  // --- PART D VALIDATION ---
  if (empty($_POST["jobDescription"])) {
    $jobDescriptionErr = "Job Description is required";
  } else {
    $jobDescription = test_input($_POST["jobDescription"]);
  }

  // --- PART E VALIDATION ---
  if (empty($_POST["skills"])) {
    $skillsErr = "At least one skill is required";
  } else {
    $skills = $_POST["skills"];
    if (count($skills) > 5) {
      $skillsErr = "You can select a maximum of 5 skills";
    } else {
      // Sanitize each skill in the array
      foreach ($skills as $key => $value) {
        $skills[$key] = test_input($value);
      }
    }
  }

  if (empty($_POST["proficiency"])) {
    $proficiencyErr = "Minimum proficiency is required";
  } else {
    $proficiency = test_input($_POST["proficiency"]);
  }

  // --- PART F VALIDATION ---
  if (empty($_POST["degreeLevel"])) {
    $degreeLevelErr = "Degree level is required";
  } else {
    $degreeLevel = test_input($_POST["degreeLevel"]);
  }

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

<h2>Job Posting Form</h2>
<p><span class="error">* required field</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
  <h3>A. Basic Job Information</h3>
  Job Title: <input type="text" name="jobTitle" value="<?php echo $jobTitle;?>">
  <span class="error">* <?php echo $jobTitleErr;?></span>
  <br><br>
  
  Job Category: <input type="text" name="jobCategory" value="<?php echo $jobCategory;?>">
  <span class="error">* <?php echo $jobCategoryErr;?></span>
  <br><br>
  
  Employment Type: <input type="text" name="employmentType" value="<?php echo $employmentType;?>">
  <span class="error">* <?php echo $employmentTypeErr;?></span>
  <br><br>
  
  Industry: <input type="text" name="industry" value="<?php echo $industry;?>">
  <span class="error">* <?php echo $industryErr;?></span>
  <br><br>
  
  Job Level:
  <input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Junior") echo "checked";?> value="Junior">Junior
  <input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Mid") echo "checked";?> value="Mid">Mid
  <input type="radio" name="jobLevel" <?php if (isset($jobLevel) && $jobLevel=="Senior") echo "checked";?> value="Senior">Senior  
  <span class="error">* <?php echo $jobLevelErr;?></span>
  <br><br>

  Number of Openings: <input type="number" name="openings" value="<?php echo $openings;?>" min="1">
  <span class="error">* <?php echo $openingsErr;?></span>
  <br><br>
  
  <hr>

  <h3>B. Job Locations</h3>
  Country: <input type="text" name="country" value="<?php echo $country;?>">
  <span class="error">* <?php echo $countryErr;?></span>
  <br><br>

  City / Province: <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">* <?php echo $cityErr;?></span>
  <br><br>

  District: <input type="text" name="district" value="<?php echo $district;?>">
  <br><br>

  Work Arrangement: 
  <select name="workArrangement">
    <option value="" disabled <?php if ($workArrangement == "") echo "selected"; ?>>Select arrangement...</option>
    <option value="Onsite" <?php if (isset($workArrangement) && $workArrangement=="Onsite") echo "selected";?>>Onsite</option>
    <option value="Remote" <?php if (isset($workArrangement) && $workArrangement=="Remote") echo "selected";?>>Remote</option>
    <option value="Hybrid" <?php if (isset($workArrangement) && $workArrangement=="Hybrid") echo "selected";?>>Hybrid</option>
  </select>
  <span class="error">* <?php echo $workArrangementErr;?></span>
  <br><br>

  <hr>

  <h3>C. Salary and Benefit</h3>
  Salary Range: <input type="text" name="salaryRange" value="<?php echo $salaryRange;?>" placeholder="e.g. $50,000 - $70,000">
  <span class="error">* <?php echo $salaryRangeErr;?></span>
  <br><br>

  Salary Type: 
  <select name="salaryType">
    <option value="" disabled <?php if ($salaryType == "") echo "selected"; ?>>Select type...</option>
    <option value="Gross" <?php if (isset($salaryType) && $salaryType=="Gross") echo "selected";?>>Gross</option>
    <option value="Net" <?php if (isset($salaryType) && $salaryType=="Net") echo "selected";?>>Net</option>
  </select>
  <span class="error">* <?php echo $salaryTypeErr;?></span>
  <br><br>

  Benefits: <br>
  <textarea name="benefits" rows="5" cols="40"><?php echo $benefits;?></textarea>
  <span class="error">* <?php echo $benefitsErr;?></span>
  <br><br>

  <hr>

  <h3>D. Job Description</h3>
  <textarea name="jobDescription" rows="12" cols="70" placeholder="Enter comprehensive job description here..."><?php echo $jobDescription;?></textarea>
  <span class="error">* <?php echo $jobDescriptionErr;?></span>
  <br><br>

  <hr>

  <h3>E. Required Skills</h3>
  <p><em>Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options (Maximum 5).</em></p>
  Skills: <br>
  <select name="skills[]" multiple size="6">
    <?php
    foreach ($availableSkills as $skillOption) {
      $selected = in_array($skillOption, $skills) ? "selected" : "";
      echo "<option value=\"$skillOption\" $selected>$skillOption</option>";
    }
    ?>
  </select>
  <span class="error">* <?php echo $skillsErr;?></span>
  <br><br>

  Minimum Proficiency:
  <select name="proficiency">
    <option value="" disabled <?php if ($proficiency == "") echo "selected"; ?>>Select proficiency...</option>
    <option value="Beginner" <?php if ($proficiency=="Beginner") echo "selected";?>>Beginner</option>
    <option value="Intermediate" <?php if ($proficiency=="Intermediate") echo "selected";?>>Intermediate</option>
    <option value="Advanced" <?php if ($proficiency=="Advanced") echo "selected";?>>Advanced</option>
    <option value="Expert" <?php if ($proficiency=="Expert") echo "selected";?>>Expert</option>
  </select>
  <span class="error">* <?php echo $proficiencyErr;?></span>
  <br><br>

  <hr>

  <h3>F. Education & Experience Requirements</h3>
  Minimum Degree Level:
  <select name="degreeLevel">
    <option value="" disabled <?php if ($degreeLevel == "") echo "selected"; ?>>Select degree...</option>
    <option value="High School Diploma" <?php if ($degreeLevel=="High School Diploma") echo "selected";?>>High School Diploma</option>
    <option value="Associate Degree" <?php if ($degreeLevel=="Associate Degree") echo "selected";?>>Associate Degree</option>
    <option value="Bachelor's Degree" <?php if ($degreeLevel=="Bachelor's Degree") echo "selected";?>>Bachelor's Degree</option>
    <option value="Master's Degree" <?php if ($degreeLevel=="Master's Degree") echo "selected";?>>Master's Degree</option>
    <option value="PhD / Doctorate" <?php if ($degreeLevel=="PhD / Doctorate") echo "selected";?>>PhD / Doctorate</option>
  </select>
  <span class="error">* <?php echo $degreeLevelErr;?></span>
  <br><br>

  Minimum Years of Experience: 
  <input type="number" name="experience" value="<?php echo $experience;?>" min="0">
  <span class="error">* <?php echo $experienceErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Submit Job Posting">  
</form>

<?php
// Displaying the input back to the user if there are no errors in any section
if ($_SERVER["REQUEST_METHOD"] == "POST" && 
    empty($jobTitleErr) && empty($jobCategoryErr) && empty($employmentTypeErr) && 
    empty($industryErr) && empty($jobLevelErr) && empty($openingsErr) &&
    empty($countryErr) && empty($cityErr) && empty($workArrangementErr) &&
    empty($salaryRangeErr) && empty($salaryTypeErr) && empty($benefitsErr) &&
    empty($jobDescriptionErr) && empty($skillsErr) && empty($proficiencyErr) &&
    empty($degreeLevelErr) && empty($experienceErr)) {
    
    echo "<h2>Your Input:</h2>";
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
}
?>

</body>
</html>