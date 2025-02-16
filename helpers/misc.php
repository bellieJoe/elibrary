<?php

class Misc 
{
    public function test()
    {
        return "Hello";
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input));
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