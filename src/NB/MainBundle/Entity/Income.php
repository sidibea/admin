<?php

namespace NB\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Income
 *
 * @ORM\Table(name="income")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\IncomeRepository")
 */
class Income
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_recharge", type="datetime")
     */
    private $dateRecharge;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="NB\UsersBundle\Entity\Users", cascade={"persist"})
     */
    private $seatseller;


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
     * @return mixed
     */
    public function getSeatseller()
    {
        return $this->seatseller;
    }

    /**
     * @param mixed $seatseller
     */
    public function setSeatseller($seatseller)
    {
        $this->seatseller = $seatseller;
    }





    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return Income
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
     * Set dateRecharge
     *
     * @param \DateTime $dateRecharge
     *
     * @return Income
     */
    public function setDateRecharge($dateRecharge)
    {
        $this->dateRecharge = $dateRecharge;

        return $this;
    }

    /**
     * Get dateRecharge
     *
     * @return \DateTime
     */
    public function getDateRecharge()
    {
        return $this->dateRecharge;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Income
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

