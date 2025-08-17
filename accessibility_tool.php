<?php
// Always load all required model classes before instantiating anything
require_once __DIR__ . '/models/TranslationService.php';

// Get selected language from query string (default to English)
$selectedLang = $_GET['lang'] ?? 'en';

// Create translator instance AFTER loading the class
echo "<small class='text-primary'>🌐 Selected language: $selectedLang</small><br/>";

$translator = TranslationService::getInstance($selectedLang);
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($selectedLang) ?>">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($translator->t("tool.title")) ?> - MDE Prototype</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            padding: 40px;
            background: linear-gradient(135deg, #f0f2f5, #e9ecef);
            transition: all 0.3s ease-in-out;
        }

        .section-title {
            margin-bottom: 25px;
            font-weight: 600;
            color: #0d6efd;
        }

        .access-box {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease-in-out;
        }

        .component-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .footer-note {
            font-style: italic;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* High contrast mode */
        .high-contrast {
            background-color: #000 !important;
            color: #fff !important;
        }
        .high-contrast a {
            color: #ffff00 !important;
        }
        .high-contrast .access-box {
            background-color: #000 !important;
            border-color: #fff !important;
        }

        .btn-sm {
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-sm:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Title -->
    <h2 class="text-center section-title">
        <i class="bi bi-check2-circle"></i> <?= htmlspecialchars($translator->t("tool.title")) ?>
    </h2>

    <!-- Language Switcher -->
    <form method="get" class="mb-4">
        <label for="lang" class="form-label fw-bold"><?= htmlspecialchars($translator->t("label.language")) ?></label>
        <select name="lang" id="lang" class="form-select w-25" onchange="this.form.submit()">
            <option value="en" <?= $selectedLang === 'en' ? 'selected' : '' ?>>English</option>
            <option value="fr" <?= $selectedLang === 'fr' ? 'selected' : '' ?>>French</option>
            <option value="es" <?= $selectedLang === 'es' ? 'selected' : '' ?>>Spanish</option>
        </select>
    </form>

    <!-- Accessibility Buttons -->
    <div class="d-flex mb-4">
        <button type="button" class="btn btn-dark btn-sm me-2" id="contrastBtn"><?= htmlspecialchars($translator->t("button.highContrast")) ?></button>
        <button type="button" class="btn btn-info btn-sm me-1" id="fontIncrease"><?= htmlspecialchars($translator->t("button.increaseText")) ?> A+</button>
        <button type="button" class="btn btn-warning btn-sm" id="fontDecrease"><?= htmlspecialchars($translator->t("button.decreaseText")) ?> A-</button>
    </div>

    <!-- Accessibility Results -->
    <div class="access-box">
        <?php 
        // Here your controller generates UI components and WCAG checks
        // Wrap them in Bootstrap cards dynamically
        include __DIR__ . '/controller/AccessibilityController.php'; 
        ?>
    </div>

    <!-- WCAG Summary -->
    <div class="mt-4">
        <h4 class="fw-bold text-secondary"><?= htmlspecialchars($translator->t("summary.title")) ?></h4>
        <div class="card p-3 shadow-sm mb-3">
            <p class="mb-1"><strong><?= htmlspecialchars($translator->t("summary.total")) ?>:</strong> <?= $totalChecks ?? 0 ?></p>
            <p class="mb-1 text-success"><strong>✅ <?= htmlspecialchars($translator->t("summary.passed")) ?>:</strong> <?= $passedChecks ?? 0 ?></p>
            <p class="mb-0 text-danger"><strong>❌ <?= htmlspecialchars($translator->t("summary.failed")) ?>:</strong> <?= $failedChecks ?? 0 ?></p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-4">
        <p class="footer-note">
            <i class="bi bi-info-circle"></i> <?= htmlspecialchars($translator->t("footer.note")) ?>
        </p>
    </footer>
</div>

<script>
    let fontSize = 16; // default font size in px

    document.getElementById('contrastBtn').addEventListener('click', function() {
        document.body.classList.toggle('high-contrast');
    });

    document.getElementById('fontIncrease').addEventListener('click', function() {
        fontSize += 2;
        document.body.style.fontSize = fontSize + 'px';
    });

    document.getElementById('fontDecrease').addEventListener('click', function() {
        fontSize = Math.max(12, fontSize - 2);
        document.body.style.fontSize = fontSize + 'px';
    });
</script>
</body>
</html>
