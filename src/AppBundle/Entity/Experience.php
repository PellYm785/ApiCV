<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Experience
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "experience_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "modify",
 *      href = @Hateoas\Route(
 *          "experience_update",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "experience_delete",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @ORM\Table(name="experience")
 * @ORM\Entity
 */
class  Experience
{
    /**
     * @var integer
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255, nullable=false)
     *
     * @Groups({"GET_LIST"})
     * @Assert\NotBlank(groups={"Create"})
     */
    private $poste;

    /**
     * @var string
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="organisation", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $organisation;

    /**
     * @var string
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="date", nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="date", nullable=true)
     */
    private $fin;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * @param string $poste
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;
    }

    /**
     * @return string
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param string $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * @param \DateTime $debut
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;
    }

    /**
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * @param \DateTime $fin
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
    }

}

