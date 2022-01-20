<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class TerminalLogger extends AbstractLogger
{
    /**
     * @param string $level
     * @param string $message
     */
    public function log($level, $message, array $context = []): void
    {
        $logValue = $this->logValue($level);
        $streamName = 'stdout';
        if ($logValue > 3) { // greater than warning
            $streamName = 'stderr';
        }
        file_put_contents(
            'php://' . $streamName,
            date('Y-m-d H:i:s') . ' ' . $level . ': ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }

    public function logValue(string $level): int
    {
        $map = [
            LogLevel::EMERGENCY => 7,
            LogLevel::ALERT => 6,
            LogLevel::CRITICAL => 5,
            LogLevel::ERROR => 4,
            LogLevel::WARNING => 3,
            LogLevel::NOTICE => 2,
            LogLevel::INFO => 1,
            LogLevel::DEBUG => 0,
        ];

        return $map[$level] ?? 0;
    }
}
