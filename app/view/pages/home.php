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
    <title>Job Search - All Users</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            line-height: 1.6;
        }

        a { text-decoration: none; }
        ul { list-style: none; padding: 0; margin: 0; }

        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .navbar-brand { font-size: 1.5rem; font-weight: 700; color: #2c3e50; }
        
        .navbar-links { display: flex; gap: 20px; }
        .navbar-links a { color: #34495e; font-weight: 500; transition: color 0.2s; }
        .navbar-links a:hover { color: #3498db; }

        .navbar-auth a {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: bold;
            transition: background 0.2s;
        }
        .navbar-auth a:hover { background: #2980b9; }

        /* Hero / Search Section */
        .hero-section {
            background-color: #2c3e50;
            padding: 40px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .search-bar {
            display: flex;
            gap: 10px;
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
        }

        .btn-search {
            background: #1abc9c;
            color: white;
            border: none;
            padding: 0 30px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-search:hover { background: #16a085; }

        /* Layout Grid */
        .content-wrapper {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 30px;
            align-items: start;
        }

        /* Sidebar Filters */
        .sidebar {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }

        .filter-group { margin-bottom: 25px; }
        .filter-group:last-child { margin-bottom: 0; }
        
        .filter-title {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 12px;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 5px;
        }

        .filter-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            color: #555;
        }

        .filter-list input[type="checkbox"] {
            margin-right: 10px;
            cursor: pointer;
        }

        .filter-list label { cursor: pointer; font-size: 0.95rem; }

        /* Main Content */
        .sort-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .total-results { color: #7f8c8d; }
        .total-results strong { color: #2c3e50; }

        .sort-options span {
            margin-left: 15px;
            color: #7f8c8d;
            cursor: pointer;
            font-size: 0.95rem;
        }
        .sort-options span.active {
            color: #3498db;
            font-weight: 600;
        }

        /* Job Cards */
        .job-card {
            display: flex;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            margin-bottom: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid transparent;
        }

        .job-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #e0e6ed;
        }

        .job-logo {
            width: 70px;
            height: 70px;
            background: #f4f7f6;
            color: #bdc3c7;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            font-weight: bold;
            margin-right: 20px;
            flex-shrink: 0;
            border: 1px solid #ecf0f1;
        }

        .job-details { flex-grow: 1; }
        
        .job-title {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .job-title:hover { color: #3498db; }

        .job-company { margin: 0 0 10px 0; color: #7f8c8d; font-size: 0.95rem; }

        .tag {
            background: #e8f4fd;
            color: #2980b9;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-right: 6px;
        }

        .job-meta {
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 130px;
        }

        .job-salary {
            color: #27ae60;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .job-date {
            color: #95a5a6;
            font-size: 0.85rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .page-link {
            padding: 8px 14px;
            background: #ffffff;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            color: #34495e;
            font-weight: 600;
            transition: all 0.2s;
        }

        .page-link:hover { background: #f4f7f6; }
        
        .page-link.active {
            background: #3498db;
            color: #ffffff;
            border-color: #3498db;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .content-wrapper { grid-template-columns: 1fr; }
            .sidebar { position: static; }
            .search-bar { flex-direction: column; }
            .job-card { flex-direction: column; align-items: flex-start; }
            .job-logo { margin-bottom: 15px; }
            .job-meta { text-align: left; margin-top: 15px; flex-direction: row; width: 100%; gap: 15px;}
        }
    </style>
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        </div>
    </div>

</body>
</html>