<?php
// intro.php - Entry Portal
session_start();

// Set flag so we don't loop back here
$_SESSION['intro_seen'] = true;

// Auto-redirect after animation (e.g., 4.5 seconds)
header("Refresh: 4.5; url=Index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SagarVerse</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #050714;
            --primary: #8e3fd7;
            --secondary: #b48cff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: 'Outfit', sans-serif;
            color: #fff;
        }

        .intro-container {
            text-align: center;
            position: relative;
        }

        /* Cinematic Logo Animation */
        .logo-box {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
            animation: logoFloat 6s ease-in-out infinite;
        }

        .logo-circle {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 4px solid var(--primary);
            box-shadow: 0 0 50px var(--primary);
            animation: pulse 3s infinite alternate;
        }

        .logo-text {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            z-index: 2;
        }

        .brand-name {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 5px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 2s forwards 1s;
        }

        .tagline {
            font-size: 1rem;
            color: var(--secondary);
            margin-top: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0;
            animation: fadeInUp 2s forwards 2.5s;
        }

        /* Particles / Glow background */
        .glow-bg {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(142, 63, 215, 0.15), transparent 70%);
            z-index: -1;
            filter: blur(50px);
            animation: glowMove 10s infinite alternate;
        }

        /* Progress Bar */
        .progress-container {
            position: fixed;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 4px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            animation: loading 15s linear forwards;
        }

        .skip-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
            padding: 8px 20px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: 0.3s;
            text-decoration: none;
        }

        .skip-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: #fff;
        }

        /* Animations */
        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 20px var(--primary);
            }

            100% {
                transform: scale(1.1);
                box-shadow: 0 0 60px var(--primary);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes loading {
            to {
                width: 100%;
            }
        }

        @keyframes glowMove {
            0% {
                transform: translate(-50px, -50px);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Fade Out Effect */
        .fade-out {
            animation: fadeOut 1.5s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                pointer-events: none;
            }
        }
    </style>
</head>

<body>

    <div class="glow-bg"></div>

    <div class="intro-container" id="introUI">
        <div class="logo-box">
            <div class="logo-circle"></div>
            <div class="logo-text">S</div>
        </div>

        <h1 class="brand-name">SAGARVERSE</h1>
        <p class="tagline">Code • Create • Innovate</p>
    </div>

    <div class="progress-container">
        <div class="progress-bar"></div>
    </div>

    <a href="index.php" class="skip-btn">Skip Intro</a>

    <script>
        // Redirect after 15 seconds
        const DURATION = 15000; // 15 Seconds

        setTimeout(() => {
            const ui = document.getElementById('introUI');
            ui.classList.add('fade-out');

            setTimeout(() => {
                window.location.href = 'index.php';
            }, 1000);
        }, DURATION);
    </script>
</body>

</html>