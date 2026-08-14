<?php namespace Config;
    define("ROOT", dirname(__DIR__) . "/");
    //Path to your project's root folder
    define("FRONT_ROOT", "/Pet-Hero/PetHero");
    define("VIEWS_PATH", "Views/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "Layouts/Styles");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
    define("IMG_PATH", VIEWS_PATH . "img/");
 
    // Load local environment variables from .env (not committed to git, see .env.example)
    $envPath = ROOT . ".env";
    if (file_exists($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($key, $value) = array_pad(explode('=', $line, 2), 2, null);
            if ($key !== null) {
                putenv(trim($key) . '=' . trim($value ?? ''));
            }
        }
    }
 
    define("DB_HOST", getenv("DB_HOST") ?: "localhost");
    define("DB_PORT", getenv("DB_PORT") ?: "3306");
    define("DB_NAME", getenv("DB_NAME") ?: "petHero");
    define("DB_USER", getenv("DB_USER") ?: "root");
    define("DB_PASS", getenv("DB_PASS") ?: "");
?>