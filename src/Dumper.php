<?php

namespace GraveyardKeeperBot;

use Throwable;

class Dumper
{
    private string $rootDirectory;

    public function __construct()
    {
        $this->rootDirectory = realpath(__DIR__ . '/../logs');
    }

    public function exception(Throwable $exception): void
    {
        $this->addLog(
            'error',
            $exception->getMessage() . PHP_EOL . $exception->getTraceAsString()
        );
    }

    public function debug(string $message): void
    {
        $this->addLog('debug', $message);
    }

    private function addLog(string $logFileName, string $message): void
    {
        file_put_contents(
            sprintf('%s/%s.log', $this->rootDirectory, $logFileName),
            sprintf('[%s] %s', date('d.m.Y H:i:s'), $message) . PHP_EOL,
            FILE_APPEND
        );
    }
}
