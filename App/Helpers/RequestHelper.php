<?php

namespace App\Helpers;

class RequestHelper
{
    public static function validatePostParams(array $requiredParams): array
    {
        $validatedData = [];

        foreach ($requiredParams as $param) {
            if (!isset($_POST[$param])) {
                header("Content-Type: application/json");
                echo json_encode(['error' => "Parametro '{$param}' mancante"]);
                exit;
            }
            $validatedData[$param] = $_POST[$param];
        }

        return $validatedData;
    }
}