<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\OfferRepository")
 */
class Offer
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
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;
    
    /**
     * @var int
     *
     * @ORM\Column(name="order_in_filter", type="integer", nullable=true, options={"default" = 0})
     */
    private $orderInFilter;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book", mappedBy="offerId")
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
     * @return Offer
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
     * @return Offer
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
     * Set orderInFilter
     *
     * @param integer $orderInFilter
     *
     * @return Offer
     */
    public function setOrderInFilter($orderInFilter)
    {
        $this->orderInFilter = $orderInFilter;

        return $this;
    }

    /**
     * Get orderInFilter
     *
     * @return integer
     */
    public function getOrderInFilter()
    {
        return $this->orderInFilter;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Offer
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
