<?php

namespace Proxies\__CG__\NB\MainBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Promotion extends \NB\MainBundle\Entity\Promotion implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'id', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'montant', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'code', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'photo', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'description', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'dateDebut', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'dateFin', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'axes', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'canal', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'compagnie', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'createdAt', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'updatedAt'];
        }

        return ['__isInitialized__', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'id', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'montant', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'code', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'photo', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'description', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'dateDebut', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'dateFin', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'axes', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'canal', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'compagnie', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'createdAt', '' . "\0" . 'NB\\MainBundle\\Entity\\Promotion' . "\0" . 'updatedAt'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Promotion $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setMontant($montant)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMontant', [$montant]);

        return parent::setMontant($montant);
    }

    /**
     * {@inheritDoc}
     */
    public function getMontant()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMontant', []);

        return parent::getMontant();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateDebut($dateDebut)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateDebut', [$dateDebut]);

        return parent::setDateDebut($dateDebut);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateDebut()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateDebut', []);

        return parent::getDateDebut();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateFin($dateFin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateFin', [$dateFin]);

        return parent::setDateFin($dateFin);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateFin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateFin', []);

        return parent::getDateFin();
    }

    /**
     * {@inheritDoc}
     */
    public function setAxes($axes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAxes', [$axes]);

        return parent::setAxes($axes);
    }

    /**
     * {@inheritDoc}
     */
    public function getAxes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAxes', []);

        return parent::getAxes();
    }

    /**
     * {@inheritDoc}
     */
    public function setCanal($canal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCanal', [$canal]);

        return parent::setCanal($canal);
    }

    /**
     * {@inheritDoc}
     */
    public function getCanal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCanal', []);

        return parent::getCanal();
    }

    /**
     * {@inheritDoc}
     */
    public function setCompagnie($compagnie)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCompagnie', [$compagnie]);

        return parent::setCompagnie($compagnie);
    }

    /**
     * {@inheritDoc}
     */
    public function getCompagnie()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCompagnie', []);

        return parent::getCompagnie();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', [$createdAt]);

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', []);

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', [$updatedAt]);

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCode', []);

        return parent::getCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setCode($code)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCode', [$code]);

        return parent::setCode($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPhoto', []);

        return parent::getPhoto();
    }

    /**
     * {@inheritDoc}
     */
    public function setPhoto($photo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPhoto', [$photo]);

        return parent::setPhoto($photo);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', []);

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', [$description]);

        return parent::setDescription($description);
    }

}
