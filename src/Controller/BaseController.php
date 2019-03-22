<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\NewsApi;
use App\Utils\GuzzleCurl;

use App\Service\YelpLocal;

use Symfony\Component\Routing\Annotation\Route;


class BaseController extends AbstractController
{

    /**
        * @Route("/local/search/", name="local_search_results")
        */
    public function searchLocalResults(YelpLocal $local,NewsApi $news)
    {

        $localAreaResults = $this->getLocalArea();

        $localBusinessResults = $local->getBusinessResults($localAreaResults['local_term'], $localAreaResults['city_location']);

           $localNewsResults = $news->getNewsResultsFeed();




       return $this->render('local_search_results/search.html.twig', [
            #cached array
          // 'local_results' => $productCacheContent,
          'local_results' => $localBusinessResults,
          'local_term_results' => $localAreaResults,
          'local_news_results' => $localNewsResults,
          // 'region_cords' => $regionCenterCords
          ]);
    }

    public function searchLocalResults2($local)
    {
      $test = $this->searchLocalResults($local);

        return $test;
    }



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
    public function singleLocalPlace()
    {
       return $this->render('local_search_results/local-place-one.html.twig');
    }

}


