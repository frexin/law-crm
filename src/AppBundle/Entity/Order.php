<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ServiceModification;

/**
 * Order
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="orders_status_idx", columns={"status"}), @ORM\Index(name="fk_law_orders_1_idx", columns={"user_id"}), @ORM\Index(name="fk_law_orders_2_idx", columns={"service_modification_id"}), @ORM\Index(name="fk_law_orders_3_idx", columns={"lawyer_id"})})
 * @ORM\Entity
 * @ORM\EntityListeners({"AppBundle\Listener\OrderListener"})
 */
class Order
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
     * @var \DateTime
     *
     * @ORM\Column(name="recent_activity", type="datetime", nullable=true)
     */
    private $recentActivity;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    /**
     * @var ServiceModification
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ServiceModification")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_modification_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $serviceModification;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lawyer_id", referencedColumnName="id")
     * })
     */
    private $lawyer;

    /**
     * @ORM\OneToMany(targetEntity="OrderChatMessage", mappedBy="order", fetch="EAGER")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    private $orderChatMessages;

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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set serviceModification
     *
     * @param \AppBundle\Entity\ServiceModification $serviceModification
     *
     * @return Order
     */
    public function setServiceModification(\AppBundle\Entity\ServiceModification $serviceModification = null)
    {
        $this->serviceModification = $serviceModification;

        return $this;
    }

    /**
     * Get serviceModification
     *
     * @return \AppBundle\Entity\ServiceModification
     */
    public function getServiceModification()
    {
        return $this->serviceModification;
    }

    /**
     * Set lawyer
     *
     * @param \AppBundle\Entity\User $lawyer
     *
     * @return Order
     */
    public function setLawyer(\AppBundle\Entity\User $lawyer = null)
    {
        $this->lawyer = $lawyer;

        return $this;
    }

    /**
     * Get lawyer
     *
     * @return \AppBundle\Entity\User
     */
    public function getLawyer()
    {
        return $this->lawyer;
    }

    /**
     * @return \DateTime
     */
    public function getRecentActivity()
    {
        return $this->recentActivity;
    }

    /**
     * @param \DateTime $recentActivity
     */
    public function setRecentActivity(\DateTime $recentActivity)
    {
        $this->recentActivity = $recentActivity;
    }

    /**
     * @return mixed
     */
    public function getOrderChatMessages()
    {
        return $this->orderChatMessages;
    }

    /**
     * @param mixed $orderChatMessages
     */
    public function setOrderChatMessages($orderChatMessages)
    {
        $this->orderChatMessages = $orderChatMessages;
    }
}
