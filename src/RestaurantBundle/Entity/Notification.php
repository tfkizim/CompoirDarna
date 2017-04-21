<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\NotificationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="guid", type="text", nullable=true)
     */
    private $guid;

    /**
     * @var string
     *
     * @ORM\Column(name="type_notif", type="string", columnDefinition="enum('info', 'success', 'danger',  'warning')", options={"default":"info"})
     */
    private $typeNotif;
    /**
     * @var int
     *
     * @ORM\Column(name="viewed", type="integer", options={"default":0})
     */
    private $viewed;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $userId;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Book", inversedBy="notifications")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=true)
     */
    private $bookId;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Tabl", inversedBy="notifications")
     * @ORM\JoinColumn(name="tabl_id", referencedColumnName="id", nullable=true)
     */
    private $tablId;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set typeNotif
     *
     * @param string $typeNotif
     *
     * @return Notification
     */
    public function setTypeNotif($typeNotif)
    {
        $this->typeNotif = $typeNotif;

        return $this;
    }

    /**
     * Get typeNotif
     *
     * @return string
     */
    public function getTypeNotif()
    {
        return $this->typeNotif;
    }

    /**
     * Set userId
     *
     * @param \RestaurantBundle\Entity\User $userId
     *
     * @return Notification
     */
    public function setUserId(\RestaurantBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \RestaurantBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set bookId
     *
     * @param \RestaurantBundle\Entity\Book $bookId
     *
     * @return Notification
     */
    public function setBookId(\RestaurantBundle\Entity\Book $bookId = null)
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * Get bookId
     *
     * @return \RestaurantBundle\Entity\Book
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * Set tablId
     *
     * @param \RestaurantBundle\Entity\Tabl $tablId
     *
     * @return Notification
     */
    public function setTablId(\RestaurantBundle\Entity\Tabl $tablId = null)
    {
        $this->tablId = $tablId;

        return $this;
    }

    /**
     * Get tablId
     *
     * @return \RestaurantBundle\Entity\Tabl
     */
    public function getTablId()
    {
        return $this->tablId;
    }

    /**
     * Set viewed
     *
     * @param integer $viewed
     *
     * @return Notification
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Notification
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
     * @return Notification
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
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Set guid
     *
     * @param string $guid
     *
     * @return Notification
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * Get guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }
}
