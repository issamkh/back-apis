<?php
/**
 * Created by PhpStorm.
 * User: issam
 */

namespace AppBundle;


use AppBundle\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;

class updateCategorie {


    private $em;

    public function __construct(EntityManagerInterface $entityManager){

        $this->em = $entityManager;

    }

    public function create(Categorie $categorie)
    {
        $this->em->persist($categorie);

        $this->em->flush();

    }
    public function update(Categorie $categorie, Categorie $apiCategorie)
    {
        $categorie->update($apiCategorie);

        $this->em->flush();
    }


    public function remove(Categorie $categorie){

        $this->em->remove($categorie);
        $this->em->flush();
    }


} 