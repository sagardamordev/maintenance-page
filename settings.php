<?php
/* ================= DEPENDENCIES ================= */
require_once "config/db.php";

/* ================= SESSION ================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ================= AUTH ================= */
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

/* ================= HANDLE POST ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
        $current_pass = $_POST['current_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];

        if ($new_pass !== $confirm_pass) {
            $error_msg = "New passwords do not match!";
        } elseif (strlen($new_pass) < 6) {
            $error_msg = "Password must be at least 6 characters.";
        } else {
            // Verify current password
            $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($hash);
            $stmt->fetch();
            $stmt->close();

            if (password_verify($current_pass, $hash)) {
                $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $update->bind_param("si", $new_hash, $user_id);
                if ($update->execute()) {
                    $success_msg = "Password changed successfully!";
                } else {
                    $error_msg = "Database error. Please try again.";
                }
                $update->close();
            } else {
                $error_msg = "Current password is incorrect.";
            }
        }
    }
}

/* ================= FETCH USER DATA ================= */
$stmt = $conn->prepare("SELECT email, email_verified FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $email_verified);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | SagarVerse</title>

    <link rel="stylesheet" href="assets/CSS/index.css">
    <link rel="stylesheet" href="user/user-panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .settings-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }

        .settings-section {
            margin-bottom: 50px;
        }

        .settings-section h3 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--primary-light);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .settings-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 24px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-info h4 {
            margin: 0;
            font-size: 1.1rem;
        }

        .item-info p {
            margin: 5px 0 0;
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        .danger-card {
            border: 1px solid rgba(255, 107, 107, 0.2);
            background: rgba(255, 107, 107, 0.05);
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">

        <div class="settings-container">
            <h1 class="gradient-text" style="margin-bottom: 40px;">Account Settings</h1>

            <?php if ($success_msg): ?>
                <script>Swal.fire("Success", "<?= $success_msg ?>", "success");</script>
            <?php endif; ?>
            <?php if ($error_msg): ?>
                <script>Swal.fire("Error", "<?= $error_msg ?>", "error");</script>
            <?php endif; ?>

            <!-- SECURITY SECTION -->
            <section class="settings-section">
                <h3><i class="fa-solid fa-shield-halved"></i> Security & Privacy</h3>

                <div class="settings-item">
                    <div class="item-info">
                        <h4>Email Address</h4>
                        <p><?= htmlspecialchars($email) ?> • <?= $email_verified ? 'Verified' : 'Unverified' ?></p>
                    </div>
                </div>

                <div class="settings-item">
                    <div class="item-info">
                        <h4>Password</h4>
                        <p>Change your account password securely</p>
                    </div>
                    <button class="btn primary" onclick="showPassModal()">Change</button>
                </div>
            </section>

            <!-- PREFERENCES SECTION -->
            <section class="settings-section">
                <h3><i class="fa-solid fa-sliders"></i> Preferences</h3>

                <div class="settings-item">
                    <div class="item-info">
                        <h4>Email Notifications</h4>
                        <p>Receive updates about your activity</p>
                    </div>
                    <div class="status online">Always Active</div>
                </div>

                <div class="settings-item">
                    <div class="item-info">
                        <h4>Two-Factor Authentication</h4>
                        <p>Add an extra layer of security (Coming Soon)</p>
                    </div>
                    <div class="status offline">Available Soon</div>
                </div>
            </section>

            <!-- DANGER ZONE -->
            <section class="settings-section">
                <h3 style="color: #ff6b6b;"><i class="fa-solid fa-triangle-exclamation"></i> Danger Zone</h3>
                <div class="settings-item danger-card">
                    <div class="item-info">
                        <h4>Deactivate Account</h4>
                        <p>Permanently remove your account and all data</p>
                    </div>
                    <button class="btn danger" style="background: #ff6b6b; padding: 10px 20px; box-shadow: none;"
                        onclick="confirmDeactivate()">Deactivate</button>
                </div>
            </section>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- PASSWORD MODAL -->
    <script>
        async function showPassModal() {
            const { value: formValues } = await Swal.fire({
                title: 'Change Password',
                background: '#0d1130',
                color: '#fff',
                html:
                    '<input id="swal-input1" class="swal2-input" type="password" placeholder="Current Password">' +
                    '<input id="swal-input2" class="swal2-input" type="password" placeholder="New Password">' +
                    '<input id="swal-input3" class="swal2-input" type="password" placeholder="Confirm New Password">',
                focusConfirm: false,
                confirmButtonText: 'Update Password',
                confirmButtonColor: '#8e3fd7',
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('swal-input3').value
                    ]
                }
            });

            if (formValues) {
                const form = document.createElement('form');
                form.method = 'POST';

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'change_password';
                form.appendChild(actionInput);

                const currPass = document.createElement('input');
                currPass.type = 'hidden';
                currPass.name = 'current_password';
                currPass.value = formValues[0];
                form.appendChild(currPass);

                const newPass = document.createElement('input');
                newPass.type = 'hidden';
                newPass.name = 'new_password';
                newPass.value = formValues[1];
                form.appendChild(newPass);

                const confPass = document.createElement('input');
                confPass.type = 'hidden';
                confPass.name = 'confirm_password';
                confPass.value = formValues[2];
                form.appendChild(confPass);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function confirmDeactivate() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#8e3fd7',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Restricted', 'For security reasons, please contact admin to delete account.', 'info');
                }
            })
        }
    </script>
</body>

</html>