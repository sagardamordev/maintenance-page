<?php
// ================= SESSION =================
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Auth state (future use / JS safe)
$isLoggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Why SagarVerse? — Learn Software the Right Way</title>
  <meta name="description"
    content="SagarVerse is a personal software platform by Sagar, focused on real-world projects, transparent services, and practical software development.">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/CSS/about.css">

  <style>
    /* ================= FUTURE COLLABORATOR – PREMIUM EFFECT ================= */
    .future-card {
      position: relative;
      text-align: center;
      padding: 2.4rem;
      border-radius: 18px;
      background: linear-gradient(145deg, #0b1020, #050714);
      border: 1px solid rgba(99, 102, 241, .35);
      max-width: 360px;
      overflow: hidden;
      animation: futureFloat 6s ease-in-out infinite;
    }

    .future-card::before {
      content: "";
      position: absolute;
      inset: 0;
      padding: 2px;
      border-radius: 18px;
      background: linear-gradient(120deg,
          transparent,
          rgba(99, 102, 241, .9),
          transparent);
      -webkit-mask:
        linear-gradient(#000 0 0) content-box,
        linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      animation: futureShimmer 7s linear infinite;
    }

    .future-card h3 {
      color: #c7d2fe;
      font-weight: 700;
      font-size: 1.35rem;
    }

    .future-card .role {
      color: #a5b4fc;
      margin-top: 6px;
      font-weight: 500;
    }

    .future-card p {
      color: #cbd5f5;
      font-size: .95rem;
      margin: 14px 0;
    }

    .future-card .muted {
      color: #94a3b8;
      font-size: .85rem;
      letter-spacing: .4px;
    }

    .future-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 25px 70px rgba(99, 102, 241, .35);
    }

    @keyframes futureShimmer {
      from {
        transform: translateX(-100%);
      }

      to {
        transform: translateX(100%);
      }
    }

    @keyframes futureFloat {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-6px);
      }
    }
  </style>
</head>

<body>

  <!-- ================= HEADER ================= -->
  <?php include __DIR__ . "/includes/header.php"; ?>

  <main>

    <!-- HERO -->
    <section class="about-hero">
      <h1>Why <span>SagarVerse</span>?</h1>
      <p>
        Software should be built with patience, clarity,
        and responsibility — not shortcuts or noise.
      </p>
    </section>

    <!-- STORY -->
    <section class="about-section fade-up">
      <h2>The Story</h2>
      <p>
        SagarVerse is a personal software platform — not an institute,
        not a coaching brand, and not a content marketplace.
      </p>
      <p>
        It began as a place to document real learning,
        real mistakes, and real solutions while building software.
      </p>
      <p>
        I am <strong>not a teacher</strong>.
        I’m a software developer focused on building systems that work,
        maintaining them responsibly, and improving them continuously.
      </p>
    </section>

    <!-- FOUNDER MINDSET -->
    <section class="about-section fade-up">
      <h2>Founder Mindset</h2>
      <p>
        Software is a long-term responsibility.
        Writing code is easy — maintaining it, securing it,
        and supporting real users is the real work.
      </p>
      <ul class="who-list">
        <li>Stability over speed</li>
        <li>Clarity over hype</li>
        <li>Responsibility over shortcuts</li>
        <li>Learning through execution</li>
      </ul>
    </section>

    <!-- TEAM -->
    <section class="about-section fade-up">
      <h2>People Behind SagarVerse</h2>

      <div class="team-grid">

        <div class="founder-card fade-up">
          <h3>Sagar</h3>
          <p class="role">Founder • Software Developer</p>
          <p>
            Responsible for system architecture,
            development, services, security,
            and long-term platform maintenance.
          </p>
          <?php
          if (!isset($settings)) {
            $sRes = $conn->query("SELECT * FROM system_settings");
            while ($r = $sRes->fetch_assoc())
              $settings[$r['setting_key']] = $r['setting_value'];
          }
          $portfolioLink = !empty($settings['portfolio']) ? $settings['portfolio'] : 'Protfolio/Protfolio.php';
          ?>
          <a href="<?= htmlspecialchars($portfolioLink) ?>">View Profile & Skills</a><br>
          <a href="contact.php">Contact</a>
        </div>

        <div class="future-card fade-up">
          <h3>Future Collaborator</h3>
          <p class="role">Designer • Developer • Writer</p>
          <p>
            Reserved for trusted collaborators
            when project scale and alignment require it.
          </p>
          <span class="muted">Invitation only</span>
        </div>

      </div>
    </section>

    <!-- TRUST -->
    <section class="about-section fade-up">
      <h2>Trust & Responsibility</h2>
      <p>
        Software impacts real people and real businesses.
        This platform prioritizes ethical development,
        clear ownership, and responsible maintenance.
      </p>
    </section>

    <!-- PRIVACY -->
    <section class="about-section fade-up">
      <h2>Privacy & Data Responsibility</h2>
      <p>
        User privacy and data safety are treated seriously on SagarVerse.
        Personal information is never sold, misused,
        or accessed beyond its intended purpose.
      </p>
      <p>
        When services involve data handling,
        access is limited, documented, and handled responsibly.
        Security is a responsibility — not an afterthought.
      </p>
    </section>

    <!-- CORE STATEMENT -->
    <section class="about-info fade-up">
      <h2>What This Platform Stands For</h2>
      <p>
        SagarVerse exists to build reliable software,
        share practical understanding,
        and grow through consistent, responsible work —
        not hype-driven promises.
      </p>
    </section>

  </main>

  <!-- ================= FOOTER ================= -->
  <?php include __DIR__ . "/includes/footer.php"; ?>

  <script>
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    }, { threshold: 0.2 });

    document.querySelectorAll(".fade-up").forEach(el => observer.observe(el));
  </script>

</body>

</html>