<?php
namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Database\DatabaseInterface;
use App\Services\Cache\CurrencyCacheService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DTO\CurrencyPairRequest;

class GetCurrencyPairsAPI extends AbstractController
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
        '/get-currency-pairs',
        name: 'get_currency_pairs',
        methods: ['GET']
    )]
    public function showPair(): JsonResponse
    {
        $currencyPairRequest = new CurrencyPairRequest();

        $cacheKey = sprintf('CurrencyPairs_%s', date('Y-m-d_H-i-s'));
        $currencyPairs = $this->currencyCacheService->getOrSetCache(
            $cacheKey,
            function () {
                return $this->database->showCurrencyPairs();
            }
        );

        return $this->json(['data'=> $currencyPairs]);
    }
}
