<?php
/**
 * Created by PhpStorm.
 * User: issam
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class ElementController extends FOSRestController{

    /**
     * @Rest\Get("/elements" , name="show_elements")
     * @Rest\View
     */
    public function showCategoriesAction(){

        $elements = $this->getDoctrine()->getRepository("AppBundle:Element")->findAll();
        //-------si aucune catégorie on retourn une réponse
        if(empty($elements)){

            return $this->view("no element exist", Response::HTTP_NOT_FOUND);
        }

        return $elements;

    }

    /**
     * @Rest\Get("/elements/{id}" , name="show_element")
     * @Rest\View
     */
    public function showElementAction(Element $element = null){


        //-------si aucun element on retourn une réponse
        if(empty($element)){

            return $this->view("there are no element exist", Response::HTTP_NOT_FOUND);
        }

        return $element;

    }

    /**
     * @Rest\Post("/categorie/{id}/elements" , name="create_element")
     * @Rest\View
     * @ParamConverter("element", converter="fos_rest.request_body")
     */
    public function creatElementAction(Element $element,Categorie $categorie){

        /*---1: j'ai utilisé le body converter de FOSRestBundle ç'a permet de deserialiser directement
                le body request en objet et je l'ai injecter au controlleur directement avec paramConverter */

        //---2 : pour valider notre objet  avec le service validator de symfony
        $errors = $this->get('validator')->validate($element);

        if(count($errors)){
            return $this->view($errors,Response::HTTP_BAD_REQUEST);
        }

        //----3:   service qui se charge de la persistance de données
        $this->get('app.element_manager')->create($element,$categorie);

        return $this->view("Element created with success " , 200);

    }


    /**
     * @Rest\Put("/categorie/{idCat}/elements/{idElement}" , name="update_element" , requirements = {"id"="\d+"})
     * @Rest\View
     * @ParamConverter("categorie", options={"id" = "idCat"})
     * @ParamConverter("element", options={"id" = "idElement"})
     * @ParamConverter("apielement", converter="fos_rest.request_body")
     */
    public function updateCategorieAction(Element $element = null ,Categorie $categorie = null, Element $apielement){

        //-------si aucune catégorie on retourn une réponse
        if(empty($categorie) || empty($element)){

            return $this->view("there are no element exist or no categorie", Response::HTTP_NOT_FOUND);
        }

        //----- pour valider notre objet
        $errors = $this->get('validator')->validate($apielement);

        if(count($errors)){
            return $this->view($errors,Response::HTTP_BAD_REQUEST);
        }

        //----  un update de l'ancien objet avec le nouvel objet
        $this->get('app.element_manager')->update($element,$apielement,$categorie);

        return $this->view("Element updated with success " , 200);

    }

    /**
     * @Rest\Delete("/elements/{id}" , name="delete_element" , requirements = {"id"="\d+"})
     * @Rest\View
     */
    public function deleteCategorieAction(Element $element = null){

        //-------si aucun element on retourn une réponse
        if(empty($element)){

            return $this->view("there are no element exist", Response::HTTP_NOT_FOUND);
        }

        //-------- pour supprimer notre objet
        $this->get('app.element_manager')->remove($element);

        return $this->view("Element removed with success " , 200);

    }





} 