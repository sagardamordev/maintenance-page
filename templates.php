<?php
// templates.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once "config/db.php";

// 🔒 STRICT AUTH CHECK
if (!isset($_SESSION['auth'])) {
    header("Location: auth/login.php?redirect=templates.php");
    exit();
}

// Fetch Templates
$result = $conn->query("SELECT * FROM templates ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates & Assets | SagarVerse</title>
    <meta name="description"
        content="Download premium UI templates, code snippets, and digital assets. Boost your development workflow with SagarVerse resources.">
    <link rel="stylesheet" href="assets/CSS/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Modern Template Page Styles */
        :root {
            --card-bg: rgba(20, 20, 35, 0.6);
            --card-border: 1px solid rgba(255, 255, 255, 0.1);
            --primary-gradient: linear-gradient(135deg, #8e3fd7, #5b2bb0);
        }

        body {
            background-color: #05050a;
            color: #fff;
        }

        /* Hero Section */
        .templates-hero {
            padding: 100px 20px 60px;
            text-align: center;
            background: radial-gradient(circle at top, rgba(142, 63, 215, 0.15), transparent 60%);
        }

        .templates-hero h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            background: linear-gradient(to right, #fff, #b48cff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .templates-hero p {
            color: #a0a0b0;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .search-bar {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 15px 50px 15px 25px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
            transition: 0.3s;
        }

        .search-bar input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #8e3fd7;
            outline: none;
            box-shadow: 0 0 20px rgba(142, 63, 215, 0.2);
        }

        .search-bar i {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        /* Grid Layout */
        .templates-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 100px;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        /* Card Design */
        .template-card {
            background: var(--card-bg);
            border: var(--card-border);
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .template-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(142, 63, 215, 0.4);
        }

        .card-thumb {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .template-card:hover .card-thumb img {
            transform: scale(1.1);
        }

        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .price-free {
            background: rgba(46, 204, 113, 0.9);
            color: #fff;
        }

        .price-paid {
            background: rgba(241, 196, 15, 0.9);
            color: #000;
        }

        .card-body {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #fff;
        }

        .card-body p {
            color: #a0a0b0;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
            /* Pushes button down */
        }

        .card-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: #777;
            margin-bottom: 20px;
        }

        .action-btn {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            background: var(--primary-gradient);
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            filter: brightness(1.2);
            box-shadow: 0 10px 20px rgba(142, 63, 215, 0.3);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 100px 0;
            color: #555;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .templates-hero h1 {
                font-size: 2.2rem;
            }

            .grid-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section class="templates-hero">
        <h1>Digital Templates & Assets</h1>
        <p>Accelerate your development with our premium, production-ready UI kits and code snippets.</p>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search templates...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </section>

    <section class="templates-container">
        <div class="grid-layout" id="templatesGrid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="template-card" data-title="<?= strtolower(htmlspecialchars($row['title'])) ?>">
                        <div class="card-thumb">
                            <img src="uploads/templates/<?= htmlspecialchars($row['image']) ?>"
                                alt="<?= htmlspecialchars($row['title']) ?>">
                            <?php if ($row['price'] == 0): ?>
                                <div class="price-badge price-free">FREE</div>
                            <?php else: ?>
                                <div class="price-badge price-paid">₹<?= number_format($row['price']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>

                            <div class="card-meta">
                                <span><i class="fa-solid fa-file-code"></i> Source Code</span>
                                <span><i class="fa-solid fa-eye"></i> <?= $row['views'] ?> Views</span>
                            </div>

                            <a href="<?= htmlspecialchars($row['download_link']) ?>" target="_blank" class="action-btn">
                                <i class="fa-solid fa-cloud-arrow-down"></i>
                                <?= ($row['price'] == 0) ? 'Download Now' : 'Purchase / Get Access' ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open"></i>
                    <h3>No Templates Available Yet</h3>
                    <p>We are currently curating the best assets. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

    <script>
        // Simple Search Filter
        const searchInput = document.getElementById('searchInput');
        const grid = document.getElementById('templatesGrid');
        const cards = document.querySelectorAll('.template-card');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            let hasVisible = false;

            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                if (title.includes(term)) {
                    card.style.display = 'flex';
                    hasVisible = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Handle no results
            let noMsg = document.getElementById('no-results-msg');
            if (!hasVisible) {
                if (!noMsg) {
                    noMsg = document.createElement('div');
                    noMsg.id = 'no-results-msg';
                    noMsg.className = 'empty-state';
                    noMsg.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i><h3>No matches found</h3><p>Try a different keyword.</p>';
                    grid.appendChild(noMsg);
                }
            } else {
                if (noMsg) noMsg.remove();
            }
        });
    </script>

</body>

</html>