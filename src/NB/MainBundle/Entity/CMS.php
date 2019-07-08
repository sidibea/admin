<?php

namespace NB\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CMS
 *
 * @ORM\Table(name="c_m_s")
 * @ORM\Entity(repositoryClass="NB\MainBundle\Repository\CMSRepository")
 */
class CMS
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
     * @ORM\Column(name="Termes_conditions", type="text", nullable=true)
     */
    private $termesConditions;

    /**
     * @var string
     *
     * @ORM\Column(name="Politique_confidentialite", type="text", nullable=true)
     */
    private $politiqueConfidentialite;

    /**
     * @var string
     *
     * @ORM\Column(name="Professionel", type="text", nullable=true)
     */
    private $professionel;

    /**
     * @var string
     *
     * @ORM\Column(name="Modification_voyage", type="text", nullable=true)
     */
    private $modificationVoyage;

    /**
 * @var string
 *
 * @ORM\Column(name="Annulation_voyage", type="text", nullable=true)
 */
    private $annulationVoyage;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set termesConditions
     *
     * @param string $termesConditions
     *
     * @return CMS
     */
    public function setTermesConditions($termesConditions)
    {
        $this->termesConditions = $termesConditions;
    
        return $this;
    }

    /**
     * Get termesConditions
     *
     * @return string
     */
    public function getTermesConditions()
    {
        return $this->termesConditions;
    }

    /**
     * Set politiqueConfidentialite
     *
     * @param string $politiqueConfidentialite
     *
     * @return CMS
     */
    public function setPolitiqueConfidentialite($politiqueConfidentialite)
    {
        $this->politiqueConfidentialite = $politiqueConfidentialite;
    
        return $this;
    }

    /**
     * Get politiqueConfidentialite
     *
     * @return string
     */
    public function getPolitiqueConfidentialite()
    {
        return $this->politiqueConfidentialite;
    }

    /**
     * Set professionel
     *
     * @param string $professionel
     *
     * @return CMS
     */
    public function setProfessionel($professionel)
    {
        $this->professionel = $professionel;
    
        return $this;
    }

    /**
     * Get professionel
     *
     * @return string
     */
    public function getProfessionel()
    {
        return $this->professionel;
    }

    /**
     * @return string
     */
    public function getModificationVoyage()
    {
        return $this->modificationVoyage;
    }

    /**
     * @param string $modificationVoyage
     */
    public function setModificationVoyage($modificationVoyage)
    {
        $this->modificationVoyage = $modificationVoyage;
    }

    /**
     * @return string
     */
    public function getAnnulationVoyage()
    {
        return $this->annulationVoyage;
    }

    /**
     * @param string $annulationVoyage
     */
    public function setAnnulationVoyage($annulationVoyage)
    {
        $this->annulationVoyage = $annulationVoyage;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}

