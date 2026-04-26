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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail - <?php echo htmlspecialchars($jobTitle); ?></title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px 0;
        }

        /* Layout */
        .page-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            align-items: start;
        }

        /* Card Styles */
        .main-content, .sidebar .quick-info, .sidebar .required-skills {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        /* Typography & Headers */
        h1, h2 {
            color: #2c3e50;
            margin-top: 0;
        }

        .job-title {
            font-size: 2rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .job-details h2 {
            font-size: 1.5rem;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .sidebar h2 {
            font-size: 1.25rem;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        /* Meta Text & Info */
        .meta-text {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .job-header .meta-text {
            font-size: 1.1rem;
            color: #34495e;
            font-weight: 500;
        }

        .sidebar .meta-text strong {
            color: #34495e;
            display: inline-block;
            width: 90px;
        }

        .sidebar .meta-text {
            line-height: 2;
        }

        /* Lists */
        ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        /* Tags */
        .tag {
            background-color: #e8f4fd;
            color: #2980b9;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        /* Title specific tags styling for attention */
        .job-title .tag {
            background-color: #fdeaea;
            color: #e74c3c;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }
            .job-title {
                font-size: 1.5rem;
            }
            .main-content, .sidebar .quick-info, .sidebar .required-skills {
                padding: 20px;
            }
        }
    </style>
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