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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Employer Only</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Layout */
        .page-wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        /* Content Container */
        .content-wrapper {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .section-title {
            margin-top: 0;
            margin-bottom: 25px;
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            font-size: 1.5rem;
        }

        /* Buttons */
        .btn {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            border: none;
        }

        .btn-primary {
            background-color: #3498db;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-action {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
            padding: 8px 14px;
            font-size: 0.9rem;
        }

        .btn-action:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .btn-delete {
            background-color: #fdf2f2;
            border: 1px solid #f5c6cb;
            color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Job List */
        .job-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .job-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border: 1px solid #e0e6ed;
            border-radius: 6px;
            background-color: #fafbfc;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .job-item:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-color: #bdc3c7;
            background-color: #ffffff;
        }

        .job-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .job-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #34495e;
        }

        /* Status Badges */
        .status-active {
            background-color: #eafaf1;
            color: #27ae60;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-inactive {
            background-color: #fdf2e9;
            color: #e67e22;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .job-actions {
            display: flex;
            gap: 10px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .job-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .job-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
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