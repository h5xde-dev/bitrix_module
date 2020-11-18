<?php    

use Bitrix\Main\Web\HttpClient;
use Exception;
    
class Centrobank 
{
    private $url;

    public function updateCurrencies()
    {
        global $DB;

        $content = $this->httpClient();
        
        if($content !== null)
        {
            foreach ($content['Valute'] as $key => $value)
            {
                $arFields = [
                    'code' => (string)$key,
                    'value' => (string)$value['Value'],
                    'date_update' => $content['Date']
                ];

                $arInsert = $DB->PrepareInsert('currencies', $arFields);

                $strSql = "INSERT INTO currencies (" . $arInsert[0] . ") VALUES (" . $arInsert[1] . ")";

                $DB->Query($strSql, false);

                return true;
            }
        }
    }

    public function getCurrencyCodes() :array
    {
        $codes = [];

        $content = $this->httpClient();

        if($content !== null)
        {
            $codes = array_keys($content['Valute']);
        }

        return $codes;
    }

    public function getCurrencyByFilter()
    {

    }

    public function getCurrencyValue(string $currencyCode) :array
    {
        $currencyInfo = [];

        $availableCurrencies = $this->getCurrencyCodes();
        
        if( !in_array($currencyCode, $availableCurrencies) )
        {
            $currencyInfo =  ['error' => 'code does not exist'];
        }

        $content = $this->httpClient();

        if($content !== null && in_array($currencyCode, $availableCurrencies))
        {
            $currencyInfo = array_keys($content['Valute'][$currencyCode]);
        }

        return $currencyInfo;
    }

    private function httpClient()
    {
        $content = null;

        $httpClient = new HttpClient();

        $httpClient->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
        $httpClient->query('get', $this->url, $entityBody = null);

        $content = json_decode($httpClient->getResult());

        return $content;
    }
}
?>