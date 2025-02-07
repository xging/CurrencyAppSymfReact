<?php

namespace App\Controller\API;

use App\DTO\CurrencyPairRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Database\DatabaseInterface;
use App\Services\Cache\CurrencyCacheService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetCurrencyRatesHistAllAPI extends AbstractController
{
    private DatabaseInterface $database;
    private CurrencyCacheService $currencyCacheService;
    private ValidatorInterface $validator;

    public function __construct(
        DatabaseInterface $database,
        CurrencyCacheService $currencyCacheService,
        ValidatorInterface $validator
    ) {
        $this->database = $database;
        $this->currencyCacheService = $currencyCacheService;
        $this->validator = $validator;
    }

    #[Route(
        '/get-currency-hist-all',
        name: 'get_currency_hist',
        methods: ['GET']
    )]
    public function showPair(): JsonResponse
    {
        $cacheKey = sprintf('CurrencyRateHistAll_%s', date('Y-m-d'));
        $currencyPairs = $this->currencyCacheService->getOrSetCache(
            $cacheKey,
            function (){
                return $this->database->showRatesPairHistAll();
            }
        );

        if (empty($currencyPairs)) {
            return new JsonResponse(['error' => 'No data found for the specified currency pair.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['data' => $currencyPairs]);
    }
}
