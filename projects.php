<?php
// projects.php
if (session_status() === PHP_SESSION_NONE)
  session_start();
require_once "config/db.php";

// 🔒 STRICT AUTH CHECK
if (!isset($_SESSION['auth'])) {
  header("Location: auth/login.php?redirect=projects.php");
  exit();
}

// Fetch Strictly Projects
$projects = $conn->query("SELECT * FROM projects WHERE category='Project' ORDER BY sort_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>SagarVerse — Projects</title>
  <meta name="description"
    content="Explore the innovative projects built by SagarVerse. AI systems, web applications, and cutting-edge tech solutions.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Reusing existing styles */
    .projects-section {
      padding: 90px 0;
      width: 90%;
      margin: auto;
      text-align: center;
    }

    .projects-section h1 {
      margin-bottom: 45px;
    }

    .projects-wrapper {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 36px;
    }

    .project-card {
      background: linear-gradient(180deg, #0b1020, #050714);
      border: 1.5px solid rgba(142, 63, 215, .35);
      border-radius: 18px;
      overflow: hidden;
      transition: .35s;
      text-align: left;
      position: relative;
    }

    .project-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 50px rgba(142, 63, 215, .55);
    }

    .project-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      filter: brightness(.95);
    }

    .card-body {
      padding: 16px 18px;
    }

    .card-body h3 {
      font-size: 1.05rem;
      color: #fff;
      margin-bottom: 6px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .card-body p {
      font-size: .86rem;
      color: #d7d4ff;
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .card-footer {
      padding: 12px 18px 16px;
      border-top: 1px solid rgba(255, 255, 255, .08);
      display: flex;
      justify-content: flex-end;
    }

    .read-more {
      font-size: .85rem;
      font-weight: 500;
      color: #b48cff;
      text-decoration: none;
      transition: .3s;
    }

    .read-more:hover {
      color: #e0d7ff;
      text-decoration: underline;
    }

    .no-items {
      opacity: .6;
      margin-top: 30px;
    }

    @media(max-width:1024px) {
      .projects-wrapper {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media(max-width:600px) {
      .projects-wrapper {
        grid-template-columns: 1fr;
      }

      .projects-section {
        padding: 60px 0;
      }
    }
  </style>
</head>

<body>

  <?php include "includes/header.php"; ?>

  <section class="projects-section">
    <h1 class="purple">My Projects</h1>

    <div class="projects-wrapper">
      <?php if ($projects && $projects->num_rows > 0): ?>
        <?php while ($row = $projects->fetch_assoc()): ?>
          <div class="project-card">
            <img src="uploads/projects/<?= htmlspecialchars($row['image']) ?>" alt="">
            <div class="card-body">
              <h3><?= htmlspecialchars($row['title']) ?></h3>
              <p><?= htmlspecialchars($row['description']) ?></p>
            </div>
            <div class="card-footer">
              <a href="<?= htmlspecialchars($row['document_link']) ?>" target="_blank" class="read-more">View Project →</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="no-items">🚫 No Projects Found</p>
      <?php endif; ?>
    </div>
  </section>

  <?php include "includes/footer.php"; ?>

</body>

</html>