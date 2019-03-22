<?php

namespace App\Utils;

class GuzzleCurl
{
    public static function getCurl()
    {
        return 'it works!';
    }

   #079446b5b627cd6475dbbceac39ad060
    #onoff switch:
    #VARS NEEDED AS PARAMS:
    # 1 Grab API of results
    # 2 Loop through the said  data  via returned results array

    public static function getApiResults($apiUrl, $headerValue, $headerKey)
    {
        $client = new \GuzzleHttp\Client();

        /**
         * $options: We use this to redude time oout of any apim by default
         */
        $options['timeout'] = 100;
        // $headerValue = 555;
        if(isset($headerValue) && isset($headerKey))
        {
            $response = $client->request('GET', $apiUrl, [
            'headers' => [
            $headerKey      => $headerValue
            ]
            ]);
        } else {
            $response = $client->request('GET', $apiUrl);
        }


        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }
}