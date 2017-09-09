<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LawFinance
 *
 * @ORM\Table(name="finance", indexes={@ORM\Index(name="order_id", columns={"order_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Finance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt", type="datetime", nullable=false)
     */
    private $dt;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hold", type="boolean", nullable=false)
     */
    private $isHold = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_cash", type="boolean", nullable=false)
     */
    private $isCash = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function __construct()
    {
        $this->dt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getDt(): \DateTime
    {
        return $this->dt;
    }

    /**
     * @param \DateTime $dt
     */
    public function setDt(\DateTime $dt)
    {
        $this->dt = $dt;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return boolean
     */
    public function isIsHold(): bool
    {
        return $this->isHold;
    }

    /**
     * @param boolean $isHold
     */
    public function setIsHold(bool $isHold)
    {
        $this->isHold = $isHold;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return boolean
     */
    public function getIsCache(): bool
    {
        return $this->isCash;
    }

    /**
     * @param boolean $isCash
     */
    public function setIsCash(bool $isCash)
    {
        $this->isCash = $isCash;
    }
}