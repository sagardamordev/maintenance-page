# 🌌 SagarVerse — Project Documentation

Welcome to the official documentation for **SagarVerse**, a premium personal software ecosystem designed for tech leaders, developers, and AI enthusiasts.

---

## 🚀 Project Overview
**SagarVerse** is a dynamic, high-performance web platform built to showcase professional expertise, manage digital assets, and track community engagement. It integrates a state-of-the-art frontend with a powerful, granular Admin Panel.

### **Core Modules:**
- **Portfolio Management:** Dynamic hero section, technical skills, and featured works.
- **Service Catalog:** Curated professional offerings with pricing and category management.
- **Digital Store:** Template and asset download hub.
- **Editorial Hub:** Tech blog and article management.
- **Visitor Analytics:** Real-time traffic monitoring and live stat tracking.
- **User Ecosystem:** Multi-role authentication (User, Student, Admin).

---

## 🛠 Tech Stack
- **Backend:** PHP 8.x (Core)
- **Database:** MySQL (Relational)
- **Frontend Logic:** JavaScript (ES6+), Typed.js (Text Animations), Chart.js (Analytics).
- **Styling:** Vanilla CSS3 (Custom Design System with Glassmorphism).
- **Communication:** SweetAlert2 (Popups), PHPMailer (Notifications).

---

## 📂 Architecture & Directory Structure
```text
SagarVerse/
├── admin/               # Administrative Control Panel
├── auth/                # Authentication Logic (Login/Signup/Logout)
├── assets/              # Static CSS, JS, and UI Images
├── config/              # Database & Mailer Configurations
├── includes/            # Reusable Components (Header, Footer, Counters)
├── uploads/             # User-uploaded Content (Resumes, Projects, etc.)
├── user/                # User/Student Profile Management
└── Index.php            # Platform Gateway (Dynamic Home)
```

---

## ⚙️ Administrative Features

### **1. Real-Time Analytics**
The Admin Dashboard provides an instant view of:
- **Live Visitors:** Total unique people who visited the site.
- **Page Views:** Total number of page loads across the platform.
- **User Growth:** Monthly sign-up trends visualized via interactive charts.

### **2. Security & Global Settings**
Managed via `admin/settings.php`:
- **Maintenance Mode:** Lock the site for updates with a single switch.
- **User Registration:** Toggle public sign-ups on or off.
- **Social Integration:** Update Instagram, LinkedIn, and GitHub links globally.
- **Resume Management:** Upload, update, or delete your professional CV instantly.

### **3. Dynamic Portfolio Controller**
Managed via `admin/portfolio_edit.php`:
- **Hero Customization:** Edit your greeting, roles, and bio.
- **Skills Matrix:** Manage technical tags using a simple comma-separated list.
- **Experience Builder:** Add "Selected Works" cards with custom thumbnails and descriptions.

---

## 📖 User Manual (Admin)

### **How to Update Your Resume**
1. Log in to the Admin Panel.
2. Navigate to **Settings** in the sidebar.
3. Locate the **Personal Assets (Resume)** section.
4. Upload a new PDF/DOCX file. 
5. The "Download Resume" button on the frontend will update automatically.

### **How to Add a New Project**
1. Navigate to **Projects** in the sidebar.
2. Click **Launch New Project**.
3. Fill in the Title, Description, and Link.
4. Upload a high-resolution landscape cover image.
5. Click **Deploy Project** to publish it live.

### **How to Customise the Typing Animation**
1. Navigate to **Portfolio** in the sidebar.
2. Under **Hero Section**, look for **Roles**.
3. Enter roles separated by commas (e.g., `Developer, Leader, Visionary`).
4. Click **Save** to update the effect on the Home and Portfolio pages.

---

## 🔒 Security Practices
- **Session Protection:** Admin routes are guarded by strict session validation.
- **Input Sanitization:** All user-submitted data is sanitized to prevent SQL injection and XSS.
- **Asset Privacy:** Sensitive downloads are protected via the `protected` class and login requirements.

---

## 🧪 Installation & Support
1. **Database:** Import the provided SQL dump and configure `config/db.php`.
2. **Uploads:** Ensure `uploads/` and its subdirectories have `0777` write permissions.
3. **Mailer:** Update SMTP credentials in `config/mailer.php` for contact form functionality.

---
*Developed by DeepMind Agentic Assistant for SagarVerse.*
