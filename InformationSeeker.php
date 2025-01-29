<?php

class InformationSeekerFromFile
{
    public function getInfo(string $html)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);

        $xpath = new DOMXPath($dom);

        $cityNode = $xpath->query("//a[@id='map']")->item(0);
        $city = $cityNode ? trim($cityNode->textContent) : "City not found";

        $tempNodes = $xpath->query("//span[@style[contains(., 'color:red')]]");
        $minTemp = $tempNodes->item(0) ? trim($tempNodes->item(0)->textContent) : "minTemp not found";
        $maxTemp = $tempNodes->item(1) ? trim($tempNodes->item(1)->textContent) : "maxTemp not found";

        return json_encode([
            'city' => $city,
            'min_temp' => $minTemp,
            'max_temp' => $maxTemp
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}