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
    <style>
        body {
            padding: 40px;
            background-color: #f0f2f5;
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
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .footer-note {
            font-style: italic;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center section-title"><?= htmlspecialchars($translator->t("tool.title")) ?></h2>

    <!-- Language Switcher -->
    <form method="get" class="mb-4">
        <label for="lang" class="form-label fw-bold"><?= htmlspecialchars($translator->t("label.language")) ?></label>
        <select name="lang" id="lang" class="form-select w-25" onchange="this.form.submit()">
            <option value="en" <?= $selectedLang === 'en' ? 'selected' : '' ?>>English</option>
            <option value="fr" <?= $selectedLang === 'fr' ? 'selected' : '' ?>>French</option>
            <option value="es" <?= $selectedLang === 'es' ? 'selected' : '' ?>>Spanish</option>
        </select>
    </form>

    <div class="access-box">
        <?php include __DIR__ . '/controller/AccessibilityController.php'; ?>
    </div>

    <footer class="text-center mt-4">
        <p class="footer-note"><?= htmlspecialchars($translator->t("footer.note")) ?></p>
    </footer>
</div>
</body>
</html>
