<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Utils\GuzzleCurl;
use App\Service\YelpLocal;
use App\Service\NewsApi;

use Doctrine\ODM\PHPCR\Query\QueryException;
use Doctrine\ORM\Mapping as ORM;

// use App\Entity\LocalCache;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class LocalSearchResultsController extends AbstractController
{

    /**
    * @Route("/local/search/", name="local_search_results")
     */
    /**
     * [searchLocalResults fetch the local term and location of a place and return to view
     * @param  YelpLocal $local Array
     * @param  NewsApi   $news  Array
     * @return Array           Return a combination of local results per area, the location and other API feeds to populate teh site.
     */
    public function searchLocalResults(YelpLocal $local, NewsApi $news)
    {

      $localAreaResults = $this->getLocalArea();

      $localBusinessResults = $local->getBusinessResults($localAreaResults['local_term'], $localAreaResults['city_location']);

      $localNewsResults = $news->getNewsResultsFeed();

      // $locationObject = $test->getIdentifier('53a5d5bd780a9da7bd52e45a22a4a1a211a70edf');


      return $this->render('local_search_results/search.html.twig', [
            #cached array
          // 'local_results' => $productCacheContent,
        'local_results' => $localBusinessResults,
        'local_term_results' => $localAreaResults,
        'local_news_results' => $localNewsResults,
        ]);
    }


    /**
     * [getLocalArea We pul in the local area via a get request and return a default as Finchley if nothing is set.
     * @return string
     */
    public function getLocalArea()
    {

      if(isset($_GET['localTerm']))
      {
        $localTerm = htmlspecialchars($_GET['localTerm']);
      }else {
        $localTerm = 'cafes';
      }

      if(isset($_GET['cityLocation']))
      {
        $cityLocation = htmlspecialchars($_GET['cityLocation']);
      }else {
        $cityLocation = "Finchley";
      }



      $localTermResults = array(
        'local_term' => $localTerm,
        'city_location' => $cityLocation
        );

      return $localTermResults;
    }



      /**
      * @Route("/local/places/{id}", name="local_place_result")
      */
     /**
      * [singleLocalPlace Local result of when a visitor click on a result via search pages on earchLocalResults(.
      * @param  YelpLocal $localReviews 
      * @param  NewsApi   $news         
      * @return Array                 
      */
     public function singleLocalPlace(YelpLocal $localReviews, NewsApi $news)
     {
      $localBusinessReviews = $localReviews->getBusinessReviews('' , '');

      $localSingleBusiness = $localReviews->getSingleBusinessResult('', '');

      $localNewsResults = $news->getNewsResultsFeed();

      return $this->render('local_search_results/local-place-one.html.twig', [
        'review_results' =>  $localBusinessReviews,
        'local_news_results' => $localNewsResults,
        'local_business_result' => $localSingleBusiness
        ]);
    }

  }




