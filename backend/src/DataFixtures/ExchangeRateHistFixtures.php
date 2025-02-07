<?php

namespace App\DataFixtures;

use App\Entity\ExchangeRateHist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExchangeRateHistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filePath = __DIR__ . '/data/exchangeratehist.json';

        if (!file_exists($filePath)) {
            throw new \Exception("File $filePath not found");
        }

        $jsonData = file_get_contents($filePath);
        $exchangeRates = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("JSON error: " . json_last_error_msg());
        }

        foreach ($exchangeRates as [$from, $to, $oldRate, $newRate, $creationDate, $lastUpdateDate]) {
            $exchangeRate = new ExchangeRateHist();
            $exchangeRate->setFromCurrency($from);
            $exchangeRate->setToCurrency($to);
            $exchangeRate->setOldRate($oldRate);
            $exchangeRate->setNewRate($newRate);
            $exchangeRate->setCreationDate(new \DateTime($creationDate)); 
            $exchangeRate->setLastUpdateDate(new \DateTime($lastUpdateDate));

            $manager->persist($exchangeRate);
        }

        $manager->flush();
    }
}
