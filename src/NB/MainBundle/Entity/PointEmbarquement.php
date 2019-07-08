<?php

namespace NB\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointEmbarquement
 *
 * @ORM\Table(name="point_embarquement")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\PointEmbarquementRepository")
 */
class PointEmbarquement
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
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Compagnie", cascade={"persist", "remove"})
     */
    private $compagnie;

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
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="lattitude", type="string", length=255, nullable=true)
     */
    private $lattitude;


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
     * @return boolean
     */
    public function isIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return PointEmbarquement
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
     * Set compagnie
     *
     * @param string $compagnie
     *
     * @return PointEmbarquement
     */
    public function setCompagnie($compagnie)
    {
        $this->compagnie = $compagnie;

        return $this;
    }

    /**
     * Get compagnie
     *
     * @return string
     */
    public function getCompagnie()
    {
        return $this->compagnie;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PointEmbarquement
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
     * @return PointEmbarquement
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
     * Set longitude
     *
     * @param string $longitude
     *
     * @return PointEmbarquement
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lattitude
     *
     * @param string $lattitude
     *
     * @return PointEmbarquement
     */
    public function setLattitude($lattitude)
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    /**
     * Get lattitude
     *
     * @return string
     */
    public function getLattitude()
    {
        return $this->lattitude;
    }
}

