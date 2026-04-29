<?php
// Mock Data: In a real application, you would fetch this from your database
$jobTitle = "Senior Frontend Developer";
$jobTags = ["Hot", "Urgent"];
$jobType = "Full-time"; // Full-time
$jobLevel = "Senior";
$jobFormat = "Remote";

$jobDescription = "We are looking for a great Frontend developer who is proficient with React.js. Your primary focus will be on developing user interface components and implementing them following well-known React.js workflows.";
$responsibilities = ["Develop new user-facing features", "Build reusable code and libraries", "Optimize application for maximum speed"];
$qualifications = ["Bachelor's degree in Computer Science", "3+ years of experience in frontend development"];
$skills = ["React.js", "JavaScript", "HTML/CSS", "RESTful APIs"];

$salary = "$1500 - $2500";
$location = "Ho Chi Minh City";
$postDate = date("d/m/Y"); // Today's date
$companyName = "Tech Solutions VN";

$requiredSkills = ["React", "JS", "CSS", "HTML", "Git"]; // Max 5 tags
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Job Detail - <?php echo htmlspecialchars($jobTitle); ?></title>
    
</head>
<body>

    <div class="page-wrapper">
        
        <div class="content-wrapper">
            
            <div class="main-content">
                <div class="job-header">
                    <h1 class="job-title">
                        <?php echo htmlspecialchars($jobTitle); ?> 
                        <?php foreach($jobTags as $tag): ?>
                            <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </h1>
                    <div class="meta-text">
                        <?php echo htmlspecialchars($jobType); ?> &middot; 
                        <?php echo htmlspecialchars($jobLevel); ?> &middot; 
                        <?php echo htmlspecialchars($jobFormat); ?>
                    </div>
                </div>

                <div class="job-details">
                    <h2>Job Description</h2>
                    <div class="section-content">
                        <p><?php echo nl2br(htmlspecialchars($jobDescription)); ?></p>
                        
                        <strong>Responsibilities:</strong>
                        <ul>
                            <?php foreach($responsibilities as $item): ?>
                                <li><?php echo htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <strong>Qualifications:</strong>
                        <ul>
                            <?php foreach($qualifications as $item): ?>
                                <li><?php echo htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <strong>Skills:</strong>
                        <ul>
                            <?php foreach($skills as $item): ?>
                                <li><?php echo htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="quick-info">
                    <h2>Quick Information</h2>
                    <div class="meta-text">
                        <strong>Salary:</strong> <?php echo htmlspecialchars($salary); ?><br>
                        <strong>Location:</strong> <?php echo htmlspecialchars($location); ?><br>
                        <strong>Date Posted:</strong> <?php echo htmlspecialchars($postDate); ?><br>
                        <strong>Company:</strong> <?php echo htmlspecialchars($companyName); ?>
                    </div>
                </div>

                <div class="required-skills">
                    <h2>Required Skills</h2>
                    <div class="meta-text" style="font-size: 0.85rem; margin-bottom: 12px; font-style: italic;">
                        (Max 5 tags)
                    </div>
                    <div class="tags-container">
                        <?php 
                        // Ensure we only show a maximum of 5 tags as requested
                        $limitedSkills = array_slice($requiredSkills, 0, 5);
                        foreach($limitedSkills as $skill): 
                        ?>
                            <span class="tag"><?php echo htmlspecialchars($skill); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>