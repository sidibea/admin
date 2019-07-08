<?php

namespace NB\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NB\UsersBundle\Entity\Users;

/**
 * Seatseller
 *
 * @ORM\Table(name="seatseller")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\SeatsellerRepository")
 */
class Seatseller
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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agence", type="string", length=255)
     */
    private $nomAgence;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Ville", cascade={"persist", "remove"})
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Commune", cascade={"persist", "remove"})
     */
    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Quartier", cascade={"persist", "remove"})
     */
    private $quartier;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_nina", type="string", length=255, nullable=true)
     */
    private $numero_nina;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

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
     * @return string
     */
    public function getNumeroNina()
    {
        return $this->numero_nina;
    }

    /**
     * @param string $numero_nina
     */
    public function setNumeroNina($numero_nina)
    {
        $this->numero_nina = $numero_nina;
    }



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Seatseller
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Seatseller
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nomAgence
     *
     * @param string $nomAgence
     *
     * @return Seatseller
     */
    public function setNomAgence($nomAgence)
    {
        $this->nomAgence = $nomAgence;

        return $this;
    }

    /**
     * Get nomAgence
     *
     * @return string
     */
    public function getNomAgence()
    {
        return $this->nomAgence;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Seatseller
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return Seatseller
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set quartier
     *
     * @param string $quartier
     *
     * @return Seatseller
     */
    public function setQuartier($quartier)
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * Get quartier
     *
     * @return string
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Seatseller
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Seatseller
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Seatseller
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
     * @return Seatseller
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
     * @return Seatseller
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

