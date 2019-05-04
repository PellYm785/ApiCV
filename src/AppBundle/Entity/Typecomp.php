<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Typecomp
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "typecomp_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "modify",
 *      href = @Hateoas\Route(
 *          "typecomp_update",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "typecomp_delete",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 * @ORM\Table(name="typecomp")
 * @ORM\Entity
 */
class Typecomp
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=72, nullable=false)
     * @Assert\NotBlank(groups={"Create"})
     */
    private $type;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

}

