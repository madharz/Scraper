<?php

use GuzzleHttp\Client;

class MeteopostScraper
{
    private const PROTOCOL = 'https://';
    private const HOST = 'meteopost.com';
    private const FILE_NAME = 'response.html';

    public function getContent(): string
    {
       $ch = curl_init(self::getUrl());
       curl_setopt($ch,CURLOPT_HEADER, TRUE);
       curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt_array($ch,[
           CURLOPT_USERAGENT => "WeatherScraper/1.0",
           CURLOPT_HTTPHEADER => [
               "Accept: text/html,application/xhtml+xml",
               "Referer: https://meteopost.com"
           ]
       ]);

       $response = curl_exec($ch);

       if(curl_errno($ch)){
           throw new Exception('cURL error: ' . curl_error($ch));
       }

       curl_close($ch);

       file_put_contents(self::FILE_NAME, $response);

       return $response;

    }

    private static function getUrl(): string
    {
        return self::PROTOCOL.self::HOST;
    }

}