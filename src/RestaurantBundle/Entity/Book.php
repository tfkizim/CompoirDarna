<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\BookRepository")
 */
class Book
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_book", type="datetime")
     */
    private $dateBook;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begining_waiting_time", type="datetime", nullable=true)
     */
    private $beginingWaitingTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sys", type="datetime")
     * @ORM\Version
     */
    private $dateSys;

    /**
     * @var int
     *
     * @ORM\Column(name="pax", type="integer")
     */
    private $pax;

    /**
     * @var bool
     *
     * @ORM\Column(name="blocked", type="boolean", options={"default" = 0})
     */
    private $blocked;

    /**
     * @var string
     *
     * @ORM\Column(name="note_admin", type="text", nullable=true)
     */
    private $noteAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="note_customer", type="text", nullable=true)
     */
    private $noteCustomer;

    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Service", inversedBy="books")
    * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
    */
    private $serviceId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\State", inversedBy="books")
    * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
    */
    private $stateId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Offer", inversedBy="books")
    * @ORM\JoinColumn(name="offer_id", referencedColumnName="id", nullable=true)
    */
    private $offerId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Occasion", inversedBy="books")
    * @ORM\JoinColumn(name="occasion_id", referencedColumnName="id", nullable=true)
    */
    private $occasionId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Customer", inversedBy="books")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
    */
    private $customerId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Company", inversedBy="books")
    * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
    */
    private $companyId;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Floor", inversedBy="books")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id", nullable=true)
     */
    private $floorId;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\BookTabl", mappedBy="bookId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $booktabls;
    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Notification", mappedBy="bookId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $notifications;


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
     * Set dateBook
     *
     * @param \DateTime $dateBook
     *
     * @return Book
     */
    public function setDateBook($dateBook)
    {
        $this->dateBook = $dateBook;

        return $this;
    }

    /**
     * Get dateBook
     *
     * @return \DateTime
     */
    public function getDateBook()
    {
        return $this->dateBook;
    }

    /**
     * Set dateSys
     *
     * @param \DateTime $dateSys
     *
     * @return Book
     */
    public function setDateSys($dateSys)
    {
        $this->dateSys = $dateSys;

        return $this;
    }

    /**
     * Get dateSys
     *
     * @return \DateTime
     */
    public function getDateSys()
    {
        return $this->dateSys;
    }

    /**
     * Set pax
     *
     * @param integer $pax
     *
     * @return Book
     */
    public function setPax($pax)
    {
        $this->pax = $pax;

        return $this;
    }

    /**
     * Get pax
     *
     * @return int
     */
    public function getPax()
    {
        return $this->pax;
    }

    /**
     * Set noteAdmin
     *
     * @param string $noteAdmin
     *
     * @return Book
     */
    public function setNoteAdmin($noteAdmin)
    {
        $this->noteAdmin = $noteAdmin;

        return $this;
    }

    /**
     * Get noteAdmin
     *
     * @return string
     */
    public function getNoteAdmin()
    {
        return $this->noteAdmin;
    }

    /**
     * Set noteCustomer
     *
     * @param string $noteCustomer
     *
     * @return Book
     */
    public function setNoteCustomer($noteCustomer)
    {
        $this->noteCustomer = $noteCustomer;

        return $this;
    }

    /**
     * Get noteCustomer
     *
     * @return string
     */
    public function getNoteCustomer()
    {
        return $this->noteCustomer;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->booktabls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set serviceId
     *
     * @param \RestaurantBundle\Entity\Service $serviceId
     *
     * @return Book
     */
    public function setServiceId(\RestaurantBundle\Entity\Service $serviceId = null)
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    /**
     * Get serviceId
     *
     * @return \RestaurantBundle\Entity\Service
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set stateId
     *
     * @param \RestaurantBundle\Entity\State $stateId
     *
     * @return Book
     */
    public function setStateId(\RestaurantBundle\Entity\State $stateId = null)
    {
        $this->stateId = $stateId;

        return $this;
    }

    /**
     * Get stateId
     *
     * @return \RestaurantBundle\Entity\State
     */
    public function getStateId()
    {
        return $this->stateId;
    }

    /**
     * Set offerId
     *
     * @param \RestaurantBundle\Entity\Offer $offerId
     *
     * @return Book
     */
    public function setOfferId(\RestaurantBundle\Entity\Offer $offerId = null)
    {
        $this->offerId = $offerId;

        return $this;
    }

    /**
     * Get offerId
     *
     * @return \RestaurantBundle\Entity\Offer
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Set occasionId
     *
     * @param \RestaurantBundle\Entity\Occasion $occasionId
     *
     * @return Book
     */
    public function setOccasionId(\RestaurantBundle\Entity\Occasion $occasionId = null)
    {
        $this->occasionId = $occasionId;

        return $this;
    }

    /**
     * Get occasionId
     *
     * @return \RestaurantBundle\Entity\Occasion
     */
    public function getOccasionId()
    {
        return $this->occasionId;
    }

    /**
     * Set customerId
     *
     * @param \RestaurantBundle\Entity\Customer $customerId
     *
     * @return Book
     */
    public function setCustomerId(\RestaurantBundle\Entity\Customer $customerId = null)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return \RestaurantBundle\Entity\Customer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set companyId
     *
     * @param \RestaurantBundle\Entity\Company $companyId
     *
     * @return Book
     */
    public function setCompanyId(\RestaurantBundle\Entity\Company $companyId = null)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return \RestaurantBundle\Entity\Company
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Add booktabl
     *
     * @param \RestaurantBundle\Entity\BookTabl $booktabl
     *
     * @return Book
     */
    public function addBooktabl(\RestaurantBundle\Entity\BookTabl $booktabl)
    {
        $this->booktabls[] = $booktabl;

        return $this;
    }

    /**
     * Remove booktabl
     *
     * @param \RestaurantBundle\Entity\BookTabl $booktabl
     */
    public function removeBooktabl(\RestaurantBundle\Entity\BookTabl $booktabl)
    {
        $this->booktabls->removeElement($booktabl);
    }

    /**
     * Get booktabls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooktabls()
    {
        return $this->booktabls;
    }

    /**
     * Set userId
     *
     * @param \RestaurantBundle\Entity\User $userId
     *
     * @return Book
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
     * Set floorId
     *
     * @param \RestaurantBundle\Entity\Floor $floorId
     *
     * @return Book
     */
    public function setFloorId(\RestaurantBundle\Entity\Floor $floorId = null)
    {
        $this->floorId = $floorId;

        return $this;
    }

    /**
     * Get floorId
     *
     * @return \RestaurantBundle\Entity\Floor
     */
    public function getFloorId()
    {
        return $this->floorId;
    }

    /**
     * Add notification
     *
     * @param \RestaurantBundle\Entity\Notification $notification
     *
     * @return Book
     */
    public function addNotification(\RestaurantBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \RestaurantBundle\Entity\Notification $notification
     */
    public function removeNotification(\RestaurantBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set beginingWaitingTime
     *
     * @param \DateTime $beginingWaitingTime
     *
     * @return Book
     */
    public function setBeginingWaitingTime($beginingWaitingTime)
    {
        $this->beginingWaitingTime = $beginingWaitingTime;

        return $this;
    }

    /**
     * Get beginingWaitingTime
     *
     * @return \DateTime
     */
    public function getBeginingWaitingTime()
    {
        return $this->beginingWaitingTime;
    }

    /**
     * Set blocked
     *
     * @param boolean $blocked
     *
     * @return Book
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * Get blocked
     *
     * @return boolean
     */
    public function getBlocked()
    {
        return $this->blocked;
    }
}
