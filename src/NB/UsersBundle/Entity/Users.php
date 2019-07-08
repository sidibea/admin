<?php

namespace NB\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="NB\UsersBundle\Repository\UsersRepository")
 */
class Users extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", nullable=true, type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", nullable=true, type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mob", nullable=true, type="string", length=255)
     */
    private $mob;

    /**
     * @var string
     *
     * @ORM\Column(name="dob", nullable=true, type="string", length=14)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_agence", nullable=true, type="string", length=14)
     */
    private $nomAgence;

    /**
     * @var string
     *
     * @ORM\Column(name="nina", nullable=true, type="string", length=14)
     */
    private $numeroNina;

    /**
     * @var string
     *
     * @ORM\Column(name="nif", nullable=true, type="string", length=14)
     */
    private $nif;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", nullable=true, type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", nullable=true, type="string", length=255)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", nullable=true, type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Commune",  cascade={"persist", "remove"})
     */
    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Quartier",  cascade={"persist", "remove"})
     */
    private $quartier;


    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @param mixed $commune
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;
    }

    /**
     * @return mixed
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * @param mixed $quartier
     */
    public function setQuartier($quartier)
    {
        $this->quartier = $quartier;
    }



    /**
     * @return string
     */
    public function getNomAgence()
    {
        return $this->nomAgence;
    }

    /**
     * @param string $nomAgence
     */
    public function setNomAgence($nomAgence)
    {
        $this->nomAgence = $nomAgence;
    }

    /**
     * @return string
     */
    public function getNumeroNina()
    {
        return $this->numeroNina;
    }

    /**
     * @param string $numeroNina
     */
    public function setNumeroNina($numeroNina)
    {
        $this->numeroNina = $numeroNina;
    }

    /**
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * @param string $nif
     */
    public function setNif($nif)
    {
        $this->nif = $nif;
    }






    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }



    /**
     * @return string
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param string $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }




    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }




    /**
     * @return string
     */
    public function getMob()
    {
        return $this->mob;
    }

    /**
     * @param string $mob
     */
    public function setMob($mob)
    {
        $this->mob = $mob;
    }






    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function  __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_SEATSELLER');
    }



    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }




}