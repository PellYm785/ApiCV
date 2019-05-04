<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Niveaucomp
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "niveaucomp_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "modify",
 *      href = @Hateoas\Route(
 *          "niveaucomp_update",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "niveaucomp_delete",
 *          parameters = { "id" = "expr(object.getId())" }
 *     )
 * )
 * @ORM\Table(name="niveaucomp")
 * @ORM\Entity
 */
class Niveaucomp
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
     * @ORM\Column(name="niveau", type="string", length=20, nullable=false)
     * @Assert\NotBlank(groups={"Create"})
     */
    private $niveau;


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
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param string $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }


}

