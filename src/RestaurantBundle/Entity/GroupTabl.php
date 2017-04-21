<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupTabl
 *
 * @ORM\Table(name="group_tabl")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\GroupTablRepository")
 */
class GroupTabl
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
     * @var int
     *
     * @ORM\Column(name="leftp", type="integer", nullable=true, options={"default" = 0})
     */
    private $leftp;

    /**
     * @var int
     *
     * @ORM\Column(name="topp", type="integer", nullable=true, options={"default" = 0})
     */
    private $topp;

    /**
     * @var int
     *
     * @ORM\Column(name="orientation", type="string", nullable=true, options={"default" = "horizontal"})
     */
    private $orientation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="blocked_start_date", type="datetimetz", nullable=true)
     */
    private $blockedStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="blocked_end_date", type="datetimetz", nullable=true)
     */
    private $blockedEndDate;

    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Floor", inversedBy="grouptabls")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id")
     */
    private $floorId;


    /**
    * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Tabl", mappedBy="grouptablId")
    */
    private $tabls;


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
     * @return GroupTabl
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
        $this->tabls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tabl
     *
     * @param \RestaurantBundle\Entity\Tabl $tabl
     *
     * @return GroupTabl
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
     * Set leftp
     *
     * @param integer $leftp
     *
     * @return GroupTabl
     */
    public function setLeftp($leftp)
    {
        $this->leftp = $leftp;

        return $this;
    }

    /**
     * Get leftp
     *
     * @return integer
     */
    public function getLeftp()
    {
        return $this->leftp;
    }

    /**
     * Set topp
     *
     * @param integer $topp
     *
     * @return GroupTabl
     */
    public function setTopp($topp)
    {
        $this->topp = $topp;

        return $this;
    }

    /**
     * Get topp
     *
     * @return integer
     */
    public function getTopp()
    {
        return $this->topp;
    }

    /**
     * Set orientation
     *
     * @param string $orientation
     *
     * @return GroupTabl
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set blockedStartDate
     *
     * @param \DateTime $blockedStartDate
     *
     * @return GroupTabl
     */
    public function setBlockedStartDate($blockedStartDate)
    {
        $this->blockedStartDate = $blockedStartDate;

        return $this;
    }

    /**
     * Get blockedStartDate
     *
     * @return \DateTime
     */
    public function getBlockedStartDate()
    {
        return $this->blockedStartDate;
    }

    /**
     * Set blockedEndDate
     *
     * @param \DateTime $blockedEndDate
     *
     * @return GroupTabl
     */
    public function setBlockedEndDate($blockedEndDate)
    {
        $this->blockedEndDate = $blockedEndDate;

        return $this;
    }

    /**
     * Get blockedEndDate
     *
     * @return \DateTime
     */
    public function getBlockedEndDate()
    {
        return $this->blockedEndDate;
    }

    /**
     * Set floorId
     *
     * @param \RestaurantBundle\Entity\Floor $floorId
     *
     * @return GroupTabl
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
}
