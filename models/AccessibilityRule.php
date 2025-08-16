<?php
require_once __DIR__ . '/UIComponent.php';

class AccessibilityRule {
    public string $ruleId;
    public string $description;
    public string $wcagReference;
    public string $severity;
    public array $appliesTo;

    public function __construct(string $ruleId, string $description, string $wcagReference, string $severity) {
        $this->ruleId = $ruleId;
        $this->description = $description;
        $this->wcagReference = $wcagReference;
        $this->severity = $severity;
        $this->appliesTo = [];
    }

    public function isCompliant(UIComponent $component): bool {
        switch ($this->ruleId) {
            case 'WCAG-1.1.1':
                return $component->hasAltText;
            case 'WCAG-1.4.3':
                return $component->highContrastMode;
            case 'WCAG-1.2.1':
                return $component->textToSpeechEnabled;
            case 'WCAG-4.1.2':
                return $component->supportsScreenReader;
            default:
                return true;
        }
    }

   public function applyRule(UIComponent $component, TranslationService $translator): string {
    // Translate the component label first
    $translatedLabel = $translator->t($component->label);

    if (!$this->isCompliant($component)) {
        $status = $translator->t("violates", "violates");
        $violationMsg = $this->getViolationMessage($translator);
        return "❌ {$component->type} {$translatedLabel} {$status} {$this->wcagReference} ($violationMsg)";
    }

    $status = $translator->t("complies with", "complies with");
    return "✅ {$component->type} {$translatedLabel} {$status} {$this->wcagReference}";
}




    private function getViolationMessage(TranslationService $translator): string {
    switch ($this->ruleId) {
        case 'WCAG-1.4.3':
            return $translator->t('violation.contrast', 'Contrast violation');
        case 'WCAG-1.2.1':
            return $translator->t('violation.audioAlt', 'Audio alternative required');
        default:
            // Use description as key, fallback to description itself if not found
            return $translator->t($this->description ?? '', $this->description ?? 'Unknown violation');
    }
}


    public function getDescription(): string {
        return $this->description;
    }

    private function validateRuleData(): bool {
        return !empty($this->ruleId) && !empty($this->wcagReference);
    }
}