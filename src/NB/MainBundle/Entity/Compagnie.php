<?php

namespace NB\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NB\UsersBundle\Entity\Users;

/**
 * Compagnie
 *
 * @ORM\Table(name="compagnie")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\CompagnieRepository")
 */
class Compagnie
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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="text", nullable=true)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=22, unique=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="metatitre", nullable=true, type="text")
     */
    private $metatitre;

    /**
     * @var string
     *
     * @ORM\Column(name="metadescription", type="text", nullable=true)
     */
    private $metadescription;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_cle", type="text", nullable=true)
     */
    private $motCle;

    /**
     * @var string
     *
     * @ORM\Column(name="commission", type="integer")
     */
    private $commission;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", nullable=true, length=255)
     */
    private $logo;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true, length=255)
     */
    private $email;

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
     * @ORM\ManyToMany(targetEntity="NB\UsersBundle\Entity\Users", cascade={"persist", "remove"})
     */
    private $users;

    public function __construct(){
        $this->users = new ArrayCollection();
    }
    public function setUsers(Users $users = null)
    {
        $this->users = $users;
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addUsers(Users $users)
    {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau
        $this->users[] = $users;

        return $this;
    }

    public function removeUsers(Users $users)
    {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->users->removeElement($users);
    }

    // Notez le pluriel, on récupère une liste de catégories ici !
    public function getUsers()
    {
        return $this->users;
    }


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
     * @return Compagnie
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Compagnie
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Compagnie
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Compagnie
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set metatitre
     *
     * @param string $metatitre
     *
     * @return Compagnie
     */
    public function setMetatitre($metatitre)
    {
        $this->metatitre = $metatitre;

        return $this;
    }

    /**
     * Get metatitre
     *
     * @return string
     */
    public function getMetatitre()
    {
        return $this->metatitre;
    }

    /**
     * Set metadescription
     *
     * @param string $metadescription
     *
     * @return Compagnie
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;

        return $this;
    }

    /**
     * Get metadescription
     *
     * @return string
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }

    /**
     * Set motCle
     *
     * @param string $motCle
     *
     * @return Compagnie
     */
    public function setMotCle($motCle)
    {
        $this->motCle = $motCle;

        return $this;
    }

    /**
     * Get motCle
     *
     * @return string
     */
    public function getMotCle()
    {
        return $this->motCle;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Compagnie
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Compagnie
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Compagnie
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
     * @return Compagnie
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Compagnie
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

    /**
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * @param string $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }


}

