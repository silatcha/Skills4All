<?php

namespace App\Controller;

use App\Service\OpenMeteoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class OpenMeteoController extends AbstractController
{

    private $openMeteo;

    public function __construct(OpenMeteoService $weather)
    {
      $this->openMeteo = $weather;
    }
  
    #[Route('/open/meteo', name: 'app_open_meteo')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
      
      $data = $this->openMeteo->getWeather();
      
      if (is_array($data)) {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $data["hourly"]["time"],
            'datasets' => [
                [
                    'label' => 'weather',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data["hourly"]["temperature_2m"],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                  'title' => [
                    'display'  => true,
                    'text'     => 'Temperature °C',
                  ],
                    'suggestedMin' => 0,
                    'suggestedMax' => 6,
                ],
                'x' => [
                  'title' => [
                    'display'  => true,
                    'text'     => 'Time',
                  ],
                ],
            ],
            'plugins'=> [
              'legend'=> [
                'display'=> true,
                'labels' => [
                  'color' =>'rgb(255, 99, 132)'
                
                ]
                  
              ]
                
            
            ]
              
        
        ]);
        return $this->render('open_meteo/index.html.twig', 
            ['chart' => $chart,]
        );
       
      } else {
        $statusCode = 0;
        $errorMessage = '';
        $e = $data;
        if (method_exists($e, 'getResponse')) {
          $statusCode = $e->getResponse()->getStatusCode();
        }
        if ($statusCode == 0) {
          $errorMessage = 'Error occurs';
        }
        if (401 == $statusCode) {
          $errorMessage = "errror authentifacation";
        }
        if (404 == $statusCode) {
          $errorMessage = "page not found";
        }
        if (429 == $statusCode) {
          $errorMessage = "";
        }
        return $this->render('errors.html.twig', ['error' => $errorMessage]);
      }
    }

}
