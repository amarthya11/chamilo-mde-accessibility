<?php

class TranslationService {
    private static ?TranslationService $instance = null;
    private string $lang;
    private array $translations;

    private function __construct(string $lang = 'en') {
        $this->lang = $lang;
        $this->translations = self::loadTranslations($lang);
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
                'Alt Text' => 'Alt Text',
                'Screen Reader' => 'Screen Reader',
                'TTS' => 'Text-to-Speech',
                'High Contrast' => 'High Contrast',
                'Resizable Text' => 'Resizable Text',
                'complies with' => 'complies with',
                'violates' => 'violates',
                'Provide text alternatives for audio' => 'Provide text alternatives for audio',
                'Text must have sufficient contrast' => 'Text must have sufficient contrast',
                'Non-text content must have alt text' => 'Non-text content must have alt text',
                'Ensure screen reader compatibility' => 'Ensure screen reader compatibility',
                'Yes' => 'Yes',
                'No' => 'No',
                'Screen Reader Configuration' => 'Screen Reader Configuration',
                'Testing voice with speed' => 'Testing voice with speed',
                'and pitch' => 'and pitch',
                'UI Components Generated' => 'UI Components Generated',
                'WCAG Compliance Summary' => 'WCAG Compliance Summary',
                'Total Checks' => 'Total Checks',
                'Passed' => 'Passed',
                'Violations' => 'Violations',
                'validation.failed' => 'Model validation failed.',
                'feature.altText' => 'Alt Text',
                'feature.screenReader' => 'Screen Reader',
                'feature.tts' => 'TTS',
                'feature.highContrast' => 'High Contrast',
                'feature.resizableText' => 'Resizable Text',
                'rule.altText' => 'Non-text content must have alt text',
                'rule.contrast' => 'Text must have sufficient contrast',
                'rule.audioAlt' => 'Provide text alternatives for audio',
                'rule.screenReader' => 'Ensure screen reader compatibility',
                'summary.title' => 'WCAG Compliance Summary',
                'summary.total' => 'Total Checks',
                'summary.passed' => 'Passed',
                'summary.failed' => 'Violations',
                'config.screenReader' => 'Screen Reader Configuration',
                'ui.generated' => 'UI Components Generated',
            ],
            'fr' => [
                'Alt Text' => 'Texte alternatif',
                'Screen Reader' => 'Lecteur d\'écran',
                'TTS' => 'Synthèse vocale',
                'High Contrast' => 'Contraste élevé',
                'Resizable Text' => 'Texte redimensionnable',
                'complies with' => 'conforme à',
                'violates' => 'viole',
                'Provide text alternatives for audio' => 'Fournir des alternatives textuelles pour l\'audio',
                'Text must have sufficient contrast' => 'Le texte doit avoir un contraste suffisant',
                'Non-text content must have alt text' => 'Le contenu non textuel doit avoir un texte alternatif',
                'Ensure screen reader compatibility' => 'Assurer la compatibilité avec les lecteurs d\'écran',
                'Yes' => 'Oui',
                'No' => 'Non',
                'Screen Reader Configuration' => 'Configuration du lecteur d\'écran',
                'Testing voice with speed' => 'Test de la voix avec une vitesse de',
                'and pitch' => 'et une hauteur de',
                'UI Components Generated' => 'Composants UI générés',
                'WCAG Compliance Summary' => 'Résumé de conformité WCAG',
                'Total Checks' => 'Contrôles totaux',
                'Passed' => 'Réussis',
                'Violations' => 'Violations',
                'validation.failed' => 'Échec de la validation du modèle.',
                'feature.altText' => 'Texte alternatif',
                'feature.screenReader' => 'Lecteur d\'écran',
                'feature.tts' => 'Synthèse vocale',
                'feature.highContrast' => 'Contraste élevé',
                'feature.resizableText' => 'Texte redimensionnable',
                'rule.altText' => 'Le contenu non textuel doit avoir un texte alternatif',
                'rule.contrast' => 'Le texte doit avoir un contraste suffisant',
                'rule.audioAlt' => 'Fournir des alternatives textuelles pour l\'audio',
                'rule.screenReader' => 'Assurer la compatibilité avec les lecteurs d\'écran',
                'summary.title' => 'Résumé de conformité WCAG',
                'summary.total' => 'Contrôles totaux',
                'summary.passed' => 'Réussis',
                'summary.failed' => 'Violations',
                'config.screenReader' => 'Configuration du lecteur d\'écran',
                'ui.generated' => 'Composants UI générés',
            ],
            'es' => [
                'Alt Text' => 'Texto alternativo',
                'Screen Reader' => 'Lector de pantalla',
                'TTS' => 'Texto a voz',
                'High Contrast' => 'Alto contraste',
                'Resizable Text' => 'Texto redimensionable',
                'complies with' => 'cumple con',
                'violates' => 'viola',
                'Provide text alternatives for audio' => 'Proporcionar alternativas de texto para el audio',
                'Text must have sufficient contrast' => 'El texto debe tener suficiente contraste',
                'Non-text content must have alt text' => 'El contenido no textual debe tener texto alternativo',
                'Ensure screen reader compatibility' => 'Asegurar la compatibilidad con lectores de pantalla',
                'Yes' => 'Sí',
                'No' => 'No',
                'Screen Reader Configuration' => 'Configuración del lector de pantalla',
                'Testing voice with speed' => 'Probando voz con velocidad',
                'and pitch' => 'y tono',
                'UI Components Generated' => 'Componentes de UI generados',
                'WCAG Compliance Summary' => 'Resumen de conformidad WCAG',
                'Total Checks' => 'Controles totales',
                'Passed' => 'Aprobados',
                'Violations' => 'Violaciones',
                'validation.failed' => 'Fallo en la validación del modelo.',
                'feature.altText' => 'Texto alternativo',
                'feature.screenReader' => 'Lector de pantalla',
                'feature.tts' => 'Texto a voz',
                'feature.highContrast' => 'Alto contraste',
                'feature.resizableText' => 'Texto redimensionable',
                'rule.altText' => 'El contenido no textual debe tener texto alternativo',
                'rule.contrast' => 'El texto debe tener suficiente contraste',
                'rule.audioAlt' => 'Proporcionar alternativas de texto para el audio',
                'rule.screenReader' => 'Asegurar la compatibilidad con lectores de pantalla',
                'summary.title' => 'Resumen de conformidad WCAG',
                'summary.total' => 'Controles totales',
                'summary.passed' => 'Aprobados',
                'summary.failed' => 'Violaciones',
                'config.screenReader' => 'Configuración del lector de pantalla',
                'ui.generated' => 'Componentes de UI generados',
            ]
        ];

        return $allTranslations[$lang] ?? $allTranslations['en'];
    }

    public function t(string $key): string {
        return $this->translations[$key] ?? $key;
    }
}
