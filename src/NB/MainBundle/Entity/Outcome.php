<?php

namespace NB\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Outcome
 *
 * @ORM\Table(name="outcome")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\OutcomeRepository")
 */
class Outcome
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
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=3)
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="NB\UsersBundle\Entity\Users", cascade={"persist"})
     */
    private $seatseller;

    /**
     * @ORM\ManyToOne(targetEntity="NB\MainBundle\Entity\Reservation", cascade={"persist"})
     */
    private $reservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_paiement", type="datetime")
     */
    private $datePaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


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
     * Set montant
     *
     * @param string $montant
     *
     * @return Outcome
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set seatseller
     *
     * @param string $seatseller
     *
     * @return Outcome
     */
    public function setSeatseller($seatseller)
    {
        $this->seatseller = $seatseller;

        return $this;
    }

    /**
     * Get seatseller
     *
     * @return string
     */
    public function getSeatseller()
    {
        return $this->seatseller;
    }

    /**
     * Set reservation
     *
     * @param string $reservation
     *
     * @return Outcome
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return string
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set datePaiement
     *
     * @param \DateTime $datePaiement
     *
     * @return Outcome
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return \DateTime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Outcome
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
}

