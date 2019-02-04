<?php
/**
 * Created by PhpStorm.
 * User: issam
 */

namespace AppBundle;


use AppBundle\Entity\Categorie;
use AppBundle\Entity\Element;
use Doctrine\ORM\EntityManagerInterface;

class updateElement {

    private $em;

    public function __construct(EntityManagerInterface $entityManager){

        $this->em = $entityManager;

    }

    public function create(Element $element,Categorie $categorie)
    {
        $element->setCategorie($categorie);
        $this->em->persist($element);

        $this->em->flush();

    }
    public function update(Element $element, Element $apielement,Categorie $categorie)
    {
        $element->update($apielement,$categorie);

        $this->em->flush();
    }


    public function remove(Element $element){

        $this->em->remove($element);
        $this->em->flush();
    }

} 