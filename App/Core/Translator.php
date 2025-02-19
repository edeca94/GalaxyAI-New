<?php

namespace App\Core;

use Exception;

class Translator
{
    private $language;
    private $translations;

    public function __construct(string $language)
    {
        $this->language = $language;
        $this->translations = $this->loadTranslations($language);
    }

    private function loadTranslations(string $language): array
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . PATH_LANGUAGES . $language . EXT_PHP;

        if (file_exists($filePath)) 
        {
            return require($filePath);
        } else 
        {
            throw new Exception("Impossibile trovare traduzioni per: $language");
        }
    }

    public function translate(string $key): string
    {
        if (isset($this->translations[$key])) 
        {
            return $this->translations[$key];
        } else 
        {
            return $key; 
        }
    }
}