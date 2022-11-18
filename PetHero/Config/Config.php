<?php namespace Config;
    define("ROOT", dirname(__DIR__) . "/");
    //Path to your project's root folder
    define("FRONT_ROOT", "/Pet-Hero/PetHero");
    define("VIEWS_PATH", "Views/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "Layouts/Styles");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
    define("IMG_PATH", VIEWS_PATH . "img/");

    define("DB_HOST", "localhost");
    define("DB_PORT", "3306");
    define("DB_NAME", "petHero");
    define("DB_USER", "root");
    define("DB_PASS", "");
?>


