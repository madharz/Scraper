<?php

class InformationSeekerFromFile
{
 private string $filePath = __DIR__ . '/weather_response.html';
   public function getInfo()
   {
       try {

           if (!file_exists($this->filePath)) {
               throw new Exception("Файл не знайдено: $this->filePath");
           }

           $html = file_get_contents($this->filePath);
           if ($html === false) {
               throw new Exception("Не вдалося прочитати файл: $this->filePath");
           }

           $dom = new DOMDocument();
           @$dom->loadHTML($html);

           $xpath = new DOMXPath($dom);

           $cityNode = $xpath->query("//a[@id='map']")->item(0);
           $city = $cityNode ? trim($cityNode->textContent) : "Місто не знайдено";

           $tempNodes = $xpath->query("//span[@style[contains(., 'color:red')]]");
           $minTemp = $tempNodes->item(0) ? trim($tempNodes->item(0)->textContent) : "Мінімальна температура не знайдена";
           $maxTemp = $tempNodes->item(1) ? trim($tempNodes->item(1)->textContent) : "Максимальна температура не знайдена";

           echo "Місто: $city\n";
           echo "Мінімальна температура: $minTemp\n";
           echo "Максимальна температура: $maxTemp\n";

       } catch (Exception $e) {
           echo "Помилка: " . $e->getMessage();
       }
   }
}