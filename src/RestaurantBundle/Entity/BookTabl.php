<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookTabl
 *
 * @ORM\Table(name="book_tabl")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\BookTablRepository")
 */
class BookTabl
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
     * @ORM\Column(name="date_sys", type="datetime")
     * @ORM\Version
     */
    private $dateSys;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Book", inversedBy="booktabls")
    * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
    */
    private $bookId;
    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Tabl", inversedBy="booktabls")
    * @ORM\JoinColumn(name="tabl_id", referencedColumnName="id")
    */
    private $tablId;


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
     * Set dateSys
     *
     * @param \DateTime $dateSys
     *
     * @return BookTabl
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
     * Set bookId
     *
     * @param \RestaurantBundle\Entity\Book $bookId
     *
     * @return BookTabl
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
     * @return BookTabl
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
}
