<?php

class UIComponent {
    public string $id;
    public string $type;
    public string $label;
    public bool $hasAltText;
    public bool $supportsScreenReader;
    public bool $textToSpeechEnabled;
    public bool $highContrastMode;
    public bool $resizableText;

    public function __construct(
        string $id,
        string $type,
        string $label,
        bool $hasAltText,
        bool $supportsScreenReader,
        bool $textToSpeechEnabled,
        bool $highContrastMode,
        bool $resizableText
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->label = $label;
        $this->hasAltText = $hasAltText;
        $this->supportsScreenReader = $supportsScreenReader;
        $this->textToSpeechEnabled = $textToSpeechEnabled;
        $this->highContrastMode = $highContrastMode;
        $this->resizableText = $resizableText;
    }

    public function renderHTML(TranslationService $translator): string {
    // Translate the label using the translator and escape HTML
    $translatedLabel = htmlspecialchars($translator->t($this->label), ENT_QUOTES, 'UTF-8');

    switch ($this->type) {
        case "button":
            return "<button class='btn btn-primary'>{$translatedLabel}</button>";

        case "label":
            return "<label>{$translatedLabel}</label>";

        case "input":
            return "<input type='text' placeholder='{$translatedLabel}' class='form-control' />";

        case "textarea":
            return "<textarea placeholder='{$translatedLabel}' class='form-control'></textarea>";

        case "select":
            $optionsHtml = "";
            if (!empty($this->options) && is_array($this->options)) {
                foreach ($this->options as $optKey => $optLabel) {
                    // Translate label, but keep key for form value
                    $translatedOption = htmlspecialchars($translator->t($optLabel), ENT_QUOTES, 'UTF-8');
                    $value = htmlspecialchars($optKey, ENT_QUOTES, 'UTF-8');
                    $optionsHtml .= "<option value='{$value}'>{$translatedOption}</option>";
                }
            }
            return "<select class='form-select'>{$optionsHtml}</select>";

        default:
            return "<span>{$translatedLabel}</span>";
    }
}



}
