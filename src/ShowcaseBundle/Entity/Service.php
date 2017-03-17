<?php

namespace ShowcaseBundle\Entity;

use Common\Traits\Sluggable;
use Common\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="services", indexes={@ORM\Index(name="fk_law_services_1_idx", columns={"service_category_id"})})
 * @ORM\Entity
 */
class Service
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
     * @ORM\Column(name="title", type="string", length=180, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", length=65535, nullable=false)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=512, nullable=true)
     */
    private $imageUrl;

    /**
     * @var ServiceCategory
     *
     * @ORM\ManyToOne(targetEntity="ServiceCategory", inversedBy="services")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_category_id", referencedColumnName="id")
     * })
     */
    private $serviceCategory;

    /**
     * @ORM\OneToMany(targetEntity="ServiceModification", mappedBy="service", fetch="EAGER")
     * @ORM\OrderBy({"price" = "ASC"})
     */
    private $modifications;

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
     * Set title
     *
     * @param string $title
     *
     * @return Service
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Service
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Service
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
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Service
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set serviceCategory
     *
     * @param \ShowcaseBundle\Entity\ServiceCategory $serviceCategory
     *
     * @return Service
     */
    public function setServiceCategory(\ShowcaseBundle\Entity\ServiceCategory $serviceCategory = null)
    {
        $this->serviceCategory = $serviceCategory;

        return $this;
    }

    /**
     * Get serviceCategory
     *
     * @return \ShowcaseBundle\Entity\ServiceCategory
     */
    public function getServiceCategory()
    {
        return $this->serviceCategory;
    }

    /**
     * @return mixed
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * @param mixed $modifications
     */
    public function setModifications($modifications)
    {
        $this->modifications = $modifications;
    }
}
