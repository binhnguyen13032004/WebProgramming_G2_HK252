<?php

$stats = [
    'total_jobs'   => 0,
    'employers'    => 0,
    'job_seekers'  => 0,
    'total_users'  => 0,
];

$recentJobs = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard — JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="adm-body">

<!-- NAVBAR -->
<nav class="adm-navbar">
    <a href="dashboard.php" class="adm-navbar-brand">JobPortal Admin</a>
    <div class="adm-nav-links">
        <a href="dashboard.php"     class="adm-nav-link active">Dashboard</a>
        <a href="manage_jobs.php"   class="adm-nav-link">Manage Jobs</a>
        <a href="lookup_tables.php" class="adm-nav-link">Lookup Tables</a>
    </div>
    <div class="adm-nav-right">
        <span class="adm-nav-user">admin@jobportal.com</span>
        <a href="../logout_1.php" class="adm-btn-logout">Logout</a>
    </div>
</nav>

<div class="adm-wrapper">

    <!-- Page header -->
    <div class="adm-page-header">
        <h4>Dashboard</h4>
        <p>System overview</p>
    </div>

    <!-- STAT CARDS -->
    <div class="adm-stats">
        <div class="adm-stat-card">
            <div>
                <div class="adm-stat-num"><?= $stats['total_jobs'] ?></div>
                <div class="adm-stat-lbl">Total Jobs Posted</div>
                <span class="adm-stat-chip" style="background:#eafaf1;color:#27ae60">No live jobs</span>
            </div>
            <div class="adm-stat-icon" style="background:#eafaf1;color:#27ae60"></div>
        </div>
        <div class="adm-stat-card">
            <div>
                <div class="adm-stat-num"><?= $stats['employers'] ?></div>
                <div class="adm-stat-lbl">Employers</div>
                <span class="adm-stat-chip" style="background:#e8f4fd;color:#2980b9">No data</span>
            </div>
            <div class="adm-stat-icon" style="background:#e8f4fd;color:#2980b9"></div>
        </div>
        <div class="adm-stat-card">
            <div>
                <div class="adm-stat-num"><?= $stats['job_seekers'] ?></div>
                <div class="adm-stat-lbl">Job Seekers</div>
                <span class="adm-stat-chip" style="background:#e8f4fd;color:#2980b9">No data</span>
            </div>
            <div class="adm-stat-icon" style="background:#f4ecff;color:#8e44ad"></div>
        </div>
        <div class="adm-stat-card">
            <div>
                <div class="adm-stat-num"><?= $stats['total_users'] ?></div>
                <div class="adm-stat-lbl">Total Users</div>
            </div>
            <div class="adm-stat-icon" style="background:#fef9e7;color:#f39c12"></div>
        </div>
    </div>

    <!-- RECENT JOBS + QUICK NAV -->
    <div class="adm-row">

        <div class="adm-col-8">
            <div class="adm-card">
                <div class="adm-card-head">
                    <h6>Recently Posted Jobs</h6>
                    <a href="manage_jobs.php" class="adm-btn adm-btn-primary">View all →</a>
                </div>
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php if (empty($recentJobs)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;color:#7f8c8d;padding:24px">There are no recent jobs to display yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="adm-col-4">
            <div class="adm-card">
                <div class="adm-card-head"><h6>Quick Navigation</h6></div>
                <div class="adm-card-body">
                    <a href="manage_jobs.php"   class="adm-quick-btn">Manage All Jobs</a>
                    <a href="lookup_tables.php" class="adm-quick-btn">Manage Lookup Tables</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
