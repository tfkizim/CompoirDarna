<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="indicatif_mobile_number", type="string", length=255, nullable=true)
     */
    private $indicatifMobileNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_number", type="string", length=255, nullable=true)
     */
    private $mobileNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", columnDefinition="enum('Mr.', 'Mme.', 'Mlle.')", options={"default" = "Mr."})
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var bool
     *
     * @ORM\Column(name="vip", type="boolean", nullable=true)
     */
    private $vip;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_birthday", type="datetime", nullable=true)
     */
    private $dateBirthday;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=255, nullable=true)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="favorite_food", type="string", length=255, nullable=true)
     */
    private $favoriteFood;

    /**
     * @var string
     *
     * @ORM\Column(name="favorite_drink", type="string", length=255, nullable=true)
     */
    private $favoriteDrink;

    /**
     * @var string
     *
     * @ORM\Column(name="favorite_table", type="string", length=255, nullable=true)
     */
    private $favoriteTable;

    /**
     * @var string
     *
     * @ORM\Column(name="favorite_server", type="string", length=255, nullable=true)
     */
    private $favoriteServer;

    /**
     * @var string
     *
     * @ORM\Column(name="handicape", type="string", length=255, nullable=true)
     */
    private $handicape;

    /**
     * @var string
     *
     * @ORM\Column(name="diet", type="string", length=255, nullable=true)
     */
    private $diet;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean", nullable=true)
     */
    private $newsletter;

    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Company", inversedBy="customers")
    * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
    */
    private $companyId;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book", mappedBy="customerId")
     */
    private $books;


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobileNumber
     *
     * @param string $mobileNumber
     *
     * @return Customer
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Customer
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Customer
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
     * Set address
     *
     * @param string $address
     *
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set vip
     *
     * @param boolean $vip
     *
     * @return Customer
     */
    public function setVip($vip)
    {
        $this->vip = $vip;

        return $this;
    }

    /**
     * Get vip
     *
     * @return bool
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Customer
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set dateBirthday
     *
     * @param \DateTime $dateBirthday
     *
     * @return Customer
     */
    public function setDateBirthday($dateBirthday)
    {
        $this->dateBirthday = $dateBirthday;

        return $this;
    }

    /**
     * Get dateBirthday
     *
     * @return \DateTime
     */
    public function getDateBirthday()
    {
        return $this->dateBirthday;
    }

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return Customer
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
     * Set fax
     *
     * @param string $fax
     *
     * @return Customer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Customer
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Customer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set favoriteFood
     *
     * @param string $favoriteFood
     *
     * @return Customer
     */
    public function setFavoriteFood($favoriteFood)
    {
        $this->favoriteFood = $favoriteFood;

        return $this;
    }

    /**
     * Get favoriteFood
     *
     * @return string
     */
    public function getFavoriteFood()
    {
        return $this->favoriteFood;
    }

    /**
     * Set favoriteDrink
     *
     * @param string $favoriteDrink
     *
     * @return Customer
     */
    public function setFavoriteDrink($favoriteDrink)
    {
        $this->favoriteDrink = $favoriteDrink;

        return $this;
    }

    /**
     * Get favoriteDrink
     *
     * @return string
     */
    public function getFavoriteDrink()
    {
        return $this->favoriteDrink;
    }

    /**
     * Set favoriteTable
     *
     * @param string $favoriteTable
     *
     * @return Customer
     */
    public function setFavoriteTable($favoriteTable)
    {
        $this->favoriteTable = $favoriteTable;

        return $this;
    }

    /**
     * Get favoriteTable
     *
     * @return string
     */
    public function getFavoriteTable()
    {
        return $this->favoriteTable;
    }

    /**
     * Set favoriteServer
     *
     * @param string $favoriteServer
     *
     * @return Customer
     */
    public function setFavoriteServer($favoriteServer)
    {
        $this->favoriteServer = $favoriteServer;

        return $this;
    }

    /**
     * Get favoriteServer
     *
     * @return string
     */
    public function getFavoriteServer()
    {
        return $this->favoriteServer;
    }

    /**
     * Set handicape
     *
     * @param string $handicape
     *
     * @return Customer
     */
    public function setHandicape($handicape)
    {
        $this->handicape = $handicape;

        return $this;
    }

    /**
     * Get handicape
     *
     * @return string
     */
    public function getHandicape()
    {
        return $this->handicape;
    }

    /**
     * Set diet
     *
     * @param string $diet
     *
     * @return Customer
     */
    public function setDiet($diet)
    {
        $this->diet = $diet;

        return $this;
    }

    /**
     * Get diet
     *
     * @return string
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Customer
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Customer
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set companyId
     *
     * @param \RestaurantBundle\Entity\Company $companyId
     *
     * @return Customer
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
     * Constructor
     */
    public function __construct()
    {
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add book
     *
     * @param \RestaurantBundle\Entity\Book $book
     *
     * @return Customer
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
     * Set indicatifMobileNumber
     *
     * @param string $indicatifMobileNumber
     *
     * @return Customer
     */
    public function setIndicatifMobileNumber($indicatifMobileNumber)
    {
        $this->indicatifMobileNumber = $indicatifMobileNumber;

        return $this;
    }

    /**
     * Get indicatifMobileNumber
     *
     * @return string
     */
    public function getIndicatifMobileNumber()
    {
        return $this->indicatifMobileNumber;
    }
}
