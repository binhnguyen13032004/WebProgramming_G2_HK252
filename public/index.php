<?php
// Mock Data for Jobs
$jobs = [
    [
        "id" => 1,
        "title" => "Senior UI/UX Designer",
        "company" => "FPT Software",
        "tags" => ["Hot", "Remote"],
        "salary" => "$1500 - $2500",
        "post_date" => "2 days ago"
    ],
    [
        "id" => 2,
        "title" => "Backend PHP Developer",
        "company" => "VNG Corporation",
        "tags" => ["PHP", "Laravel"],
        "salary" => "Negotiable",
        "post_date" => "Today"
    ],
    [
        "id" => 3,
        "title" => "Marketing Manager",
        "company" => "Shopee Vietnam",
        "tags" => ["Urgent"],
        "salary" => "$1000 - $2000",
        "post_date" => "1 week ago"
    ]
];

// Mock Data for Sidebar Filters
$filters = [
    "Industry" => ["IT - Software", "Marketing", "Design", "Sales"],
    "Job Type" => ["Full-time", "Part-time", "Freelance"],
    "Job Level" => ["Intern", "Fresher", "Junior", "Senior", "Manager"],
    "Salary" => ["Under $500", "$500 - $1000", "Over $1000"],
    "Work Model" => ["On-site", "Remote", "Hybrid"],
    "Skills" => ["React", "PHP", "Figma", "SEO"]
];

$totalResults = 1250;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../app/view/pages/css/styles.css">
    <title>Job Search - All Users</title>
</head>
<body>

    <div class="page-wrapper">
        <div class="navbar">
            <div class="navbar-brand">JobPortal</div>
            <div class="navbar-links">
                <a href="#">Jobs</a>
                <a href="#">Companies</a>
                <a href="#">Tools</a>
            </div>
            <div class="navbar-auth">
                <a href="#">Login / Register</a>
            </div>
        </div>

        <div class="hero-section">
            <form class="search-bar" action="#" method="GET">
                <input type="text" name="keyword" class="search-input" placeholder="Keyword (e.g. PHP, React)...">
                <input type="text" name="location" class="search-input" placeholder="Location...">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <div class="content-wrapper">
            
            <aside class="sidebar">
                <?php foreach($filters as $filterName => $options): ?>
                    <div class="filter-group">
                        <h3 class="filter-title"><?php echo htmlspecialchars($filterName); ?></h3>
                        <ul class="filter-list">
                            <?php foreach($options as $option): ?>
                                <li>
                                    <input type="checkbox" id="filter_<?php echo md5($option); ?>">
                                    <label for="filter_<?php echo md5($option); ?>"><?php echo htmlspecialchars($option); ?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </aside>

            <main class="main-content">
                
                <div class="sort-bar">
                    <div class="total-results">
                        Total <strong><?php echo number_format($totalResults); ?></strong> results
                    </div>
                    <div class="sort-options">
                        <span class="active">Newest</span>
                        <span>Salary</span>
                        <span>A-Z</span>
                    </div>
                </div>

                <?php foreach($jobs as $job): ?>
                    <div class="job-card">
                        <div class="job-logo">Logo</div>
                        
                        <div class="job-details">
                            <h3 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p class="job-company"><?php echo htmlspecialchars($job['company']); ?></p>
                            <div>
                                <?php foreach($job['tags'] as $tag): ?>
                                    <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="job-meta">
                            <div class="job-salary"><?php echo htmlspecialchars($job['salary']); ?></div>
                            <div class="job-date"><?php echo htmlspecialchars($job['post_date']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="pagination">
                    <a href="#" class="page-link">&laquo;</a>
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <a href="#" class="page-link">&raquo;</a>
                </div>

            </main>
        </div>
    </div>

</body>
</html>