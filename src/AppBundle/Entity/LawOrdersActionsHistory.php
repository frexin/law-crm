<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * LawOrdersActionsHistory
 *
 * @ORM\Table(name="law_orders_actions_history", indexes={@ORM\Index(name="fk_law_orders_actions_history_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class LawOrdersActionsHistory
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
     * @ORM\Column(name="action_type", type="boolean", nullable=false)
     */
    private $actionType;

    /**
     * @var string
     *
     * @ORM\Column(name="additional_information", type="text", length=65535, nullable=true)
     */
    private $additionalInformation;

    /**
     * @var LawOrders
     *
     * @ORM\ManyToOne(targetEntity="LawOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;



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
     * Set actionType
     *
     * @param boolean $actionType
     *
     * @return LawOrdersActionsHistory
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * Get actionType
     *
     * @return boolean
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * Set additionalInformation
     *
     * @param string $additionalInformation
     *
     * @return LawOrdersActionsHistory
     */
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    /**
     * Get additionalInformation
     *
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LawOrdersActionsHistory
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
     * @return LawOrdersActionsHistory
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
     * Set order
     *
     * @param \AppBundle\Entity\LawOrders $order
     *
     * @return LawOrdersActionsHistory
     */
    public function setOrder(\AppBundle\Entity\LawOrders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\LawOrders
     */
    public function getOrder()
    {
        return $this->order;
    }
}
