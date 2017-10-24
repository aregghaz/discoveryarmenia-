<?php


namespace DA\MainBundle\Controller;
use SoapClient;

class Soap
{

    var $client = null;
    var $soapUrl = 'http://api.cba.am/exchangerates.asmx?WSDL';
    var $options = array();

    /**
     *
     * Class: CBAClient - Construct Method
     *
     */

    function __construct()
    {
        $this->client = new SoapClient($this->soapUrl, $this->options);
            //Insert Additional Constructor Code
    }

    /**
     *
     * Class: CBAClient - Destruct Method
     *
     */

    function __destruct()
    {
        unset ($this->client);
//Insert Destructor Code
    }



    function ISOCodesDetailed($parameters ){
        try {
            $funcRet = $this->client->ISOCodesDetailed($parameters );
        } catch ( Exception $e ) {
            echo '(ISOCodesDetailed) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ISOCodes($parameters ){
        try {
            $funcRet = $this->client->ISOCodes($parameters );
        } catch ( Exception $e ) {
            echo '(ISOCodes) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ExchangeRatesLatestByISO($parameters ){
        try {
            $funcRet = $this->client->ExchangeRatesLatestByISO($parameters );
        } catch ( Exception $e ) {
            echo '(ExchangeRatesLatestByISO) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ExchangeRatesByDateByISO($parameters ){
        try {
            $funcRet = $this->client->ExchangeRatesByDateByISO($parameters );
        } catch ( Exception $e ) {
            echo '(ExchangeRatesByDateByISO) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ExchangeRatesByDate($parameters ){
        try {
            $funcRet = $this->client->ExchangeRatesByDate($parameters );
        } catch ( Exception $e ) {
            echo '(ExchangeRatesByDate) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ExchangeRatesLatest($parameters ){
        try {
            $funcRet = $this->client->ExchangeRatesLatest($parameters );
        } catch ( Exception $e ) {
            echo '(ExchangeRatesLatest) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }



    function ExchangeRatesByDateRangeByISO($parameters ){
        try {
            $funcRet = $this->client->ExchangeRatesByDateRangeByISO($parameters );
        } catch ( Exception $e ) {
            echo '(ExchangeRatesByDateRangeByISO) SOAP Error: - ' . $e->getMessage ();
        }
        return $funcRet;
    }
    
}