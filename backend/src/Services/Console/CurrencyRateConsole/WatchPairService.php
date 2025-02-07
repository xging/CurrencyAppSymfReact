<?php

namespace App\Services\Console\CurrencyRateConsole;

use App\Services\Console\CurrencyRateConsole\Interfaces\CurrencyRateConsoleInterface;

class WatchPairService implements CurrencyRateConsoleInterface
{
    private WatchPairProcessorService $pairProcessor;
    private bool $isRunning = true;
    
    public function __construct(
        WatchPairProcessorService $pairProcessor
    ) {
        $this->pairProcessor = $pairProcessor;
    }

    public function execute(array $args = []): void
    {
        if (count($args) > 0) {
            echo "*** Usage: php bin/console app:watch-pair\n";
            return;
        }

        echo "*** Watch pair service started.\n";
        
        $this->startWatching();
    }
    
    private function startWatching(): void
    {
        echo "*** Process exchange rates ***\n";
        $this->pairProcessor->processAllPairs();
        echo "*** END ***\n";
    }
}

