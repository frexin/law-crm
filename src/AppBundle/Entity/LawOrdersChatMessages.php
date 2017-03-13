<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * LawOrdersChatMessages
 *
 * @ORM\Table(name="law_orders_chat_messages", indexes={@ORM\Index(name="fk_law_order_chat_messages_1_idx", columns={"order_id"}), @ORM\Index(name="fk_law_orders_chat_messages_1_idx", columns={"user_from"}), @ORM\Index(name="fk_law_orders_chat_messages_2_idx", columns={"user_to"})})
 * @ORM\Entity
 */
class LawOrdersChatMessages
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
     * @ORM\Column(name="text", type="text", length=16777215, nullable=false)
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
     * @var LawUsers
     *
     * @ORM\ManyToOne(targetEntity="LawUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_from", referencedColumnName="id")
     * })
     */
    private $userFrom;

    /**
     * @var LawUsers
     *
     * @ORM\ManyToOne(targetEntity="LawUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_to", referencedColumnName="id")
     * })
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
     * @return LawOrdersChatMessages
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
     * @return LawOrdersChatMessages
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
     * @return LawOrdersChatMessages
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
     * @return LawOrdersChatMessages
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

    /**
     * Set userFrom
     *
     * @param \AppBundle\Entity\LawUsers $userFrom
     *
     * @return LawOrdersChatMessages
     */
    public function setUserFrom(\AppBundle\Entity\LawUsers $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \AppBundle\Entity\LawUsers
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \AppBundle\Entity\LawUsers $userTo
     *
     * @return LawOrdersChatMessages
     */
    public function setUserTo(\AppBundle\Entity\LawUsers $userTo = null)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \AppBundle\Entity\LawUsers
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
