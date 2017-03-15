<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderActionHistory
 *
 * @ORM\Table(name="orders_actions_history", indexes={@ORM\Index(name="fk_law_orders_actions_history_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderActionHistory
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
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order")
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
     * @return OrderActionHistory
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
     * @return OrderActionHistory
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
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return OrderActionHistory
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
