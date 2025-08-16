<?php
class TranslationService {
    private static ?TranslationService $instance = null;
    private string $lang;
    private array $translations;
    private array $missingKeys = [];

    private function __construct(string $lang = 'en') {
        $this->lang = $lang;
        $this->translations = self::loadTranslations($lang);
        echo "<small class='text-info'>🔁 Loaded translations for [$lang]: " . count($this->translations) . " entries</small><br/>";
    }

    public static function getInstance(string $lang = 'en'): TranslationService {
        if (self::$instance === null || self::$instance->lang !== $lang) {
            self::$instance = new TranslationService($lang);
        }
        return self::$instance;
    }

    private static function loadTranslations(string $lang): array {
        $allTranslations = [
            'en' => [
                'label.submit' => 'Submit',
                'label.username' => 'Username',
                'label.language' => 'Choose Language:',
                'tool.title' => 'Accessibility Evaluation Tool',
                'footer.note' => "MDE Accessibility Prototype for Master's Dissertation",

                // Features
                'feature.altText' => 'Alt Text',
                'feature.screenReader' => 'Screen Reader',
                'feature.tts' => 'Text-to-Speech',
                'feature.highContrast' => 'High Contrast',
                'feature.resizableText' => 'Resizable Text',

                // Rules
                'rule.altText' => 'Non-text content must have alt text',
                'rule.contrast' => 'Text must have sufficient contrast',
                'rule.audioAlt' => 'Provide text alternatives for audio',
                'rule.screenReader' => 'Ensure screen reader compatibility',

                // Violation Messages
                'violation.contrast' => 'Text must have sufficient contrast',
                'violation.audioAlt' => 'Provide text alternatives for audio',

                // UI Texts
                'ui.generated' => 'UI Components Generated',
                'config.screenReader' => 'Screen Reader Configuration',
                'summary.title' => 'WCAG Compliance Summary',
                'summary.total' => 'Total Checks',
                'summary.passed' => 'Passed',
                'summary.failed' => 'Violations',
                'validation.failed' => 'Model validation failed.',

                // Misc
                'complies with' => 'complies with',
                'violates' => 'violates',
                'Yes' => 'Yes',
                'No' => 'No',
                'Testing voice with speed' => 'Testing voice with speed',
                'and pitch' => 'and pitch'
            ],
            'fr' => [
                'label.submit' => 'Soumettre',
                'label.username' => "Nom d'utilisateur",
                'label.language' => 'Choisir la langue :',
                'tool.title' => "Outil d'évaluation de l'accessibilité",
                'footer.note' => "Prototype d'accessibilité MDE pour mémoire de maîtrise",

                // Features
                'feature.altText' => 'Texte alternatif',
                'feature.screenReader' => 'Lecteur d\'écran',
                'feature.tts' => 'Synthèse vocale',
                'feature.highContrast' => 'Contraste élevé',
                'feature.resizableText' => 'Texte redimensionnable',

                // Rules
                'rule.altText' => 'Le contenu non textuel doit avoir un texte alternatif',
                'rule.contrast' => 'Le texte doit avoir un contraste suffisant',
                'rule.audioAlt' => 'Fournir des alternatives textuelles pour l\'audio',
                'rule.screenReader' => 'Assurer la compatibilité avec les lecteurs d\'écran',

                // Violation Messages
                'violation.contrast' => 'Le texte doit avoir un contraste suffisant',
                'violation.audioAlt' => 'Fournir des alternatives textuelles pour l\'audio',

                // UI Texts
                'ui.generated' => 'Composants UI générés',
                'config.screenReader' => 'Configuration du lecteur d\'écran',
                'summary.title' => 'Résumé de conformité WCAG',
                'summary.total' => 'Contrôles totaux',
                'summary.passed' => 'Réussis',
                'summary.failed' => 'Violations',
                'validation.failed' => 'Échec de la validation du modèle.',

                // Misc
                'complies with' => 'conforme à',
                'violates' => 'viole',
                'Yes' => 'Oui',
                'No' => 'Non',
                'Testing voice with speed' => 'Test de la voix avec une vitesse de',
                'and pitch' => 'et une hauteur de'
            ],
            'es' => [
                'label.submit' => 'Enviar',
                'label.username' => "Nombre de usuario",
                'label.language' => 'Elegir idioma:',
                'tool.title' => "Herramienta de evaluación de accesibilidad",
                'footer.note' => "Prototipo de accesibilidad MDE para tesis de maestría",

                // Features
                'feature.altText' => 'Texto alternativo',
                'feature.screenReader' => 'Lector de pantalla',
                'feature.tts' => 'Texto a voz',
                'feature.highContrast' => 'Alto contraste',
                'feature.resizableText' => 'Texto redimensionable',

                // Rules
                'rule.altText' => 'El contenido no textual debe tener texto alternativo',
                'rule.contrast' => 'El texto debe tener suficiente contraste',
                'rule.audioAlt' => 'Proporcionar alternativas de texto para el audio',
                'rule.screenReader' => 'Asegurar la compatibilidad con lectores de pantalla',

                // Violation Messages
                'violation.contrast' => 'El texto debe tener suficiente contraste',
                'violation.audioAlt' => 'Proporcionar alternativas de texto para el audio',

                // UI Texts
                'ui.generated' => 'Componentes de UI generados',
                'config.screenReader' => 'Configuración del lector de pantalla',
                'summary.title' => 'Resumen de conformidad WCAG',
                'summary.total' => 'Controles totales',
                'summary.passed' => 'Aprobados',
                'summary.failed' => 'Violaciones',
                'validation.failed' => 'Fallo en la validación del modelo.',

                // Misc
                'complies with' => 'cumple con',
                'violates' => 'viola',
                'Yes' => 'Sí',
                'No' => 'No',
                'Testing voice with speed' => 'Probando voz con velocidad',
                'and pitch' => 'y tono'
            ]
        ];

        return $allTranslations[$lang] ?? $allTranslations['en'];
    }

    public function t(string $key, string $default = null): string {
        // Use translation if exists
        if (isset($this->translations[$key])) {
            return $this->translations[$key];
        }

        // Log missing key
        $this->missingKeys[] = $key;

        // Use default if provided
        if ($default !== null) {
            return $default;
        }

        // Fallback: convert keys like 'label.username' → 'Username'
        $cleaned = preg_replace('/^(label|feature|rule|violation)\./', '', $key);
        $cleaned = str_replace(['_', '-'], ' ', $cleaned);
        return ucfirst($cleaned);
    }

    public function getMissingKeys(): array {
        return array_unique($this->missingKeys);
    }

    public function getLoadedTranslations(): array {
        return $this->translations;
    }

    public function getCurrentLanguage(): string {
        return $this->lang;
    }

    public function reloadTranslations(): void {
        $this->translations = self::loadTranslations($this->lang);
        $this->missingKeys = [];
    }
}
