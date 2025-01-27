<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MeteopostScraper
{
    private const PROTOCOL = 'https://';
    private const HOST = 'meteopost.com';

    public function getContent(): string
    {
       $client = new Client();
       try{
           $response = $client->request('GET', self::getUrl(), [
               'timeout' => 10,
                   'verify' => false,
                   'headers' => [
                       'User-Agent' => 'WeatherScraper/1.0'
                   ]
               ]);

           return $response->getBody()->getContents();
       } catch (RequestException $e){
           if ($e->hasResponse()) {
               $errorBody = $e->getResponse()->getBody()->getContents();
               throw new Exception("HTTP Error: " . $errorBody);
           }
           throw new Exception("Request Error: " . $e->getMessage());
       }

    }

    private static function getUrl(): string
    {
        return self::PROTOCOL.self::HOST;
    }

}