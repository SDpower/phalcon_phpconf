<?php
define("APP_ENV",
    ((isset($_SERVER["APP_ENV"]) && $_SERVER["APP_ENV"] == "development") ?
        "development":"production"));
if (APP_ENV == "development") {
    //development
    error_reporting(E_ALL);
    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../config/config.php";

    /**
     * Include Services
     */
    include __DIR__ . '/../config/services.php';

    /**
     * Include Autoloader
     */
    include __DIR__ . '/../config/loader.php';

    /**
     * Starting the application
    */
    $app = new \Phalcon\Mvc\Micro();

    /**
     * Assign service locator to the application
     */
    $app->setDi($di);

    /**
     * Incude Application
     */
    include __DIR__ . '/../app.php';

    /**
     * Handle the request
     */
    $app->handle();
} else {
    //production
    error_reporting(0);
    @ini_set('display_errors', 0);

    try {

        /**
         * Read the configuration
         */
        $config = include __DIR__ . "/../config/config.php";

        /**
         * Include Services
         */
        include __DIR__ . '/../config/services.php';

        /**
         * Include Autoloader
         */
        include __DIR__ . '/../config/loader.php';

        /**
         * Starting the application
        */
        $app = new \Phalcon\Mvc\Micro();

        /**
         * Assign service locator to the application
         */
        $app->setDi($di);

        /**
         * Incude Application
         */
        include __DIR__ . '/../app.php';

        /**
         * Handle the request
         */
        $app->handle();

    } catch (Phalcon\Exception $e) {
        //Exception Handle
    } catch (PDOException $e) {
        //Error Handle
    }
}