<?php

class InformationSeekerFromFile
{

    private function getNextElementSibling(\DOMNode $node): ?\DOMElement
    {
        $sibling = $node->nextSibling;
        while ($sibling && $sibling->nodeType !== XML_ELEMENT_NODE) {
            $sibling = $sibling->nextSibling;
        }
        return $sibling instanceof \DOMElement ? $sibling : null;
    }

    public function getInfo(string $html, string $cityId): string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $cityNode = $xpath->query("//a[contains(@id,'map') and contains(@href, '/city/{$cityId}/')]")->item(0);
        if (!$cityNode) {
            return json_encode(['error' => "City with ID {$cityId} not found"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $city = trim($cityNode->textContent);

        $cityContainer = $cityNode->parentNode;
        $tempContainer = $this->getNextElementSibling($cityContainer);
        if (!$tempContainer) {
            return json_encode(['error' => "Temperature info not found for city {$city}"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }


        $maxTempNode = $cityContainer->nextSibling->firstChild;

        $minTempNode = $maxTempNode->nextSibling->nextSibling;
//        var_dump($minTempNode);die;
        $minTemp = $minTempNode  ? trim($minTempNode->textContent) : "minTemp not found";
        $maxTemp = $maxTempNode ? trim($maxTempNode->textContent) : "maxTemp not found";

        return json_encode([
            'city'     => $city,
            'min_temp' => $minTemp,
            'max_temp' => $maxTemp
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
