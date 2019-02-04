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




class CategorieController extends  FOSRestController {


    /**
     * @Rest\Get("/categories" , name="show_categories")
     * @Rest\View
     */
    public function showCategoriesAction(){

        $categories = $this->getDoctrine()->getRepository("AppBundle:Categorie")->findAll();
        //-------si aucune catégorie on retourn une réponse
        if(empty($categories)){

            return $this->view("there are no categorie exist", Response::HTTP_NOT_FOUND);
        }

        return $categories;

    }


    /**
     * @Rest\Get("/categories/{id}" , name="show_categorie")
     * @Rest\View
     */
    public function showCategorieAction(Categorie $categorie = null){


        //-------si aucune catégorie on retourn une réponse
        if(empty($categorie)){

            return $this->view("there are no categorie exist", Response::HTTP_NOT_FOUND);
        }

        return $categorie;

    }



    /**
     * @Rest\Post("/categories" , name="create_categorie")
     * @Rest\View
     * @ParamConverter("categorie", converter="fos_rest.request_body")
     */
    public function creatCategorieAction(Categorie $categorie){


        /*---1: j'ai utilisé le body converter de FOSRestBundle ç'a permet de deserialiser directement
                le body request en objet et je l'ai injecter au controlleur directement avec paramConverter */

        //---2 : pour valider notre objet  avec le service validator de symfony
        $errors = $this->get('validator')->validate($categorie);

        if(count($errors)){
            return $this->view($errors,Response::HTTP_BAD_REQUEST);
        }

        //----3:   service qui se charge de la persistance de données
        $this->get('app.categorie_manager')->create($categorie);

        return $this->view("Categorie created with success " , 200);

    }

    /**
     * @Rest\Put("/categories/{id}" , name="update_categorie" , requirements = {"id"="\d+"})
     * @Rest\View
     * @ParamConverter("apicategorie", converter="fos_rest.request_body")
     */
    public function updateCategorieAction(Categorie $categorie = null , Categorie $apicategorie){

        //-------si aucune catégorie on retourn une réponse
        if(empty($categorie)){

            return $this->view("there are no categorie exist", Response::HTTP_NOT_FOUND);
        }

        //----- pour valider notre objet
        $errors = $this->get('validator')->validate($apicategorie);

        if(count($errors)){
            return $this->view($errors,Response::HTTP_BAD_REQUEST);
        }

        //----  un update de l'ancien objet avec le nouvel objet
        $this->get('app.categorie_manager')->update($categorie,$apicategorie);

        return $this->view("Categorie updated with success " , 200);

    }

    /**
     * @Rest\Delete("/categories/{id}" , name="delete_categorie" , requirements = {"id"="\d+"})
     * @Rest\View
     */
    public function deleteCategorieAction(Categorie $categorie = null){

        //-------si aucune catégorie on retourn une réponse
        if(empty($categorie)){

            return $this->view("there are no categorie exist", Response::HTTP_NOT_FOUND);
        }

        //-------- pour supprimer notre objet
        $this->get('app.categorie_manager')->remove($categorie);

        return $this->view("Categorie removed with success " , 200);

    }


} 