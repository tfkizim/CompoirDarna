<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="fixe", type="string", length=255, nullable=true)
     */
    private $fixe;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, options={"default":"#"}, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="googleplus", type="string", length=255, options={"default":"#"}, nullable=true)
     */
    private $googleplus;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, options={"default":"#"}, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="director", type="string", length=255, nullable=true)
     */
    private $director;

    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\TypeCompany", inversedBy="companies")
    * @ORM\JoinColumn(name="typecompany_id", referencedColumnName="id")
    */
    private $typeCompanyId;

    /**
    * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Concierge", mappedBy="companyId")
    */
    private $concierges;

    /**
    * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Customer", mappedBy="companyId")
    */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\User", mappedBy="companyId")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book", mappedBy="companyId")
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
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Company
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
     * Set fixe
     *
     * @param string $fixe
     *
     * @return Company
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return string
     */
    public function getFixe()
    {
        return $this->fixe;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
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
     * Set description
     *
     * @param string $description
     *
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Company
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
     * Set googleplus
     *
     * @param string $googleplus
     *
     * @return Company
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
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Company
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
     * Set director
     *
     * @param string $director
     *
     * @return Company
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return string
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set typeCompany
     *
     * @param string $typeCompany
     *
     * @return Company
     */
    public function setTypeCompany($typeCompany)
    {
        $this->typeCompany = $typeCompany;

        return $this;
    }

    /**
     * Get typeCompany
     *
     * @return string
     */
    public function getTypeCompany()
    {
        return $this->typeCompany;
    }

    /**
     * Set typeCompanyId
     *
     * @param \RestaurantBundle\Entity\TypeCompany $typeCompanyId
     *
     * @return Company
     */
    public function setTypeCompanyId(\RestaurantBundle\Entity\TypeCompany $typeCompanyId = null)
    {
        $this->typeCompanyId = $typeCompanyId;

        return $this;
    }

    /**
     * Get typeCompanyId
     *
     * @return \RestaurantBundle\Entity\TypeCompany
     */
    public function getTypeCompanyId()
    {
        return $this->typeCompanyId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->concierges = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add concierge
     *
     * @param \RestaurantBundle\Entity\Concierge $concierge
     *
     * @return Company
     */
    public function addConcierge(\RestaurantBundle\Entity\Concierge $concierge)
    {
        $this->concierges[] = $concierge;

        return $this;
    }

    /**
     * Remove concierge
     *
     * @param \RestaurantBundle\Entity\Concierge $concierge
     */
    public function removeConcierge(\RestaurantBundle\Entity\Concierge $concierge)
    {
        $this->concierges->removeElement($concierge);
    }

    /**
     * Get concierges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcierges()
    {
        return $this->concierges;
    }

    /**
     * Add customer
     *
     * @param \RestaurantBundle\Entity\Customer $customer
     *
     * @return Company
     */
    public function addCustomer(\RestaurantBundle\Entity\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \RestaurantBundle\Entity\Customer $customer
     */
    public function removeCustomer(\RestaurantBundle\Entity\Customer $customer)
    {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Add user
     *
     * @param \RestaurantBundle\Entity\User $user
     *
     * @return Company
     */
    public function addUser(\RestaurantBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \RestaurantBundle\Entity\User $user
     */
    public function removeUser(\RestaurantBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add book
     *
     * @param \RestaurantBundle\Entity\Book $book
     *
     * @return Company
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
}
