<?php

if (!function_exists('load_env')) {
    /**
     * Load and parse the .env file into environment variables.
     *
     * @param string $filePath Path to the .env file.
     * @return void
     * @throws Exception if the .env file is not found.
     */
    function load_env(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("The .env file was not found at: $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);

                $value = trim($value);
                if (preg_match('/^["\'].*["\']$/', $value)) {
                    $value = substr($value, 1, -1);
                }

                $key = trim($key);

                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                
            }
        }
    }
}

?>