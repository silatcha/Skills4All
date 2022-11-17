<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class OpenMeteoService
{
  private $client;
  

  public function __construct()
  {
    $this->client = HttpClient::create();
    
  
  }

/**
   * @return array
   */
  public function getWeather()
  {
    try {
      $response = $this->client->request(
        'GET',
        'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m'
    );

    $statusCode = $response->getStatusCode();
    // $statusCode = 200
    $contentType = $response->getHeaders()['content-type'][0];
    // $contentType = 'application/json'
    $content = $response->getContent();
    // $content = '{"id":521583, "name":"symfony-docs", ...}'
    $content = $response->toArray();
    // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

    return $content;
    } catch (\Exception $e) {
      return $e;
    }
  }
}