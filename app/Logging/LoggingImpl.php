<?php

namespace App\Logging;

use App\Logging\LoggingConnection;
use App\Logging\LoggingInterface;

class LoggingImpl extends LoggingConnection implements LoggingInterface
{

    public function logInfo(string $message): void
    {
        $this->logtail_logger->info($message);
    }

    public function logError(string $message): void
    {
        $this->logtail_logger->error($message);
    }

    public function logDebug(string $message): void
    {
        $this->logtail_logger->debug($message);
    }

    public function logWarn(string $message): void
    {
        $this->logtail_logger->warning($message);
    }
}
