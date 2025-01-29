<?php


class MeteopostScraper
{
    private const PROTOCOL = 'https://';
    private const HOST = 'meteopost.com';
    private const FILE_NAME = 'response.html';

    /**
     * @throws Exception
     */
    public function getWeather(): string
    {
        return $this->fetchData();
    }
    public function fetchData(): string
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
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200 || !$response) {
            throw new Exception("HTTP Error: $httpCode");
        }

        curl_close($ch);

        return $response;

    }

    private static function getUrl(): string
    {
        return self::PROTOCOL.self::HOST;
    }

}