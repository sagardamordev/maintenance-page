<?php
// articles.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once "config/db.php";

// 🔒 STRICT AUTH CHECK
if (!isset($_SESSION['auth'])) {
    header("Location: auth/login.php?redirect=articles.php");
    exit();
}

// Fetch Active Blogs ONLY
$blogs = $conn->query("SELECT * FROM blogs WHERE status=1 ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles | SagarVerse</title>
    <meta name="description"
        content="Read the latest articles and insights on AI, Technology, and System Design from SagarVerse.">
    <link rel="stylesheet" href="assets/CSS/index.css">
    <style>
        .articles-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .grid-tech {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
        }

        .article-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.05);
            border-color: #8e3fd7;
        }

        .article-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .article-body {
            padding: 25px;
        }

        .article-cat {
            color: #f1c40f;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .article-title {
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: #fff;
            line-height: 1.3;
        }

        .article-desc {
            font-size: 0.95rem;
            color: #aaa;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .read-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8e3fd7;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .read-link:hover {
            color: #fff;
            gap: 12px;
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="articles-container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h1 class="gradient-text" style="font-size: 3rem;">Articles & Insights</h1>
            <p style="color: #bbb; max-width: 600px; margin: 15px auto;">Deep dives into AI Engineering, System Design,
                and Future Tech.</p>
        </div>

        <div class="grid-tech">
            <?php if ($blogs && $blogs->num_rows > 0): ?>
                <?php while ($row = $blogs->fetch_assoc()): ?>
                    <div class="article-card">
                        <img src="uploads/blogs/<?= htmlspecialchars($row['image']) ?>"
                            alt="<?= htmlspecialchars($row['title']) ?>" class="article-img">
                        <div class="article-body">
                            <span class="article-cat"><?= htmlspecialchars($row['category']) ?></span>
                            <h3 class="article-title"><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="article-desc"><?= htmlspecialchars(substr($row['short_desc'], 0, 120)) ?>...</p>

                            <!-- If it's a link to an external/internal file, or a full post page. Assuming read_more_link or standard post view -->
                            <?php
                            $link = $row['read_more_link'] ? $row['read_more_link'] : '#';
                            // Ideally create a single_article.php?id=... but the user uses read_more_link mostly.
                            ?>
                            <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="read-link">Read Article <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                    <h3>No Articles Published Yet</h3>
                    <p>Stay tuned for updates.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
</body>

</html>