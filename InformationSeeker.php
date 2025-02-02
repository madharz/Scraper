<?php

class InformationSeekerFromFile
{
    public function getInfo(string $html)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);

        $xpath = new DOMXPath($dom);

        $cityNode = $xpath->query("//h1[contains(@style, 'background:rgb')]")->item(0);
        $city = $cityNode ? trim(str_replace('Погода', '', $cityNode->textContent)) : "City not found";

        $tempNode = $xpath->query("//span[@class='t']")->item(0);
        $tempText = $tempNode ? trim($tempNode->textContent) : "Temperature not found";

        $tempParts = explode('..', $tempText);
        $minTemp = isset($tempParts[0]) ? trim($tempParts[0]) : "minTemp not found";
        $maxTemp = isset($tempParts[1]) ? trim($tempParts[1]) : "maxTemp not found";

        return json_encode([
            'city' => $city,
            'min_temp' => $minTemp,
            'max_temp' => $maxTemp
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}