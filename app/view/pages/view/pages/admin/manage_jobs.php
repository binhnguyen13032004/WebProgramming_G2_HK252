<?php

$jobs = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Jobs — JobPortal Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="adm-body">

<!-- NAVBAR -->
<nav class="adm-navbar">
    <a href="dashboard.php" class="adm-navbar-brand">JobPortal Admin</a>
    <div class="adm-nav-links">
        <a href="dashboard.php"     class="adm-nav-link">Dashboard</a>
        <a href="manage_jobs.php"   class="adm-nav-link active">Manage Jobs</a>
        <a href="lookup_tables.php" class="adm-nav-link">Lookup Tables</a>
    </div>
    <div class="adm-nav-right">
        <span class="adm-nav-user">admin@jobportal.com</span>
        <a href="../logout_1.php" class="adm-btn-logout">Logout</a>
    </div>
</nav>

<div class="adm-wrapper">

    <div class="adm-page-header">
        <h4>Manage Jobs</h4>
        <p>View and remove all job postings in the system</p>
    </div>

    <div class="adm-card">

        <!-- TOOLBAR -->
        <div class="adm-toolbar">
            <input type="text" placeholder="Search job title, employer…">
            <select>
                <option value="">All Categories</option>
                <option>IT - Software</option>
                <option>Marketing</option>
                <option>Design</option>
                <option>Sales</option>
            </select>
            <select>
                <option value="">All Levels</option>
                <option>Junior</option>
                <option>Mid</option>
                <option>Senior</option>
            </select>
            <select>
                <option value="">All Types</option>
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Freelance</option>
            </select>
            <select>
                <option value="">All Arrangements</option>
                <option>Onsite</option>
                <option>Remote</option>
                <option>Hybrid</option>
            </select>
            <select>
                <option>Newest</option>
                <option>Oldest</option>
            </select>
            <button class="adm-btn adm-btn-primary">Filter</button>
            <a href="manage_jobs.php" class="adm-btn">Reset</a>
        </div>

        <!-- TABLE -->
        <table class="adm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Employer</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Level</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jobs)): ?>
                <tr>
                    <td colspan="10" style="text-align:center;color:#7f8c8d;padding:24px">No job postings have been created yet.</td>
                </tr>
                <?php else: ?>
                <?php foreach($jobs as $i => $job): ?>
                <tr>
                    <td style="color:#bdc3c7"><?= $i + 1 ?></td>
                    <td><strong><?= htmlspecialchars($job['title']) ?></strong></td>
                    <td><?= htmlspecialchars($job['employer']) ?></td>
                    <td><?= htmlspecialchars($job['category']) ?></td>
                    <td><?= htmlspecialchars($job['type']) ?></td>
                    <td><?= htmlspecialchars($job['level']) ?></td>
                    <td><?= htmlspecialchars($job['city']) ?></td>
                    <td><?= htmlspecialchars($job['salary']) ?></td>
                    <td>
                        <span class="adm-badge-<?= $job['status'] ?>">
                            <?= ucfirst($job['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="../job_detail.php?id=<?= $job['id'] ?>" class="adm-btn">View</a>
                            <a href="#" class="adm-btn adm-btn-danger"
                               onclick="return confirm('Delete this job? This cannot be undone.')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="adm-pg-wrap">
            <span class="adm-pg-info">Showing <?= count($jobs) ?> of <?= count($jobs) ?> results</span>
            <?php if (!empty($jobs)): ?>
            <ul class="adm-pagination">
                <li class="disabled"><a href="#">&laquo;</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
