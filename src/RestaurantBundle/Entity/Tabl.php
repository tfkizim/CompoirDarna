<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tabl
 *
 * @ORM\Table(name="tabl")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\TablRepository")
 */
class Tabl
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
     * @ORM\Column(name="rotation", type="integer", nullable=true, options={"default" = 0})
     */
    private $rotation;

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
     * @var int
     *
     * @ORM\Column(name="nbr_chaire", type="integer", nullable=true, options={"default" = 2})
     */
    private $nbrChaire;

    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Floor", inversedBy="tabls")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id")
     */
    private $floorId;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\TablTypeTabl", mappedBy="tablId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tabltypetabls;

    /**
    * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\GroupTabl", inversedBy="tabls")
    * @ORM\JoinColumn(name="grouptable_id", referencedColumnName="id", nullable=true)
    */
    private $grouptablId;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\BookTabl", mappedBy="tablId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $booktabls;
    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\Notification", mappedBy="tablId", cascade="remove")
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
     * Set name
     *
     * @param string $name
     *
     * @return Tabl
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
     * Set leftp
     *
     * @param integer $leftp
     *
     * @return Tabl
     */
    public function setLeftp($leftp)
    {
        $this->leftp = $leftp;

        return $this;
    }

    /**
     * Get leftp
     *
     * @return int
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
     * @return Tabl
     */
    public function setTopp($topp)
    {
        $this->topp = $topp;

        return $this;
    }

    /**
     * Get topp
     *
     * @return int
     */
    public function getTopp()
    {
        return $this->topp;
    }

    /**
     * Set rotation
     *
     * @param integer $rotation
     *
     * @return Tabl
     */
    public function setRotation($rotation)
    {
        $this->rotation = $rotation;

        return $this;
    }

    /**
     * Get rotation
     *
     * @return int
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * Set blockedStartDate
     *
     * @param \DateTime $blockedStartDate
     *
     * @return Tabl
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
     * @return Tabl
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
     * Set nbrChaire
     *
     * @param integer $nbrChaire
     *
     * @return Tabl
     */
    public function setNbrChaire($nbrChaire)
    {
        $this->nbrChaire = $nbrChaire;

        return $this;
    }

    /**
     * Get nbrChaire
     *
     * @return int
     */
    public function getNbrChaire()
    {
        return $this->nbrChaire;
    }

    /**
     * Set floorId
     *
     * @param \RestaurantBundle\Entity\Floor $floorId
     *
     * @return Tabl
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
     * Set typetablId
     *
     * @param \RestaurantBundle\Entity\TypeTabl $typetablId
     *
     * @return Tabl
     */
    public function setTypetablId(\RestaurantBundle\Entity\TypeTabl $typetablId = null)
    {
        $this->typetablId = $typetablId;

        return $this;
    }

    /**
     * Get typetablId
     *
     * @return \RestaurantBundle\Entity\TypeTabl
     */
    public function getTypetablId()
    {
        return $this->typetablId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tabltypetabls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tabltypetabl
     *
     * @param \RestaurantBundle\Entity\TablTypeTabl $tabltypetabl
     *
     * @return Tabl
     */
    public function addTabltypetabl(\RestaurantBundle\Entity\TablTypeTabl $tabltypetabl)
    {
        $this->tabltypetabls[] = $tabltypetabl;

        return $this;
    }

    /**
     * Remove tabltypetabl
     *
     * @param \RestaurantBundle\Entity\TablTypeTabl $tabltypetabl
     */
    public function removeTabltypetabl(\RestaurantBundle\Entity\TablTypeTabl $tabltypetabl)
    {
        $this->tabltypetabls->removeElement($tabltypetabl);
    }

    /**
     * Get tabltypetabls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTabltypetabls()
    {
        return $this->tabltypetabls;
    }

    /**
     * Set grouptablId
     *
     * @param \RestaurantBundle\Entity\GroupTabl $grouptablId
     *
     * @return GroupTabl
     */
    public function setGrouptablId(\RestaurantBundle\Entity\GroupTabl $grouptablId = null)
    {
        $this->grouptablId = $grouptablId;

        return $this;
    }

    /**
     * Get grouptablId
     *
     * @return \RestaurantBundle\Entity\GroupTabl
     */
    public function getGrouptablId()
    {
        return $this->grouptablId;
    }

    /**
     * Add booktabl
     *
     * @param \RestaurantBundle\Entity\BookTabl $booktabl
     *
     * @return Tabl
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
     * Add notification
     *
     * @param \RestaurantBundle\Entity\Notification $notification
     *
     * @return Tabl
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
