<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * PrivateOrderComment
 *
 * @ORM\Table(name="private_orders_comments", indexes={@ORM\Index(name="fk_law_private_order_comments_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class PrivateOrderComment
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
     * @ORM\Column(name="is_from_lawyer", type="boolean", nullable=false)
     */
    private $isFromLawyer = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="privateOrderComments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
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
     * Set isFromLawyer
     *
     * @param boolean $isFromLawyer
     *
     * @return PrivateOrderComment
     */
    public function setIsFromLawyer($isFromLawyer)
    {
        $this->isFromLawyer = $isFromLawyer;

        return $this;
    }

    /**
     * Get isFromLawyer
     *
     * @return boolean
     */
    public function getIsFromLawyer()
    {
        return $this->isFromLawyer;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return PrivateOrderComment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return PrivateOrderComment
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
