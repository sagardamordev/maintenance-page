<?php
// ================= SESSION =================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auth state (single source of truth)
$isLoggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — SagarVerse</title>

    <link rel="stylesheet" href="assets/CSS/index.css">
    <link rel="stylesheet" href="assets/CSS/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- 🔐 GLOBAL AUTH FLAG -->
    <script>
        window.isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    </script>

    <style>
        /* EXTRA FEEDBACK UI */
        .feedback-header {
            font-size: 28px;
            font-weight: 700;
            color: #a56bff;
            margin-bottom: 10px;
            display: none;
        }

        .feedback-sub {
            font-size: 15px;
            color: #dfd9ff;
            margin-bottom: 20px;
            display: none;
        }

        .textarea.feedback-mode {
            height: 220px !important;
            border: 1px solid #a56bff;
            box-shadow: 0 0 10px rgba(165, 107, 255, 0.3);
        }

        #submitBtn.feedback-btn {
            background: #a56bff !important;
        }
    </style>
</head>

<body>

    <?php if (isset($_GET['sent'])): ?>
        <script>
            Swal.fire({
                title: "Message Sent! 🎉",
                text: "I’ll reply within 12 hours.",
                icon: "success",
                confirmButtonColor: "#8e3fd7"
            });
        </script>
    <?php endif; ?>

    <!-- ================= HEADER ================= -->
    <?php include __DIR__ . "/includes/header.php"; ?>

    <!-- ================= CONTACT ================= -->
    <section class="contact-section">
        <h1 class="purple main-header">Let’s Work Together</h1>
        <p class="sub-text main-sub">Tell me your idea — I’ll reply within 12 hours ✨</p>

        <h2 class="feedback-header" id="feedbackHeader">Share Your Experience ✨</h2>
        <p class="feedback-sub" id="feedbackSub">Your words help me grow.</p>

        <div class="contact-container">

            <form action="send_contact.php" method="POST" class="contact-form protected">

                <label>How can I help you?</label>
                <select id="purpose-select" name="purpose" class="input-select" required>
                    <option disabled selected>Select</option>
                    <option value="talk">Just Want To Talk 💬</option>
                    <option value="service">Hire My Service 💼</option>
                    <option value="review">Reviews / Feedback ⭐</option>
                </select>

                <label>Your Name</label>
                <input type="text" name="name" class="input-box" required>

                <label>Email</label>
                <input type="email" name="email" class="input-box" required>

                <!-- SERVICE -->
                <div id="service-section">
                    <label>Select Service</label>
                    <select id="service-select" name="service" class="input-select">
                        <option disabled selected>Select</option>
                        <option data-price="1299">Web Designing — ₹1299</option>
                        <option data-price="1499">Portfolio Website — ₹1499</option>
                        <option data-price="799">Graphic Design — ₹799</option>
                    </select>
                    <p id="service-price"></p>
                </div>

                <label>Message</label>
                <textarea id="messageBox" name="message" class="input-box textarea" required></textarea>

                <button type="submit" class="send-btn" id="submitBtn">
                    Send Message <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>


            <!-- CONTACT SIDEBAR -->
            <div class="contact-info reveal" id="sideBox">
                <h3 class="connect-title">Stay Connected</h3>
                <div class="connect-wrapper">
                    <div class="connect-row email"><i class="fa-solid fa-envelope"></i>
                        <span>sagarverses@gmail.com</span>
                    </div>
                    <div class="connect-row insta"><i class="fab fa-instagram"></i> <span>@sagarverses</span></div>
                    <p class="connect-small">Online Connect Me</p>
                    <div class="social-icons-big"> <a href="https://youtube.com/@inosentsagar?si=3qyKwZ7n0swriQ0Q"
                            target="_blank" class="yt"><i class="fab fa-youtube"></i></a> <a
                            href="https://linkedin.com/in/sagar" target="_blank" class="ln"><i
                                class="fab fa-linkedin"></i></a> </div>
                    <p class="connect-quote">“Your voice matters. Let’s build something that lasts.” ✨🚀</p>
                </div>
            </div>

        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <?php include __DIR__ . "/includes/footer.php"; ?>

    <!-- ================= SCRIPT ================= -->
    <script>
        // 🔒 FORM PROTECTION
        document.querySelector(".contact-form").addEventListener("submit", e => {
            if (!window.isLoggedIn) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Login Required 🔐",
                    text: "Please login to continue"
                }).then(() => window.location.href = "auth/login.php");
            }
        });

        // UI logic
        const purpose = document.getElementById("purpose-select");
        const serviceSection = document.getElementById("service-section");
        const priceText = document.getElementById("service-price");
        const messageBox = document.getElementById("messageBox");
        const submitBtn = document.getElementById("submitBtn");
        const feedbackHeader = document.getElementById("feedbackHeader");
        const feedbackSub = document.getElementById("feedbackSub");
        const mainHeader = document.querySelector(".main-header");
        const mainSub = document.querySelector(".main-sub");

        serviceSection.style.display = "none";

        purpose.addEventListener("change", () => {
            if (purpose.value === "review") {
                feedbackHeader.style.display = "block";
                feedbackSub.style.display = "block";
                mainHeader.style.display = "none";
                mainSub.style.display = "none";
                messageBox.classList.add("feedback-mode");
                submitBtn.classList.add("feedback-btn");
                submitBtn.textContent = "Submit Feedback ⭐";
            } else {
                feedbackHeader.style.display = "none";
                feedbackSub.style.display = "none";
                mainHeader.style.display = "block";
                mainSub.style.display = "block";
                messageBox.classList.remove("feedback-mode");
                submitBtn.classList.remove("feedback-btn");
                submitBtn.innerHTML = `Send Message <i class="fa-solid fa-paper-plane"></i>`;
            }
        });

        document.getElementById("service-select").addEventListener("change", e => {
            priceText.textContent = `Service Price: ₹${e.target.selectedOptions[0].dataset.price}`;
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>