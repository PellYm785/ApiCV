<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Niveaucomp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;

class NiveauCompController extends Controller
{
    /**
     * @Get(
     *     path = "/niveaucomps/{id}",
     *     name = "niveaucomp_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Niveaucomp $niveaucomp)
    {
        return $niveaucomp;
    }

    /**
     * @Get(
     *     path = "/niveaucomps",
     *     name = "niveaucomp_list",
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function listAction()
    {
        $niveaucomps = $this->getDoctrine()
            ->getRepository('AppBundle:Niveaucomp')
            ->findAll();

        return $niveaucomps;
    }
}
