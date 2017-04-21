<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeTabl
 *
 * @ORM\Table(name="type_tabl")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\TypeTablRepository")
 */
class TypeTabl
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
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @var int
     *
     * @ORM\Column(name="min_covert", type="integer", nullable=true)
     */
    private $minCovert;

    /**
     * @var int
     *
     * @ORM\Column(name="max_covert", type="integer", nullable=true)
     */
    private $maxCovert;
    /**
     * @ORM\OneToMany(targetEntity="RestaurantBundle\Entity\TablTypeTabl", mappedBy="typeTablId", cascade="remove")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tabltypetabls;


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
     * @return TypeTabl
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
     * Set class
     *
     * @param string $class
     *
     * @return TypeTabl
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set minCovert
     *
     * @param integer $minCovert
     *
     * @return TypeTabl
     */
    public function setMinCovert($minCovert)
    {
        $this->minCovert = $minCovert;

        return $this;
    }

    /**
     * Get minCovert
     *
     * @return int
     */
    public function getMinCovert()
    {
        return $this->minCovert;
    }

    /**
     * Set maxCovert
     *
     * @param integer $maxCovert
     *
     * @return TypeTabl
     */
    public function setMaxCovert($maxCovert)
    {
        $this->maxCovert = $maxCovert;

        return $this;
    }

    /**
     * Get maxCovert
     *
     * @return int
     */
    public function getMaxCovert()
    {
        return $this->maxCovert;
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
     * @return TypeTabl
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
     * Add tabltypetabl
     *
     * @param \RestaurantBundle\Entity\TablTypeTabl $tabltypetabl
     *
     * @return TypeTabl
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
}
