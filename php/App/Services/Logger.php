<?php

namespace Joc4enRatlla\Services;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    private static ?MonologLogger $instance = null;

    private function __construct() {}

    public static function getLogger(): MonologLogger
    {
        if (self::$instance === null) {
            self::$instance = new MonologLogger('game_logger');
            
            // Define the logs directory path
            $logPath = __DIR__ . '/../../logs';

            // Ensure logs directory exists
            if (!file_exists($logPath)) {
                mkdir($logPath, 0777, true); // Create the directory with permissions if it doesn't exist
            }

            // Add handlers for game log and error log
            self::$instance->pushHandler(new StreamHandler($logPath . '/game.log', MonologLogger::INFO));
            self::$instance->pushHandler(new StreamHandler($logPath . '/error.log', MonologLogger::ERROR));
        }
        return self::$instance;
    }
}
