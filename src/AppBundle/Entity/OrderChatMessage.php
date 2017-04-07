<?php

namespace AppBundle\Entity;

use AppBundle\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderChatMessage
 *
 * @ORM\Table(name="orders_chat_messages", indexes={@ORM\Index(name="fk_law_orders_chat_messages_1_idx", columns={"order_id"}), @ORM\Index(name="fk_law_orders_chat_messages_1_idx", columns={"user_from"}), @ORM\Index(name="fk_law_orders_chat_messages_2_idx", columns={"user_to"})})
 * @ORM\Entity
 */
class OrderChatMessage
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
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=16777215, nullable=false)
     */
    private $text;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderChatMessages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     * })
     *
     */
    private $order;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_from", referencedColumnName="id", nullable=false)
     * })
     *
     */
    private $userFrom;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_to", referencedColumnName="id")
     * })
     *
     */
    private $userTo;



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
     * Set text
     *
     * @param string $text
     *
     * @return OrderChatMessage
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
     * @return OrderChatMessage
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

    /**
     * Set userFrom
     *
     * @param \AppBundle\Entity\User $userFrom
     *
     * @return OrderChatMessage
     */
    public function setUserFrom(\AppBundle\Entity\User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \AppBundle\Entity\User $userTo
     *
     * @return OrderChatMessage
     */
    public function setUserTo(\AppBundle\Entity\User $userTo = null)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
