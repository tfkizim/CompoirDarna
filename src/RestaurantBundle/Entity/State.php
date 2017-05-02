<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\StateRepository")
 */
class State
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="function", type="string", columnDefinition="enum('reserved', 'seated', 'late', 'free', 'arrived', 'cancelled', 'pending', 'noshow', 'pendingconfirmation')", options={"default" = "reserved"})
     */
    private $function;

    /**
     * @var bool
     *
     * @ORM\Column(name="flashed", type="boolean", nullable=true, options={"default" = 0})
     */
    private $flashed;

    /**
     * @var int
     *
     * @ORM\Column(name="order_in_filter", type="integer", nullable=true, options={"default" = 0})
     */
    private $orderInFilter;
    /**
     * @var bool
     *
     * @ORM\Column(name="hide_in_filter", type="boolean", nullable=true, options={"default" = 0})
     */
    private $hideInFilter;
    /**
     * @var bool
     *
     * @ORM\Column(name="hide_admin", type="boolean", nullable=true, options={"default" = 0})
     */
    private $hideAdmin;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book", mappedBy="stateId")
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
     * @return State
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
     * Set color
     *
     * @param string $color
     *
     * @return State
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set flashed
     *
     * @param boolean $flashed
     *
     * @return State
     */
    public function setFlashed($flashed)
    {
        $this->flashed = $flashed;

        return $this;
    }

    /**
     * Get flashed
     *
     * @return bool
     */
    public function getFlashed()
    {
        return $this->flashed;
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
     * @return State
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
     * Set function
     *
     * @param string $function
     *
     * @return State
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set orderInFilter
     *
     * @param \int $orderInFilter
     *
     * @return State
     */
    public function setOrderInFilter($orderInFilter)
    {
        $this->orderInFilter = $orderInFilter;

        return $this;
    }

    /**
     * Get orderInFilter
     *
     * @return \int
     */
    public function getOrderInFilter()
    {
        return $this->orderInFilter;
    }

    /**
     * Set hideInFilter
     *
     * @param boolean $hideInFilter
     *
     * @return State
     */
    public function setHideInFilter($hideInFilter)
    {
        $this->hideInFilter = $hideInFilter;

        return $this;
    }

    /**
     * Get hideInFilter
     *
     * @return boolean
     */
    public function getHideInFilter()
    {
        return $this->hideInFilter;
    }

    /**
     * Set hideAdmin
     *
     * @param boolean $hideAdmin
     *
     * @return State
     */
    public function setHideAdmin($hideAdmin)
    {
        $this->hideAdmin = $hideAdmin;

        return $this;
    }

    /**
     * Get hideAdmin
     *
     * @return boolean
     */
    public function getHideAdmin()
    {
        return $this->hideAdmin;
    }
}
