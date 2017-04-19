<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Sluggable;
use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * ServiceCategory
 *
 * @ORM\Table(name="services_categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceCategoryRepository")
 */
class ServiceCategory
{
    use Timestampable, Sluggable;

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
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="serviceCategory")
     * @JMS\Exclude
     */
    private $services;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_available", type="boolean", nullable=false)
     */
    private $isAvailable = 1;

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
     * @param string $title
     *
     * @return ServiceCategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    public function getServices()
    {
        return $this->services;
    }

    public function setServices($service)
    {
        $this->services = $service;
    }

    /**
     * @return boolean
     */
    public function isIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    /**
     * @param boolean $isAvailable
     */
    public function setIsAvailable(bool $isAvailable)
    {
        $this->isAvailable = $isAvailable;
    }
}
