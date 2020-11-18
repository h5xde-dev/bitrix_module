<?php

use Bitrix\Main\Web\HttpClient;
use Exception;

class Centrobank
{
    public static function updateCurrencies()
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

                $arInsert = $DB->PrepareInsert('sitemanager.currencies', $arFields);

                $strSql = "INSERT INTO sitemanager.currencies (" . $arInsert[0] . ") VALUES (" . $arInsert[1] . ")";

                $DB->Query($strSql, false);
            }
        }
    }

    public static function getCurrencyCodes() :array
    {
        $codes = [];

        $content = $this->httpClient();

        if($content !== null)
        {
            $codes = array_keys($content['Valute']);
        }

        return $codes;
    }

    public static function getCurrencyByFilter()
    {

    }

    public static function getCurrencyValue(string $currencyCode) :array
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

    private static function httpClient()
    {
        $content = null;

        $httpClient = new HttpClient();

        $httpClient->setHeader('Content-Type', 'application/json; charset=UTF-8', true);
        $httpClient->query('get', 'https://www.cbr-xml-daily.ru/daily_json.js', $entityBody = null);

        $content = json_decode($httpClient->getResult());

        return $content;
    }
}

?>