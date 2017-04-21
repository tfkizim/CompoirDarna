<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Floor
 *
 * @ORM\Table(name="floor")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\FloorRepository")
 */
class Floor
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_covert", type="integer")
     */
    private $nbrCovert;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_server", type="integer")
     */
    private $nbrServer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @ORM\Version
     */
    private $created;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Tabl",mappedBy="floorId")
     */
    private $tabls;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\GroupTabl",mappedBy="floorId")
     */
    private $grouptabls;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Book",mappedBy="floorId")
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
     * @return Floor
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Floor
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set nbrCovert
     *
     * @param integer $nbrCovert
     *
     * @return Floor
     */
    public function setNbrCovert($nbrCovert)
    {
        $this->nbrCovert = $nbrCovert;

        return $this;
    }

    /**
     * Get nbrCovert
     *
     * @return int
     */
    public function getNbrCovert()
    {
        return $this->nbrCovert;
    }

    /**
     * Set nbrServer
     *
     * @param integer $nbrServer
     *
     * @return Floor
     */
    public function setNbrServer($nbrServer)
    {
        $this->nbrServer = $nbrServer;

        return $this;
    }

    /**
     * Get nbrServer
     *
     * @return int
     */
    public function getNbrServer()
    {
        return $this->nbrServer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Floor
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Floor
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tabls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tabl
     *
     * @param \RestaurantBundle\Entity\Tabl $tabl
     *
     * @return Floor
     */
    public function addTabl(\RestaurantBundle\Entity\Tabl $tabl)
    {
        $this->tabls[] = $tabl;

        return $this;
    }

    /**
     * Remove tabl
     *
     * @param \RestaurantBundle\Entity\Tabl $tabl
     */
    public function removeTabl(\RestaurantBundle\Entity\Tabl $tabl)
    {
        $this->tabls->removeElement($tabl);
    }

    /**
     * Get tabls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTabls()
    {
        return $this->tabls;
    }

    /**
     * Add grouptabl
     *
     * @param \RestaurantBundle\Entity\GroupTabl $grouptabl
     *
     * @return Floor
     */
    public function addGrouptabl(\RestaurantBundle\Entity\GroupTabl $grouptabl)
    {
        $this->grouptabls[] = $grouptabl;

        return $this;
    }

    /**
     * Remove grouptabl
     *
     * @param \RestaurantBundle\Entity\GroupTabl $grouptabl
     */
    public function removeGrouptabl(\RestaurantBundle\Entity\GroupTabl $grouptabl)
    {
        $this->grouptabls->removeElement($grouptabl);
    }

    /**
     * Get grouptabls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrouptabls()
    {
        return $this->grouptabls;
    }
}
