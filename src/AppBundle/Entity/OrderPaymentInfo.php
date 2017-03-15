<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderPaymentInfo
 *
 * @ORM\Table(name="orders_payment_info", indexes={@ORM\Index(name="fk_law_orders_payment_info_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderPaymentInfo
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
     * Set amount
     *
     * @param string $amount
     *
     * @return OrderPaymentInfo
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
     * @return OrderPaymentInfo
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
     * @return OrderPaymentInfo
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
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return OrderPaymentInfo
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
