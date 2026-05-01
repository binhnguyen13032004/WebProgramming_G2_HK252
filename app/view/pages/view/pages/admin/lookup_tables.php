<?php

$tables = [
    'skills'        => 'Skills',
    'categories'    => 'Job Categories',
    'job_titles'    => 'Job Titles',
    'industries'    => 'Industries',
    'locations'     => 'Locations (City/Province)',
    'emp_types'     => 'Employment Types',
    'job_levels'    => 'Job Levels',
    'salary_ranges' => 'Salary Ranges',
    'arrangements'  => 'Work Arrangements',
    'degrees'       => 'Min. Degree Levels',
    'experience'    => 'Min. Experience Years',
    'proficiency'   => 'Min. Proficiency Levels',
];

$current = $_GET['table'] ?? 'skills';
if (!array_key_exists($current, $tables)) $current = 'skills';

$rows = [];
$label = $tables[$current];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lookup Tables — JobPortal Admin</title>
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
        <a href="manage_jobs.php"   class="adm-nav-link">Manage Jobs</a>
        <a href="lookup_tables.php" class="adm-nav-link active">Lookup Tables</a>
    </div>
    <div class="adm-nav-right">
        <span class="adm-nav-user">admin@jobportal.com</span>
        <a href="../logout_1.php" class="adm-btn-logout">Logout</a>
    </div>
</nav>

<div class="adm-wrapper">

    <div class="adm-page-header">
        <h4>Lookup Tables</h4>
        <p>Manage reference data used across the system</p>
    </div>

    <div class="adm-card">
        <div class="adm-lookup-wrap">

            <!-- SIDEBAR -->
            <div class="adm-lookup-sidebar">
                <span class="adm-menu-lbl">Tables</span>
                <?php foreach($tables as $key => $lbl): ?>
                <a href="?table=<?= $key ?>"
                   class="adm-menu-item <?= $current === $key ? 'active' : '' ?>">
                    <?= $lbl ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- CONTENT -->
            <div class="adm-lookup-content">

                <!-- Header -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                    <div>
                        <h5 style="margin:0;color:#2c3e50;font-weight:700"><?= $label ?></h5>
                        <span style="font-size:0.82rem;color:#7f8c8d"><?= count($rows) ?> items</span>
                    </div>
                    <button class="adm-btn adm-btn-primary" onclick="toggleForm()">Add New</button>
                </div>

                <!-- Inline add form -->
                <form method="POST" action="?table=<?= $current ?>">
                    <div class="adm-add-form" id="addForm">
                        <input type="text" name="new_name" placeholder="Enter new name…" required autocomplete="off">
                        <button type="submit" class="adm-btn adm-btn-primary">Save</button>
                        <button type="button" class="adm-btn" onclick="toggleForm()">Cancel</button>
                    </div>
                </form>

                <!-- Table -->
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width:44px">#</th>
                            <th>Name</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="3" style="text-align:center;color:#7f8c8d;padding:30px">No entries found. Connect the database or add new records to populate this table.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($rows as $i => $row): ?>
                        <tr>
                            <td style="color:#bdc3c7"><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($row) ?></td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="#" class="adm-btn" onclick="editRow(this, '<?= htmlspecialchars($row) ?>')">Edit</a>
                                    <a href="?table=<?= $current ?>&action=delete&val=<?= urlencode($row) ?>"
                                       class="adm-btn adm-btn-danger"
                                       onclick="return confirm('Delete this item?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleForm() {
    const f = document.getElementById('addForm');
    f.classList.toggle('show');
    if (f.classList.contains('show')) f.querySelector('input').focus();
}

function editRow(btn, currentName) {
    const newName = prompt('Edit name:', currentName);
    if (newName && newName.trim() && newName.trim() !== currentName) {
        // TODO: gọi PHP để UPDATE DB
        const td = btn.closest('tr').querySelector('td:nth-child(2)');
        td.textContent = newName.trim();
    }
}
</script>
</body>
</html>
