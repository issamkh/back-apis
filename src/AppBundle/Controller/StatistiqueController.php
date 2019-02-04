<?php
/**
 * Created by PhpStorm.
 * User: issam
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




class StatistiqueController extends  FOSRestController {


    /**
     * @Rest\Get("/statistique/{id}" , name="show_statistique")
     * @Rest\View
     */
    public function showPoidsByCatAction(Categorie $categorie ){


         $poidsTotal = 0;
        if(!empty($categorie)){
            foreach($categorie->getElements() as $element){
                $poidsTotal = $poidsTotal + $element->getPoids();
            }
            return $poidsTotal;

        }else{
            return $poidsTotal;
        }



    }





} 