<?php

namespace App\Core;

use App\Core\Translator;

abstract class Core
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new Translator($this->getUserLanguage());
    }

    private function getUserLanguage(): string
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $acceptedLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $acceptedLanguages = preg_replace('/(;q=[0-9.]+)/i', '', $acceptedLanguages);
            $acceptedLanguages = explode(',', $acceptedLanguages);
            $userLanguage = strtolower(trim($acceptedLanguages[0]));
        } else {
            $userLanguage = KWRD_IT;
        }

        return $userLanguage;
    }

    public function prettyNumber(int $number): string
    {
        return number_format($number, 0, '', '.');
    }

    function formatMilliseconds($milliseconds) {
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        
        $remainingHours = $hours % 24;
        $remainingMinutes = $minutes % 60;
        $remainingSeconds = $seconds % 60;
        $remainingMilliseconds = intval($milliseconds) % 1000;
    
        $timeUnits = array();
        
        if ($days > 0) {
            $timeUnits[] = round($days) . ($days === 1 ? "g" : "gi");
        }
        if ($remainingHours > 0) {
            $timeUnits[] = round($remainingHours) . ($remainingHours === 1 ? "o" : "re");
        }
        if ($remainingMinutes > 0) {
            $timeUnits[] = round($remainingMinutes) . ($remainingMinutes === 1 ? "m" : "mi");
        }
        if ($remainingSeconds > 0) {
            $timeUnits[] = round($remainingSeconds) . ($remainingSeconds === 1 ? "s" : "se");
        }
        if ($remainingMilliseconds >= 0) {
            $timeUnits[] = round($remainingMilliseconds) . ($remainingMilliseconds === 1 ? "ms" : "ms");
        }
    
        return implode(" ", $timeUnits);
    }
    

    public function throwCustomErrorAjax($error)
    {
        http_response_code(400); 
        echo json_encode(['success' => false, 'errorMessage' => $error]);
        exit;
    }
}