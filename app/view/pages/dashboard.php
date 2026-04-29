<?php
// Mock Data: In a real app, you would fetch this list from your database
// e.g., SELECT * FROM jobs WHERE employer_id = ?
$myJobs = [
    [
        "id" => 101,
        "title" => "Senior Frontend Developer",
        "status" => "active"
    ],
    [
        "id" => 102,
        "title" => "Backend PHP Engineer",
        "status" => "active"
    ],
    [
        "id" => 103,
        "title" => "UI/UX Designer",
        "status" => "inactive"
    ],
    [
        "id" => 104,
        "title" => "Digital Marketing Specialist",
        "status" => "active"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Employer Dashboard - Employer Only</title>    
</head>
<body>

    <div class="page-wrapper">
        <div class="navbar">
            <div class="navbar-brand">Employer Portal</div>
            <a href="create_job.php" class="btn btn-primary">+ Create New Job</a>
        </div>

        <div class="content-wrapper">
            <h2 class="section-title">My Job Listings</h2>
            
            <div class="job-list">
                <?php foreach($myJobs as $job): ?>
                    <div class="job-item">
                        <div class="job-info">
                            <span class="job-title"><?php echo htmlspecialchars($job['title']); ?></span>
                            <span style="color: #bdc3c7;">&middot;</span>
                            <span class="status-<?php echo $job['status']; ?>">
                                <?php echo htmlspecialchars($job['status']); ?>
                            </span>
                        </div>
                        <div class="job-actions">
                            <a href="edit_job.php?id=<?php echo $job['id']; ?>" class="btn btn-action">Edit</a>
                            <a href="delete_job.php?id=<?php echo $job['id']; ?>" class="btn btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        </div>
    </div>

</body>
</html>