<?php

class Misc 
{
    public function test()
    {
        return "Hello";
    }

    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map(fn($value) => self::sanitizeInput($value), $input); 
        }
        return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }

    public static function logError($message, $file = null, $line = null) {
        $timestamp = date("Y-m-d H:i:s"); 
        $logMessage = "[$timestamp] ERROR: $message";
        $logFile = ROOT_PATH . "/logs/error_log.txt";

        if ($file && $line) {
            $logMessage .= " in $file on line $line";
        }

        file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
    }

    public static function toObject(array $array) {
        array_map(fn($arr) => (object) $arr, $array);
    }

    

}

?>