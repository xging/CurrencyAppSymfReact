<?php

namespace App\DataFixtures;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExchangeRateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exchangeRates = [
            ['EUR', 'GBP', 0.83095],
            ['GBP', 'EUR', 1],
            ['EUR', 'USD', 1],
            ['USD', 'EUR', 0.9595],
            ['EUR', 'AUD', 1],
            ['AUD', 'EUR', 1],
        ];

        foreach ($exchangeRates as [$from, $to, $rate]) {

            $exchangeRate = new ExchangeRate();
            $exchangeRate->setFromCurrency($from);
            $exchangeRate->setToCurrency($to);
            $exchangeRate->setRate($rate);
            $exchangeRate->setCreationDate(new \DateTime());
            $exchangeRate->setLastUpdateDate(new \DateTime());

            $manager->persist($exchangeRate);
        }




        $manager->flush();
    }
}
