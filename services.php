<?php
// services.php
if (session_status() === PHP_SESSION_NONE)
  session_start();
require_once "config/db.php";

// 🔒 STRICT AUTH CHECK
if (!isset($_SESSION['auth'])) {
  header("Location: auth/login.php?redirect=services.php");
  exit();
}

// Fetch Services ONLY
$services = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>SagarVerse — Services</title>
  <meta name="description"
    content="Professional web development, AI engineering, and design services offered by SagarVerse. Tailored solutions for your business.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/CSS/index.css">
  <style>
    /* Service Specific Styles */
    .services-section {
      padding: 80px 0;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .services-wrapper {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
      margin-top: 40px;
      padding: 0 20px;
    }

    .service-box {
      background: #1a1a2e;
      border: 1px solid #16213e;
      border-radius: 12px;
      overflow: hidden;
      transition: 0.3s;
      text-align: left;
    }

    .service-box:hover {
      transform: translateY(-5px);
      border-color: #8e3fd7;
      box-shadow: 0 10px 20px rgba(142, 63, 215, 0.2);
    }

    .service-box img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .service-content {
      padding: 20px;
    }

    .service-content h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #fff;
    }

    .service-content p {
      font-size: 0.9rem;
      color: #a0a0b0;
      line-height: 1.5;
      margin-bottom: 15px;
    }

    .service-price {
      font-size: 1.1rem;
      color: #f1c40f;
      font-weight: bold;
      margin-bottom: 15px;
      display: block;
    }

    .book-btn {
      display: inline-block;
      width: 100%;
      background: transparent;
      border: 1px solid #8e3fd7;
      color: #fff;
      padding: 8px 0;
      text-align: center;
      border-radius: 6px;
      text-decoration: none;
      transition: 0.3s;
    }

    .book-btn:hover {
      background: #8e3fd7;
    }
  </style>
</head>

<body>

  <?php include "includes/header.php"; ?>

  <section class="services-section">
    <h1 class="purple">Professional Services</h1>
    <p style="color:#aaa;">Premium services tailored to your needs.</p>

    <div class="services-wrapper">
      <?php if ($services && $services->num_rows > 0): ?>
        <?php while ($row = $services->fetch_assoc()): ?>
          <div class="service-box">
            <img src="uploads/services/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <div class="service-content">
              <h3><?= htmlspecialchars($row['title']) ?></h3>
              <p><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>
              <span class="service-price">₹<?= number_format($row['price']) ?></span>
              <a href="contact.php?service=<?= urlencode($row['title']) ?>" class="book-btn">Book Now</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="grid-column: 1/-1;">No services currently available. Check back soon!</p>
      <?php endif; ?>
    </div>
  </section>

  <?php include "includes/footer.php"; ?>

</body>

</html>