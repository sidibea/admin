<?php

namespace NB\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voyages
 *
 * @ORM\Table(name="voyages")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\VoyagesRepository")
 */
class Voyages
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
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Axes", cascade={"persist", "remove"})
     */
    private $axes;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Compagnie", cascade={"persist", "remove"})
     */
    private $compagnie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_depart", type="time")
     */
    private $heureDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_arrivee", type="time")
     */
    private $heureArrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity="NB\MainBundle\Entity\PointEmbarquement", cascade={"persist", "remove"})
     */
    private $pointEmbarquement;

    public function __construct(){
        $this->pointEmbarquement = new ArrayCollection();
    }
    public function setPointEmbarquement(PointEmbarquement $pointEmbarquement = null)
    {
        $this->pointEmbarquement = $pointEmbarquement;
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addPointEmbarquement(PointEmbarquement $pointEmbarquement)
    {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau
        $this->pointEmbarquement[] = $pointEmbarquement;

        return $this;
    }

    public function removePointEmbarquement(PointEmbarquement $pointEmbarquement)
    {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer le point d'embarquement en argument
        $this->pointEmbarquement->removeElement($pointEmbarquement);
    }

    // Notez le pluriel, on récupère une liste de catégories ici !
    public function getPointEmbarquement()
    {
        return $this->pointEmbarquement;
    }

    /**
     * @return mixed
     */
    public function getCompagnie()
    {
        return $this->compagnie;
    }

    /**
     * @param mixed $compagnie
     */
    public function setCompagnie($compagnie)
    {
        $this->compagnie = $compagnie;
    }





    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


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
     * Set axes
     *
     * @param string $axes
     *
     * @return Voyages
     */
    public function setAxes($axes)
    {
        $this->axes = $axes;

        return $this;
    }

    /**
     * Get axes
     *
     * @return string
     */
    public function getAxes()
    {
        return $this->axes;
    }

    /**
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param string $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }



    /**
     * Set heureDepart
     *
     * @param \DateTime $heureDepart
     *
     * @return Voyages
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }



    /**
     * Get heureDepart
     *
     * @return \DateTime
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set heureArrivee
     *
     * @param \DateTime $heureArrivee
     *
     * @return Voyages
     */
    public function setHeureArrivee($heureArrivee)
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get heureArrivee
     *
     * @return \DateTime
     */
    public function getHeureArrivee()
    {
        return $this->heureArrivee;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Voyages
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return Voyages
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Voyages
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Voyages
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Voyages
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}

