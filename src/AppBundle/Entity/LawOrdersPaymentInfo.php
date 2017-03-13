<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * LawOrdersPaymentInfo
 *
 * @ORM\Table(name="law_orders_payment_info", indexes={@ORM\Index(name="fk_law_orders_payment_info_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class LawOrdersPaymentInfo
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
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payment_type", type="boolean", nullable=true)
     */
    private $paymentType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_moneyback", type="boolean", nullable=false)
     */
    private $isMoneyback = '0';

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
     * Set amount
     *
     * @param string $amount
     *
     * @return LawOrdersPaymentInfo
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set paymentType
     *
     * @param boolean $paymentType
     *
     * @return LawOrdersPaymentInfo
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return boolean
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set isMoneyback
     *
     * @param boolean $isMoneyback
     *
     * @return LawOrdersPaymentInfo
     */
    public function setIsMoneyback($isMoneyback)
    {
        $this->isMoneyback = $isMoneyback;

        return $this;
    }

    /**
     * Get isMoneyback
     *
     * @return boolean
     */
    public function getIsMoneyback()
    {
        return $this->isMoneyback;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LawOrdersPaymentInfo
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
     * @return LawOrdersPaymentInfo
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
     * @return LawOrdersPaymentInfo
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
