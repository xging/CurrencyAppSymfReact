<?php

namespace App\DataFixtures;

use App\Entity\CurrencyPairs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyPairsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currencyPairs = [
            ['EUR', 'GBP'],
            ['GBP', 'EUR'],
            ['EUR', 'USD'],
            ['USD', 'EUR'],
            ['EUR', 'AUD'],
            ['AUD', 'EUR'],
        ];

        foreach ($currencyPairs as [$from, $to]) {
            $currencyPair = new CurrencyPairs();
            $currencyPair->setFromCurrency($from);
            $currencyPair->setToCurrency($to);
            $currencyPair->setCreationDate(new \DateTime());

            $manager->persist($currencyPair);
        }

        $manager->flush();
    }
}
