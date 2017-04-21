<?php

namespace RestaurantBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=100, nullable=true)
     */
    protected $first_name;
    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=true)
     */
    protected $last_name;
    /**
     * @var string $mobile_number
     *
     * @ORM\Column(name="mobile_number", type="string", length=100, nullable=true)
     */
    protected $mobile_number;
    /**
     * @var string $fixe_number
     *
     * @ORM\Column(name="fixe_number", type="string", length=100, nullable=true)
     */
    protected $fixe_number;
    /**
     * @var string $job
     *
     * @ORM\Column(name="job", type="string", length=100, nullable=true)
     */
    protected $job;
    /**
     * @var string $sexe
     *
     * @ORM\Column(name="sexe", type="string", columnDefinition="enum('Mr.', 'Mme.', 'Mlle.')", options={"default" = "Mr."})
     */
    protected $sexe;
    /**
     * @var string $date_birthday
     *
     * @ORM\Column(name="date_birthday", type="date", nullable=true)
     */
    protected $date_birthday;
    /**
     * @var string $facebook
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    protected $facebook;
    /**
     * @var string $twitter
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    protected $twitter;
    /**
     * @var string $whatsapp
     *
     * @ORM\Column(name="whatsapp", type="string", length=255, nullable=true)
     */
    protected $whatsapp;
    /**
     * @var string $googleplus
     *
     * @ORM\Column(name="googleplus", type="string", length=255, nullable=true)
     */
    protected $googleplus;
    /**
     * @var string $cv
     *
     * @ORM\Column(name="cv", type="string", length=255, nullable=true)
     */
    protected $cv;
    /**
     * @var string $cv
     *
     * @ORM\Column(name="langue", type="string", columnDefinition="enum('Français', 'Anglais', 'Espagnole')")
     */
    protected $langue;
    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Company", inversedBy="users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
     */
    protected $companyId;
    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book", mappedBy="userId")
     */
    private $books;
    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Notification", mappedBy="userId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $notifications;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set mobileNumber
     *
     * @param string $mobileNumber
     *
     * @return User
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobile_number = $mobileNumber;

        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobile_number;
    }

    /**
     * Set fixeNumber
     *
     * @param string $fixeNumber
     *
     * @return User
     */
    public function setFixeNumber($fixeNumber)
    {
        $this->fixe_number = $fixeNumber;

        return $this;
    }

    /**
     * Get fixeNumber
     *
     * @return string
     */
    public function getFixeNumber()
    {
        return $this->fixe_number;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return User
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateBirthday
     *
     * @param \DateTime $dateBirthday
     *
     * @return User
     */
    public function setDateBirthday($dateBirthday)
    {
        $this->date_birthday = $dateBirthday;

        return $this;
    }

    /**
     * Get dateBirthday
     *
     * @return \DateTime
     */
    public function getDateBirthday()
    {
        return $this->date_birthday;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set whatsapp
     *
     * @param string $whatsapp
     *
     * @return User
     */
    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    /**
     * Get whatsapp
     *
     * @return string
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * Set googleplus
     *
     * @param string $googleplus
     *
     * @return User
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;

        return $this;
    }

    /**
     * Get googleplus
     *
     * @return string
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * Set cv
     *
     * @param string $cv
     *
     * @return User
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * Set companyId
     *
     * @param \RestaurantBundle\Entity\Company $companyId
     *
     * @return User
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
     * Set langue
     *
     * @param string $langue
     *
     * @return User
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Add book
     *
     * @param \RestaurantBundle\Entity\Book $book
     *
     * @return User
     */
    public function addBook(\RestaurantBundle\Entity\Book $book)
    {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book
     *
     * @param \RestaurantBundle\Entity\Book $book
     */
    public function removeBook(\RestaurantBundle\Entity\Book $book)
    {
        $this->books->removeElement($book);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Add notification
     *
     * @param \RestaurantBundle\Entity\Notification $notification
     *
     * @return User
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
}
