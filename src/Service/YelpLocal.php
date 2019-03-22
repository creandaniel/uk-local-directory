<?php

namespace App\Service;

use App\Utils\GuzzleCurl;
use App\Utils\DbWrapper;


use App\Entity\LocalCache;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Doctrine\ODM\PHPCR\Query\QueryException;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\EntityManagerInterface;

use Doctrine\ORM\EntityRepository;


use App\Service\YelpLocal;

use Symfony\Component\Routing\Annotation\Route;


class YelpLocal {

    private $product;


    public function __construct(EntityManagerInterface $product){
        $this->product = $product;
    }


    public function getData()
    {

     $product = $this->product;

       // $ttt = $product->getRepository(LocalCache::class)->findOneBy(['identifier' => '53a5d5bd780a9da7bd52e45a22a4a1a211a70edf']);

 }

    /**
     * [getBusinessResults description]
     * @param  [type] $localTerm    [description]
     * @param  [type] $cityLocation [description]
     * @link https://stackoverflow.com/questions/53360122/symfony-4-use-doctrine-inside-a-service
     * @return [type]               [description]
     */
    public function getBusinessResults($localTerm, $cityLocation)
    {


     $apiUrl = 'https://api.yelp.com/v3/businesses/search?location=' . $cityLocation .'&term=' . $localTerm;
     $headerValue = 'Bearer hImDWNahMLpPuAWPdg6C7VcYkzqyzImUBEO8tw1RJEqc_7-ZhZJmXpEyEn_amnIuUkfbfEwKLBk7DFPVlIbutFQIZ9HmrX2buqE5zCAeuS8XNjm2m7lsbUULvrf3WXYx';
     $headerKey = 'authorization';

     $data = GuzzleCurl::getApiResults($apiUrl, $headerValue, $headerKey);

       // $tab = array(
       //  'identifier' => $this->cacheId,
       //  'content'    => $content,
       //  'date_time'  => date('Y-m-d H:i:s'),
       //  'division'   => $this->division,
       //  'params'     => implode(' - ', $this->params)
       //  );

       // $testSaveData = $this->saveData();


     // $product = $this->$product;


     //  // look for a single Product by name
           //  // look for a single Product by name
     // $identifierValue = $data2->getIdentifier();


     // $test = $product->findOneBy(['name' => 'Keyboard']);

     //  print_r($identifierValue);

      // $produt->findOneBy(['identifier' => '53a5d5bd780a9da7bd52e45a22a4a1a211a70edf']);

     // print_r($product);



     $businessResults = array();
     foreach($data['businesses'] as $key => $busData)
     {
        $businessResults[] = array(
            'name' => $busData['name'],
            'display_phone' =>$busData['display_phone'],
            'location' => $busData['location']['display_address'],
            'image_url' =>$busData['image_url'],
            'id' => $busData['id'],
            'rating' => $busData['rating'],
            'alias' => $busData['alias'],
            'coordinates' => array(
                'latitude' => $busData['coordinates']['latitude'],
                'longitude' => $busData['coordinates']['longitude'],
                ),
            );
    }

    // $test = DbWrapper::get();

    $regionCordResults = array("region_coordinates" => $data['region']);
    $businessRegionResults = array(
        'region_cords' => $regionCordResults,
        'business_results' => $businessResults
        );
    return $businessRegionResults;
}


    /**
     * [getEndOfLOcalPlacesUrl On places URLs, we want to grab the end URL for when a user lands from local listings
     * So we can fetch a review via an ID.
     * @return String
     */
    public function getEndOfLocalPlacesUrl()
    {

        $urlPath = $_SERVER['REQUEST_URI'];

        $urlPathSplit = explode('/',$urlPath);
        $endPathSplit = end($urlPathSplit);

        return $endPathSplit;
    }


    /**
     * This endpoint returns detailed business content. Normally, you would get the Business ID from /businesses/search, /businesses/search/phone, /transactions/{transaction_type}/search or /autocomplete. To retrieve review excerpts for a business, please refer to our Reviews endpoint (/businesses/{id}/reviews)Note: at this time, the API does not return businesses without any reviews.
     * @param  [type] $localTerm    [description]
     * @param  [type] $cityLocation [description]
     * @example GET https://api.yelp.com/v3/businesses/{id}
     * @return [type]               [description]
     */
    public function getSingleBusinessResult($localTerm, $cityLocation)
    {
        $endOfUrl = $this->getEndOfLocalPlacesUrl();

        $apiUrl = 'https://api.yelp.com/v3/businesses/' . $endOfUrl;
        $headerValue = 'Bearer hImDWNahMLpPuAWPdg6C7VcYkzqyzImUBEO8tw1RJEqc_7-ZhZJmXpEyEn_amnIuUkfbfEwKLBk7DFPVlIbutFQIZ9HmrX2buqE5zCAeuS8XNjm2m7lsbUULvrf3WXYx';
        $headerKey = 'authorization';

        $businessSingle = GuzzleCurl::getApiResults($apiUrl, $headerValue, $headerKey);

        // dump($businessSingle);


        // $singleBusinessLocationresults = array();
        // foreach($businessSingle['location'] as $key => $busSingleLocation)
        // {
        //     $singleBusinessLocationresults[] = array(
        //        'display_address' => $busSingleLocation['display_address']
        //        );
        // }

        $singleBusinessCategoryresults = array();
        foreach($businessSingle['categories'] as $key => $busSingleCategorys)
        {
            $singleBusinessCategoryresults[] = array(
               'alias' => $busSingleCategorys['alias']
               );
        }


        $singleBusinessPhotoresults = array();
        foreach($businessSingle['photos'] as $key => $busSinglePhotos)
        {
            $singleBusinessPhotoResults[] = array(
               $key => $busSinglePhotos
               );
        }


        $singleBusinessResults[] = array(
            $businessSingle['id'],
            "alias" => $businessSingle['alias'],
            "name" => $businessSingle['name'],
            "image_url" => $businessSingle['image_url'],
            "is_claimed" => $businessSingle['is_claimed'],
            "is_closed" => $businessSingle['is_closed'],
            "url" =>  $businessSingle['url'],
            "phone" =>  $businessSingle['phone'],
            "display_phone" =>  $businessSingle['display_phone'],
            #This breaks if nothing set
            #"photos" => $singleBusinessPhotoResults,
            "categories" => $singleBusinessCategoryresults,
            'location' => $businessSingle['location']['display_address'],
            "review_count" =>  $businessSingle['review_count']
            );

        return $singleBusinessResults;




    }

    public function getBusinessReviews($localTerm, $cityLocation)
    {

        $endOfUrl = $this->getEndOfLocalPlacesUrl();

        $apiUrl = 'https://api.yelp.com/v3/businesses/' . $endOfUrl . '/reviews';
        $headerValue = 'Bearer hImDWNahMLpPuAWPdg6C7VcYkzqyzImUBEO8tw1RJEqc_7-ZhZJmXpEyEn_amnIuUkfbfEwKLBk7DFPVlIbutFQIZ9HmrX2buqE5zCAeuS8XNjm2m7lsbUULvrf3WXYx';
        $headerKey = 'authorization';

        $data = GuzzleCurl::getApiResults($apiUrl, $headerValue, $headerKey);



        $businessReviews = array();

        foreach($data['reviews'] as $key => $busReview)
        {
            $businessReviews[$busReview['id']] = array(
                'id' => $busReview['id'],
                'url' => $busReview['url'],
                'text' => $busReview['text'],
                'rating' => $busReview['rating'],
                'time_created' => $busReview['time_created'],
                $busReview['user'][$busReview['user']['name']] = array(
                    'name' => $busReview['user']['name'],
                    'profile_url' => $busReview['user']['profile_url'],
                    'image_url' => $busReview['user']['image_url'],
                    'profile_url' => $busReview['user']['profile_url'],
                    ),

                );
        }

        return $businessReviews;
    }


//    public function saveData()
//    {

//     if(!$this->getData())
//     {
//         $localCache = new LocalCache();

//         $locationParams = array('location' => 'cricklewood', 'localTerm' => 'hotels' );
//         $locationParamsSplit = explode(',', $locationParams );

//         $product  = $this->product;
//        // dump($singleBusinessResults);
//         $setIdentifier = $localCache->setIdentifier(rand(5,99));
//         $setIdentifier = $localCache->setContent('888');
//         $setIdentifier = $localCache->setDivision('777');
//         $setIdentifier = $localCache->setDatetime(new \DateTime());
//         $setIdentifier = $localCache->setParams( $locationParamsSplit );

//          $product->persist($setIdentifier);

//          $product->flush();
//     }

// }
}

