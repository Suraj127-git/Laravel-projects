<?php

namespace App\Logging;

interface LoggingInterface
{
    public function logInfo(string $message): void;
    public function logError(string $message): void;
    public function logDebug(string $message): void;
    public function logWarn(string $message): void;
}
