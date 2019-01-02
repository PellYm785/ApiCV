<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Competence
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenceRepository")
 *
 * @ORM\Table(name="competence", indexes={@ORM\Index(name="lien_comp_type", columns={"type"}), @ORM\Index(name="lien_comp_niveau", columns={"niveau"}), @ORM\Index(name="competences_competences_id_comp_fk", columns={"langage"})})
 *
 */
class Competence
{
    /**
     * @var integer
     *
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="id_comp", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComp;

    /**
     * @var string
     *
     * @Groups({"GET_LIST"})
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $nom;

    /**
     * @var \AppBundle\Entity\Competence
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Competence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="langage", referencedColumnName="id_comp")
     * })
     *
     *
     */
    private $langage;

    /**
     * @var \AppBundle\Entity\Niveaucomp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Niveaucomp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveau", referencedColumnName="id")
     * })
     */
    private $niveau;

    /**
     * @var \AppBundle\Entity\Typecomp
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Typecomp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $type;

    /**
     * @return int
     */
    public function getIdComp()
    {
        return $this->idComp;
    }

    /**
     * @param int $idComp
     */
    public function setIdComp($idComp)
    {
        $this->idComp = $idComp;
    }

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
     * @return Competence
     */
    public function getLangage()
    {
        return $this->langage;
    }

    /**
     * @param Competence $langage
     */
    public function setLangage($langage)
    {
        $this->langage = $langage;
    }

    /**
     * @return Niveaucomp
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param Niveaucomp $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    /**
     * @return Typecomp
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Typecomp $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



}

