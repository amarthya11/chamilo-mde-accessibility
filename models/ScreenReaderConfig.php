<?php

require_once __DIR__ . '/LanguageModel.php';

class ScreenReaderConfig {
    public string $readerName;
    public bool $enabled;
    public float $voiceSpeed;
    public float $voicePitch;
    /** @var LanguageModel[] */
    public array $languageSupport;

    public function __construct(
        string $readerName,
        bool $enabled,
        float $voiceSpeed,
        float $voicePitch,
        array $languageSupport
    ) {
        $this->readerName = $readerName;
        $this->enabled = $enabled;
        $this->voiceSpeed = $voiceSpeed;
        $this->voicePitch = $voicePitch;
        $this->languageSupport = $languageSupport;
    }

    public function applySettings(): void {
        // Stub for applying settings
    }

    public function testVoice(): void {
        echo "🔊 Testing voice with speed {$this->voiceSpeed} and pitch {$this->voicePitch}<br>";
    }
}
