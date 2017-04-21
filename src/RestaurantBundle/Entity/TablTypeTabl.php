<?php

namespace RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TablTypeTabl
 *
 * @ORM\Table(name="tabl_type_tabl")
 * @ORM\Entity(repositoryClass="RestaurantBundle\Repository\TablTypeTablRepository")
 */
class TablTypeTabl
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
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\TypeTabl", inversedBy="tabltypetabls")
     * @ORM\JoinColumn(name="type_tabl_id",referencedColumnName="id")
     */
    private $typeTablId;

    /**
     * @ORM\ManyToOne(targetEntity="RestaurantBundle\Entity\Tabl", inversedBy="tabltypetabls")
     * @ORM\JoinColumn(name="tabl_id",referencedColumnName="id")
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
     * Set typeTablId
     *
     * @param \RestaurantBundle\Entity\TypeTabl $typeTablId
     *
     * @return TablTypeTabl
     */
    public function setTypeTablId(\RestaurantBundle\Entity\TypeTabl $typeTablId = null)
    {
        $this->typeTablId = $typeTablId;

        return $this;
    }

    /**
     * Get typeTablId
     *
     * @return \RestaurantBundle\Entity\TypeTabl
     */
    public function getTypeTablId()
    {
        return $this->typeTablId;
    }

    /**
     * Set tablId
     *
     * @param \RestaurantBundle\Entity\Tabl $tablId
     *
     * @return TablTypeTabl
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
