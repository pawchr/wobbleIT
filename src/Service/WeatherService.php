<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $weatherApiKey,
        private string $weatherApiUrl
    ) {}

    public function getWeatherForLocationAndDate(string $location, \DateTimeInterface $date): ?array
    {
        try {
            $response = $this->httpClient->request('GET', $this->weatherApiUrl . '/history.json', [
                'query' => [
                    'key' => $this->weatherApiKey,
                    'q' => $location,
                    'dt' => $date->format('Y-m-d'),
                ]
            ]);

            return $response->toArray();
        } catch (\Throwable $e) {
            
            return null;
        }
    }
}
