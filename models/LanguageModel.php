<?php

class LanguageModel {
    public string $languageCode;
    public string $languageName;
    public bool $isRTL;
    public string $voiceProfile;

    public function __construct(string $code, string $name, bool $isRTL, string $voiceProfile) {
        $this->languageCode = $code;
        $this->languageName = $name;
        $this->isRTL = $isRTL;
        $this->voiceProfile = $voiceProfile;
    }

    public function isSupported(): bool {
        return !empty($this->languageCode) && !empty($this->voiceProfile);
    }

    private function loadVoiceProfile(): void {
        // Simulate loading a voice profile
    }
}
