<?php
require_once __DIR__ . '/../models/AccessibilityModel.php';
require_once __DIR__ . '/../models/UIComponent.php';
require_once __DIR__ . '/../models/ScreenReaderConfig.php';
require_once __DIR__ . '/../models/LanguageModel.php';
require_once __DIR__ . '/../models/TranslationService.php';

// 1. Get language from request (default: English)
$selectedLang = $_GET['lang'] ?? 'en';

// 2. Initialize translator singleton
$translator = TranslationService::getInstance($selectedLang);

// 3. Create components with TRANSLATION KEYS (not pre-translated)
$components = [
    new UIComponent("btn1", "button", "label.submit", true, true, true, true, true),
    new UIComponent("lbl1", "label", "label.username", true, true, false, false, false)
];

// 4. Configure screen reader with language support
$languages = [
    new LanguageModel("en", "English", $selectedLang === 'en', "en-US-Wavenet-A"),
    new LanguageModel("fr", "French", $selectedLang === 'fr', "fr-FR-Wavenet-B"),
    new LanguageModel("es", "Spanish", $selectedLang === 'es', "es-ES-Wavenet-C")
];
$screenReader = new ScreenReaderConfig("NVDA", true, 1.0, 1.0, $languages);

// 5. Build model (pass translator for dynamic translations)
$model = new AccessibilityModel(
    "model1", 
    "tool.title",  // Translation key for title
    "AA", 
    true, 
    $screenReader, 
    $translator
);

// 6. Add components and generate UI
foreach ($components as $component) {
    $model->addComponent($component);
}
$model->generateUI();