<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * LawOrders
 *
 * @ORM\Table(name="law_orders", indexes={@ORM\Index(name="orders_status_idx", columns={"status"}), @ORM\Index(name="fk_law_orders_1_idx", columns={"user_id"}), @ORM\Index(name="fk_law_orders_2_idx", columns={"service_modification_id"}), @ORM\Index(name="fk_law_orders_3_idx", columns={"lawyer_id"})})
 * @ORM\Entity
 */
class LawOrders
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=155, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var LawUsers
     *
     * @ORM\ManyToOne(targetEntity="LawUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var LawServicesModifications
     *
     * @ORM\ManyToOne(targetEntity="LawServicesModifications")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_modification_id", referencedColumnName="id")
     * })
     */
    private $serviceModification;

    /**
     * @var LawUsers
     *
     * @ORM\ManyToOne(targetEntity="LawUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lawyer_id", referencedColumnName="id")
     * })
     */
    private $lawyer;



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
     * Set status
     *
     * @param boolean $status
     *
     * @return LawOrders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return LawOrders
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
     * Set description
     *
     * @param string $description
     *
     * @return LawOrders
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return LawOrders
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return LawOrders
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LawOrders
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

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return LawOrders
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\LawUsers $user
     *
     * @return LawOrders
     */
    public function setUser(\AppBundle\Entity\LawUsers $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\LawUsers
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set serviceModification
     *
     * @param \AppBundle\Entity\LawServicesModifications $serviceModification
     *
     * @return LawOrders
     */
    public function setServiceModification(\AppBundle\Entity\LawServicesModifications $serviceModification = null)
    {
        $this->serviceModification = $serviceModification;

        return $this;
    }

    /**
     * Get serviceModification
     *
     * @return \AppBundle\Entity\LawServicesModifications
     */
    public function getServiceModification()
    {
        return $this->serviceModification;
    }

    /**
     * Set lawyer
     *
     * @param \AppBundle\Entity\LawUsers $lawyer
     *
     * @return LawOrders
     */
    public function setLawyer(\AppBundle\Entity\LawUsers $lawyer = null)
    {
        $this->lawyer = $lawyer;

        return $this;
    }

    /**
     * Get lawyer
     *
     * @return \AppBundle\Entity\LawUsers
     */
    public function getLawyer()
    {
        return $this->lawyer;
    }
}
