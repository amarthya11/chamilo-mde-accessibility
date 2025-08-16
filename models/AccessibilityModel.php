<?php
require_once __DIR__ . '/UIComponent.php';
require_once __DIR__ . '/AccessibilityRule.php';
require_once __DIR__ . '/LanguageModel.php';
require_once __DIR__ . '/ScreenReaderConfig.php';
require_once __DIR__ . '/TranslationService.php';

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}


class AccessibilityModel {
    public string $id;
    public string $title;
    public string $wcagLevel;
    public bool $languageSupport;
    /** @var UIComponent[] */
    public array $components;
    /** @var AccessibilityRule[] */
    public array $rules;
    public ScreenReaderConfig $screenReaderConfig;
    private TranslationService $translator;

    public function __construct(
        string $id,
        string $title,
        string $wcagLevel,
        bool $languageSupport,
        ScreenReaderConfig $screenReaderConfig,
        TranslationService $translator
    ) {
        $this->id = $id;
        //$this->title = $title;
        $this->title = $translator->t($title, $title); // translate using key
        $this->wcagLevel = $wcagLevel;
        $this->languageSupport = $languageSupport;
        $this->components = [];
        $this->translator = $translator;
        $this->rules = $this->loadDefaultRules();
        $this->screenReaderConfig = $screenReaderConfig;
    }

    private function loadDefaultRules(): array {
        return [
            new AccessibilityRule("WCAG-1.1.1", $this->translator->t("rule.altText"), "1.1.1", "High"),
            new AccessibilityRule("WCAG-1.4.3", $this->translator->t("rule.contrast"), "1.4.3", "Medium"),
            new AccessibilityRule("WCAG-1.2.1", $this->translator->t("rule.audioAlt"), "1.2.1", "Medium"),
            new AccessibilityRule("WCAG-4.1.2", $this->translator->t("rule.screenReader"), "4.1.2", "High")
        ];
    }

    public function addComponent(UIComponent $component): void {
        $this->components[] = $component;
    }

    public function validateModel(): bool {
        return !empty($this->id) && !empty($this->title) && !empty($this->wcagLevel);
    }

    public function generateUI(): void {
    if (!$this->validateModel()) {
        echo "<div class='alert alert-danger'>❌ " . $this->translator->t("error.invalidModel") . "</div>";
        return;
    }

    echo "<div class='alert alert-success fw-bold'>✅ " . $this->translator->t("ui.generated") . "</div>";

    $totalChecks = $totalPasses = $totalFails = 0;

    foreach ($this->components as $component) {
        // Render the component with the translator passed in
        echo "<div class='card shadow-sm mb-4'>";
        echo "<div class='card-body'>";
        echo $component->renderHTML($this->translator);

        // Render feature list
        echo "<ul class='list-group list-group-flush mt-3'>";
        echo $this->renderFeature($this->translator->t("feature.altText"), $component->hasAltText);
        echo $this->renderFeature($this->translator->t("feature.screenReader"), $component->supportsScreenReader);
        echo $this->renderFeature($this->translator->t("feature.tts"), $component->textToSpeechEnabled);
        echo $this->renderFeature($this->translator->t("feature.highContrast"), $component->highContrastMode);
        echo $this->renderFeature($this->translator->t("feature.resizableText"), $component->resizableText);
        echo "</ul>";

        // Apply rules with translated labels
        echo "<div class='mt-3'>";
        foreach ($this->rules as $rule) {
            $result = $rule->applyRule($component, $this->translator);
            $totalChecks++;
            $isPass = str_starts_with($result, "✅");
            $isPass ? $totalPasses++ : $totalFails++;
            $class = $isPass ? 'text-success' : 'text-danger';
            echo "<p class='{$class} mb-1'>{$result}</p>";
        }
        echo "</div></div></div>";
    }

    // Screen reader config
    echo "<div class='card bg-light mb-3'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title fw-semibold'>🎧 " . $this->translator->t("config.screenReader") . "</h5>";
    echo "<p class='card-text'>";
    $this->screenReaderConfig->applySettings();
    $this->screenReaderConfig->testVoice();
    echo "</p></div></div>";

    // Summary
    echo "<div class='card bg-white border-info mb-3'>";
    echo "<div class='card-header bg-info text-white fw-bold'>📊 " . $this->translator->t("summary.title") . "</div>";
    echo "<div class='card-body'>";
    echo "<p class='card-text mb-1'>" . $this->translator->t("summary.total") . ": <strong>{$totalChecks}</strong></p>";
    echo "<p class='card-text text-success mb-1'>✅ " . $this->translator->t("summary.passed") . ": <strong>{$totalPasses}</strong></p>";
    echo "<p class='card-text text-danger'>❌ " . $this->translator->t("summary.failed") . ": <strong>{$totalFails}</strong></p>";
    echo "</div></div>";
}



    private function renderFeature(string $label, bool $value): string {
        $icon = $value ? '✔️' : '❌';
        return "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    {$label}
                    <span class='" . ($value ? 'text-success' : 'text-danger') . "'>{$icon} " . ($value ? $this->translator->t("Yes") : $this->translator->t("No")) . "</span>
                </li>";
    }

    private function generateId(): string {
        return uniqid('access_');
    }
}