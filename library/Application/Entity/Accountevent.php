<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accountevent
 *
 * @ORM\Table(name="accountevent")
 * @ORM\Entity(repositoryClass="AccounteventRepository")
 */
class Accountevent
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
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=255, nullable=false)
     */
    private $event;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="happened_at", type="datetime", nullable=false)
     */
    private $happenedAt;



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
     * Set accountId
     *
     * @param integer $accountId
     * @return Accountevent
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set event
     *
     * @param string $event
     * @return Accountevent
     */
    public function setEvent($event)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set happenedAt
     *
     * @param \DateTime $happenedAt
     * @return Accountevent
     */
    public function setHappenedAt($happenedAt)
    {
        $this->happenedAt = $happenedAt;
        return $this;
    }

    /**
     * Get happenedAt
     *
     * @return \DateTime 
     */
    public function getHappenedAt()
    {
        return $this->happenedAt;
    }
}