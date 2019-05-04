<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Formation
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "formation_show",
 *          parameters = { "id" = "expr(object.getIdForm())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "modify",
 *      href = @Hateoas\Route(
 *          "formation_update",
 *          parameters = { "id" = "expr(object.getIdForm())" }
 *     )
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "formation_delete",
 *          parameters = { "id" = "expr(object.getIdForm())" }
 *     )
 * )
 * @ORM\Table(name="formation")
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var integer
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="id_form", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idForm;

    /**
     * @var string
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="nom", type="string", length=9, nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $nom;

    /**
     * @var string
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="etablissement", type="string", length=25, nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $etablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=8, nullable=false)
     * @Assert\NotBlank(groups={"Create"})
     */
    private $ville;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="date", nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=21, nullable=true)
     */
    private $commentaire;



    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param string $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
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

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return int
     */
    public function getIdForm()
    {
        return $this->idForm;
    }

    /**
     * @param int $idForm
     */
    public function setIdForm($idForm)
    {
        $this->idForm = $idForm;
    }




}

