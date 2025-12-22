<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Sagar - Official Personal Website. Exploring tech innovation, AI engineering, and real-world problem solving.">
    <title>Sagar | Official Website</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/CSS/index.css">

    <!-- Favicon placeholder -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>

<body>

    <?php
    include 'includes/header.php';
    // Fetch Homepage/Portfolio Settings
    $hpRes = $conn->query("SELECT * FROM system_settings WHERE setting_key LIKE 'portfolio_%'");
    $hp = [];
    while ($r = $hpRes->fetch_assoc())
        $hp[$r['setting_key']] = $r['setting_value'];

    // Fetch Latest 3 Articles
    $latestBlogs = $conn->query("SELECT * FROM blogs WHERE status=1 ORDER BY created_at DESC LIMIT 3");
    ?>


    <main>

        <!-- ================= HERO ================= -->
        <section class="hero">
            <div class="container hero-grid">

                <!-- LEFT : TEXT -->
                <div class="hero-text">
                    <span class="badge">Official Personal Website</span>

                    <h1 class="hero-title">
                        <?= htmlspecialchars($hp['portfolio_hero_title'] ?? "Crafting Smart Solutions for a") ?><br>
                        <span class="gradient-text">Digital World</span>
                        <div style="font-size: 1.5rem; margin-top: 10px; color: #a5a5b5; min-height: 1.6em;">
                            I am a <span id="typed-text" style="color: #fff; font-weight: 600;"></span><span
                                class="cursor">|</span>
                        </div>
                    </h1>

                    <p class="hero-desc">
                        <?= htmlspecialchars($hp['portfolio_hero_desc'] ?? "Welcome to my digital space. Here, I share my journey...") ?>
                    </p>

                    <div class="hero-actions">
                        <a href="articles.php" class="btn primary guest-protected">Read Articles</a>
                        <a href="projects.php" class="btn secondary guest-protected">See My Work</a>
                    </div>
                </div>

                <!-- RIGHT : IMAGE -->
                <div class="hero-visual">
                    <div class="profile-card" id="profileCard">
                        <div class="glow-overlay" id="glowOverlay"></div>

                        <div class="profile-image-container">
                            <img src="<?= $rootPath ?><?= $profileImage ?>" alt="<?= htmlspecialchars($userName) ?>">
                        </div>

                        <div class="card-content">
                            <h2 class="name"><?= htmlspecialchars($isLoggedIn ? $userName : "Sagar Kumar") ?></h2>
                            <p class="role"><?= $isLoggedIn ? "SagarVerse Member" : "Innovator & Developer" ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= MARQUEE ================= -->
        <section class="marquee">
            <div class="track">
                <span>PYTHON</span>
                <span>JAVASCRIPT</span>
                <span>AI SYSTEMS</span>
                <span>SYSTEM DESIGN</span>
                <span>STRATEGY</span>
                <span>INNOVATION</span>
                <span>FULL-STACK</span>
                <span>AGENTIC AI</span>
                <span>CLOUD COMPUTING</span>

                <span class="market-tag">*TECH HUB -> </span>
                <span>CURSOR AI</span>
                <span>GOOGLE AI STUDIO</span>
                <span>OPENAI</span>
                <span>V0.DEV</span>
                <span>LLM ORCHESTRATION</span>

                <!-- Duplicate for scroll -->
                <span>PYTHON</span>
                <span>JAVASCRIPT</span>
                <span>AI SYSTEMS</span>
            </div>
        </section>

        <!-- ================= VISION / APPROACH ================= -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">My Vision & Core Pillars</h2>
                <div class="section-line"></div>
                <p class="section-text">
                    I believe that <strong>technology should serve humanity</strong>. My work is built on three core
                    pillars:
                    <strong>Problem Clarity</strong>, <strong>Systemic Thinking</strong>, and <strong>Sustainable
                        Innovation</strong>.
                    This website serves as a living documentation of my experiments and insights.
                </p>
            </div>
        </section>

        <!-- ================= BLOG / ARTICLES ================= -->
        <section class="section alt">
            <div class="container">
                <h2 class="section-title">Latest Insights & Articles</h2>
                <div class="section-line"></div>

                <div class="article-grid">
                    <?php if ($latestBlogs && $latestBlogs->num_rows > 0): ?>
                        <?php while ($b = $latestBlogs->fetch_assoc()): ?>
                            <article class="article-card guest-protected"
                                onclick="window.location.href='<?= $b['read_more_link'] ? $b['read_more_link'] : 'articles.php' ?>'">
                                <span class="badge"
                                    style="margin-bottom: 10px; font-size: 0.6rem;"><?= htmlspecialchars($b['category']) ?></span>
                                <h3><?= htmlspecialchars($b['title']) ?></h3>
                                <p><?= htmlspecialchars(substr($b['short_desc'], 0, 100)) ?>...</p>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align:center; opacity:0.6; grid-column:1/-1;">No recent articles found.</p>
                    <?php endif; ?>
                </div>

                <div class="read-more-wrap">
                    <a href="articles.php" class="read-more-btn guest-protected">Access All Updates</a>
                </div>
            </div>
        </section>

        <!-- ================= VENTURES / PROJECTS ================= -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">Initiatives & Building</h2>
                <div class="section-line"></div>

                <div class="bento">
                    <div class="card">
                        <h3>VisionGuard</h3>
                        <p>An AI-first attendance system protecting institutional integrity with face recognition
                            technology.</p>
                    </div>

                    <div class="card">
                        <h3>CareSync</h3>
                        <p>Redefining hospital workflows with intelligent clinical automation and data synchronicity.
                        </p>
                    </div>

                    <div class="card">
                        <h3>ElectroMart</h3>
                        <p>Demonstrating secure, high-performance commerce through custom PHP engineering.</p>
                    </div>
                </div>

                <div class="read-more-wrap">
                    <a href="projects.php" class="read-more-btn guest-protected">Deep Dive Into My Work</a>
                </div>
            </div>
        </section>

        <!-- ================= COMMUNITY STATS ================= -->
        <section class="section alt">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fa-solid fa-earth-americas stat-icon"></i>
                        <h3 class="stat-number"><?= $totalVisitors ?></h3>
                        <p class="stat-label">Total Visitors</p>
                    </div>
                    <div class="stat-card">
                        <i class="fa-solid fa-users stat-icon"></i>
                        <h3 class="stat-number"><?= $totalUsers ?></h3>
                        <p class="stat-label">Registered Members</p>
                    </div>
                </div>
            </div>

            <style>
                .stats-grid {
                    display: flex;
                    justify-content: center;
                    gap: 60px;
                    flex-wrap: wrap;
                    margin-top: 20px;
                }

                .stat-card {
                    background: rgba(255, 255, 255, 0.03);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    padding: 30px 50px;
                    border-radius: 16px;
                    text-align: center;
                    transition: transform 0.3s;
                    min-width: 200px;
                }

                .stat-card:hover {
                    transform: translateY(-5px);
                    background: rgba(255, 255, 255, 0.05);
                    border-color: rgba(142, 63, 215, 0.5);
                }

                .stat-icon {
                    font-size: 2.5rem;
                    color: #8e3fd7;
                    margin-bottom: 15px;
                }

                .stat-number {
                    font-size: 2.5rem;
                    font-weight: 700;
                    margin-bottom: 5px;
                    background: linear-gradient(to right, #fff, #a0a0b0);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }

                .stat-label {
                    color: #a0a0b0;
                    font-size: 0.9rem;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
            </style>
        </section>

        <!-- ================= CTA ================= -->
        <section class="cta section alt">
            <div class="container">
                <h2 class="section-title">Let's Build Something Meaningful</h2>
                <p>
                    Always open to discussing new business ideas, tech collaborations, or
                    innovative ways to solve global problems.
                </p>
                <div style="display: flex; gap: 20px; justify-content: center; margin-top: 30px;">
                    <a href="contact.php" class="btn primary">Start a Conversation</a>
                    <a href="services.php" class="btn secondary">Work With Me</a>
                </div>
            </div>
        </section>

    </main>

    <?php
    if (file_exists("includes/footer.php")) {
        include "includes/footer.php";
    }
    ?>

    <!-- JS -->
    <script>
        window.portfolioRoles = <?= json_encode(array_map('trim', explode(',', $hp['portfolio_hero_roles'] ?? "Web Designer, Full Stack Developer, Thinker, Innovator"))) ?>;
    </script>
    <script src="assets/js/main.js"></script>

</body>

</html>