<?php


namespace App\Service;

use App\Utils\GuzzleCurl;



class NewsApi
{
    public function getNewsResultsFeed()
    {
        $locationNews = "https://newsapi.org/v2/everything?q=" .'cricklewood' ."&apiKey=bd08b2acee29475fa28527fc957670fe";
        $newsData = GuzzleCurl::getApiResults($locationNews, 'Auth' , 'Auth');

        $newsResults = array();
        foreach($newsData['articles'] as $key => $newsData)
        {
            $newsResults[] = array(
                'author' => $newsData["author"],
                "title" => $newsData['title'],
                "description" => $newsData['description'],
                "url" => $newsData['url'],
                "urlToImage" => $newsData['urlToImage'],
                "publishedAt" =>  $newsData['publishedAt'],
                "content" =>  $newsData['content'],
                );
        }
        return $newsResults;



    }
}