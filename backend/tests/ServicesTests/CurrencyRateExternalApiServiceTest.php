<?php
namespace App\Tests\Services\CurrencyRateExternalAPI;

use PHPUnit\Framework\TestCase;
use App\Services\CurrencyRateExternalAPI\CurrencyRateExternalApiService;
use App\Services\CurrencyRateExternalAPI\CurlWrapper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
class CurrencyRateExternalApiServiceTest extends TestCase
{
    public function testFetchExchangeRateSuccess(): void
    {
        $mockCurl = $this->createMock(CurlWrapper::class);
        $paramsMock = $this->createMock(ParameterBagInterface::class);
    
        $paramsMock->method('get')->with('CURRENCY_API_KEY')->willReturn('fake_api_key');
    
        $mockCurl->method('exec')->willReturn(json_encode([
            'rates' => [
                'EUR' => 1.15,
            ],
        ]));
    
        $service = new CurrencyRateExternalApiService($mockCurl, $paramsMock);
    
        $rate = $service->fetchExchangeRate('GBP', 'EUR');
        $this->assertEquals(1.15, $rate);
    }
    
    public function testFetchExchangeRateCurlError(): void
    {
        $mockCurl = $this->createMock(CurlWrapper::class);
        $paramsMock = $this->createMock(ParameterBagInterface::class);
    
        $paramsMock->method('get')->with('CURRENCY_API_KEY')->willReturn('fake_api_key');
    
        $mockCurl->method('exec')->willReturn(false);
        $mockCurl->method('error')->willReturn('Mocked cURL error');
    
        $service = new CurrencyRateExternalApiService($mockCurl, $paramsMock);
        $rate = $service->fetchExchangeRate('GBP', 'EUR');
        $this->assertNull($rate);
    }
    
    public function testFetchExchangeRateNoData(): void
    {
        $mockCurl = $this->createMock(CurlWrapper::class);
        $paramsMock = $this->createMock(ParameterBagInterface::class);
    
        $paramsMock->method('get')->with('CURRENCY_API_KEY')->willReturn('fake_api_key');
    
        $mockCurl->method('exec')->willReturn(json_encode([
            'rates' => [],
        ]));
    
        $service = new CurrencyRateExternalApiService($mockCurl, $paramsMock);
        $rate = $service->fetchExchangeRate('GBP', 'EUR');
        $this->assertNull($rate);
    }
    
}
