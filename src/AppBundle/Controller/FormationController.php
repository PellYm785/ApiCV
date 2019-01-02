<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;

class FormationController extends Controller
{
    /**
     * @Get(
     *     path = "/formations/{id}",
     *     name = "formation_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(
     *     statusCode = 201
     * )
     */
    public function showAction(Formation $formation)
    {
        return $formation;
    }

    /**
     * @Get(
     *     path = "/formations",
     *     name = "formation_list",
     * )
     * @View(
     *     statusCode = 201,
     *     serializerGroups={"GET_LIST"}
     * )
     */
    public function listAction()
    {
        $formations = $this->getDoctrine()
            ->getRepository('AppBundle:Formation')
            ->findAll();

        return $formations;
    }
}
