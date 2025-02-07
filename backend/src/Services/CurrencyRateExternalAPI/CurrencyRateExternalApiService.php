<?php
namespace App\Services\CurrencyRateExternalAPI;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CurrencyRateExternalApiService
{
    private $curl;
    private $params;

    public function __construct(CurlWrapper $curl, ParameterBagInterface $params)
    {
        $this->curl = $curl;
        $this->params = $params; 
    }

    public function fetchExchangeRate(string $from, string $to): ?float
    {
       
        $key = $this->params->get('CURRENCY_API_KEY');
        
        if (!$key) {
            throw new \RuntimeException('CURRENCY_API_KEY is not set');
        }

        $url = "https://anyapi.io/api/v1/exchange/rates?base={$from}&apiKey={$key}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = $this->curl->exec($ch);

        if ($response === false) {
            $error = $this->curl->error($ch);
            $this->curl->close($ch);
            return null;
        }

        $this->curl->close($ch);

        $data = json_decode($response, true);
        
        if (isset($data['rates'][$to])) {
            return (float) $data['rates'][$to];
        } else {
            return null;
        }
    }
}