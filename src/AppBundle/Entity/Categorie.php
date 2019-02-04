<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="priorite", type="integer")
     * @Assert\NotBlank
     *  @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Il faut choisir une priorite minimum egale a {{ limit }}",
     *      maxMessage = "Il faut choisir une priorit emaximum egale a {{ limit }}"
     * )
     */
    private $priorite;

    /**
     * @ORM\OneToMany(targetEntity="Element" , mappedBy="categorie" , cascade={"persist","remove"});
     */
    private $elements;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set priorite
     *
     * @param integer $priorite
     *
     * @return Categorie
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite
     *
     * @return int
     */
    public function getPriorite()
    {
        return $this->priorite;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add element
     *
     * @param \AppBundle\Entity\Element $element
     *
     * @return Categorie
     */
    public function addElement(\AppBundle\Entity\Element $element)
    {
        $this->elements[] = $element;
        $element->setCategorie($this);

        return $this;
    }

    /**
     * Remove element
     *
     * @param \AppBundle\Entity\Element $element
     */
    public function removeElement(\AppBundle\Entity\Element $element)
    {
        $this->elements->removeElement($element);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function update(Categorie $categorie)
    {
        $this->nom = $categorie->nom;
        $this->priorite = $categorie->priorite;
    }
}
