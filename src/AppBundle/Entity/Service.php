<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Sluggable;
use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as JMS;

use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Service
 *
 * @ORM\Table(name="services", indexes={@ORM\Index(name="fk_law_services_1_idx", columns={"service_category_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
{
    use Timestampable, Sluggable;

    /**
     * Unmapped property to handle file uploads
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMS\Groups({"detail", "list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=180, nullable=false)
     * @JMS\Groups({"detail", "list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", length=65535, nullable=false)
     * @JMS\Groups({"detail", "list"})
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     * @JMS\Groups({"detail"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=512, nullable=true)
     * @JMS\Groups({"detail", "list"})
     */
    private $imageUrl;

    /**
     * @var ServiceCategory
     *
     * @ORM\ManyToOne(targetEntity="ServiceCategory", inversedBy="services")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_category_id", referencedColumnName="id")
     * })
     *
     * @JMS\Exclude
     */
    private $serviceCategory;

    /**
     * @ORM\OneToMany(targetEntity="ServiceModification", mappedBy="service", fetch="EAGER")
     * @ORM\OrderBy({"price" = "ASC"})
     * @JMS\Groups({"detail"})
     */
    private $serviceModifications;

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
     * @param \AppBundle\Entity\ServiceCategory $serviceCategory
     *
     * @return Service
     */
    public function setServiceCategory(\AppBundle\Entity\ServiceCategory $serviceCategory = null)
    {
        $this->serviceCategory = $serviceCategory;

        return $this;
    }

    /**
     * Get serviceCategory
     *
     * @return \AppBundle\Entity\ServiceCategory
     */
    public function getServiceCategory()
    {
        return $this->serviceCategory;
    }

    /**
     * @return mixed
     */
    public function getServiceModifications()
    {
        return $this->serviceModifications;
    }

    /**
     * @param mixed $serviceModifications
     */
    public function setServiceModifications($serviceModifications)
    {
        $this->serviceModifications = $serviceModifications;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setImage(UploadedFile $file = null)
    {
        $this->image = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    // Следующие методы используются для ApiController
    // Нужна такиех бессмысленных методов возникла из-за того
    // что временные метки и слаг вынесены в трейты.
    // к ним не получится написать "универсальные" аннотации

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("service_category")
     * @JMS\Groups({"detail", "list"})
     */
    public function getCategoryId()
    {
        return $this->getServiceCategory()->getId();
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("created_at")
     * @JMS\Groups({"detail", "list"})
     */
    public function getCreatedAtValue()
    {
        return $this->getCreatedAt();
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("updated_at")
     * @JMS\Groups({"detail", "list"})
     */
    public function getUpdatedAtValue()
    {
        return $this->getUpdatedAt();
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("slug")
     * @JMS\Groups({"detail", "list"})
     */
    public function getSlugValue()
    {
        return $this->getSlug();
    }
}
