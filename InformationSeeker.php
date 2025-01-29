<?php

class InformationSeekerFromFile
{
    private const FILE_NAME = 'response.html';
   public function getInfo()
   {

           if (!file_exists(self::FILE_NAME)) {
               throw new Exception("File not found: " . self::FILE_NAME);
           }

           $html = file_get_contents(self::FILE_NAME);

           $dom = new DOMDocument();
           libxml_use_internal_errors(true);
           $dom->loadHTML($html);

           $xpath = new DOMXPath($dom);

           $cityNode = $xpath->query("//a[@id='map']")->item(0);
           $city = $cityNode ? trim($cityNode->textContent) : "City not found";

           $tempNodes = $xpath->query("//span[@style[contains(., 'color:red')]]");
           $minTemp = $tempNodes->item(0) ? trim($tempNodes->item(0)->textContent) : "minTemp not found";
           $maxTemp = $tempNodes->item(1) ? trim($tempNodes->item(1)->textContent) : "maxTemp not found";

           return [
               'city' => $city,
               'minTemp' => $minTemp,
               'maxTemp' => $maxTemp
           ];
   }
}