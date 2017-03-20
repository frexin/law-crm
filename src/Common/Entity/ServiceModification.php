<?php

namespace Common\Entity;

use Common\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceModification
 *
 * @ORM\Table(name="services_modifications", indexes={@ORM\Index(name="fk_law_orders_modifications_1_idx", columns={"service_id"})})
 * @ORM\Entity
 */
class ServiceModification
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=180, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="time_limit", type="string", length=100, nullable=false)
     */
    private $timeLimit;

    /**
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="serviceModifications")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $service;



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
     * Set name
     *
     * @param string $name
     *
     * @return ServiceModification
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return ServiceModification
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ServiceModification
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
     * Set timeLimit
     *
     * @param string $timeLimit
     *
     * @return ServiceModification
     */
    public function setTimeLimit($timeLimit)
    {
        $this->timeLimit = $timeLimit;

        return $this;
    }

    /**
     * Get timeLimit
     *
     * @return string
     */
    public function getTimeLimit()
    {
        return $this->timeLimit;
    }

    /**
     * Set service
     *
     * @param \Common\Entity\Service $service
     *
     * @return ServiceModification
     */
    public function setService(\Common\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Common\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }
}
