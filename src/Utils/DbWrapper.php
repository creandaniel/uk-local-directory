<?php

namespace App\Utils;

use App\Entity\LocalCache;



use Doctrine\ODM\PHPCR\Query\QueryException;
use Doctrine\ORM\Mapping as ORM;




class DbWrapper
{
    public static function get()
    {


        $dbTable = 'local_cache';
        $content = '*';
        $whereContent =  'identifier';
        $IdentifierTerm = "'53a5d5bd780a9da7bd52e45a22a4a1a211a70ed'";

        $dbcache = new LocalCache();
   


        // $product = $dbcache->findOneBy(['identifier' => '53a5d5bd780a9da7bd52e45a22a4a1a211a70edf']);

        /**
         * [$areaValuesStrippedKeys unseriliaze data sot it can be stored as string in params data field]
         * @var array
         */
        // $areaValuesStrippedKeys = array_values($localAreaResults);

        // $localValuesSeperated = implode($areaValuesStrippedKeys, ', ');

        echo $repository = $dbcache->getIdentifier('53a5d5bd780a9da7bd52e45a22a4a1a211a70edf');

        print_r($repository);



        $sql = 'SELECT ' . $content . ' FROM ' . $dbTable . ' WHERE ' . $whereContent . ' = ' . $IdentifierTerm;

        // echo $sql;


        return $repository;
    }
}