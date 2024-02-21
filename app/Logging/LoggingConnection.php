<?php

namespace App\Logging;

use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;

class LoggingConnection
{
    protected $logtail_logger;
    public function __construct()
    {
        $this->logtail_logger = new Logger("logtail-source");
        $this->logtail_logger->pushHandler(
            new LogtailHandler(env('TAILLOG_KEY'))
        );
    }
}
