<?php

namespace ShowcaseBundle\Entity;

use Common\Traits\Sluggable;
use Common\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceCategory
 *
 * @ORM\Table(name="services_categories")
 * @ORM\Entity
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
     */
    private $services;

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
}
