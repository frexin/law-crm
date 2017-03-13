<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * LawPrivateOrdersComments
 *
 * @ORM\Table(name="law_private_orders_comments", indexes={@ORM\Index(name="fk_law_private_order_comments_1_idx", columns={"order_id"})})
 * @ORM\Entity
 */
class LawPrivateOrdersComments
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
     * Set isFromLawyer
     *
     * @param boolean $isFromLawyer
     *
     * @return LawPrivateOrdersComments
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
     * @return LawPrivateOrdersComments
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LawPrivateOrdersComments
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
     * @return LawPrivateOrdersComments
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
     * @return LawPrivateOrdersComments
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
