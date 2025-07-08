<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(Request $request, WeatherService $weatherService)
    {
        $location = $request->query->get('location', 'Warsaw');
        $date = \DateTime::createFromFormat('Y-m-d', $request->query->get('date')) ?: new \DateTime();

        $weatherData = $weatherService->getWeatherForLocationAndDate($location, $date);

        return $this->render('panel/weather/index.html.twig', [
            'weatherData' => $weatherData,
            'location' => $location,
            'date' => $date->format('Y-m-d'),
        ]);
    }
}
